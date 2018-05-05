<?php
class User_permission extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
	}
	private $error = array();

	public function index() {
		$this->lang->load('user/user_group');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_group_model');

		$this->getList();
	}

	public function add() {
		$this->lang->load('user/user_group');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_group_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->user_group_model->addUserGroup($this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if (isset($this->input->get['sort'])) {
				$url .= '&sort=' . $this->input->get['sort'];
			}

			if (isset($this->input->get['order'])) {
				$url .= '&order=' . $this->input->get['order'];
			}

			if (isset($this->input->get['page'])) {
				$url .= '&page=' . $this->input->get['page'];
			}

			$this->response->redirect(base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url));
		}

		$this->getForm();
	}

	public function edit() {
		$this->lang->load('user/user_group');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_group_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->user_group_model->editUserGroup($this->input->get('user_group_id'), $this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect(base_url('user/user_permission/edit?user_token=' . $this->session->userdata('user_token') . '&user_group_id=' . $this->input->get('user_group_id') . $url));
		}

		$this->getForm();
	}

	public function delete() {
		$this->lang->load('user/user_group');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_group_model');

		if ($this->input->post('selected') && $this->validateDelete()) {
			foreach ($this->input->post('selected') as $user_group_id) {
				$this->user_group_model->deleteUserGroup($user_group_id);
			}

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect(base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url));
		}

		$this->getList();
	}

	protected function getList() {
		if ($this->user->hasPermission('modify', 'user/User')) {
			$data['permission'] = true;
		} else {
			$data['permission'] = false;
		}
		if ($this->input->get('sort')) {
			$sort = $this->input->get('sort');
		} else {
			$sort = 'name';
		}

		if ($this->input->get('order')) {
			$order = $this->input->get('order');
		} else {
			$order = 'ASC';
		}

		if ($this->input->get('page')) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => base_url('common/dashboard?user_token=' . $this->session->userdata('user_token'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url)
		);

		// $data['add'] = base_url('user/user_permission/add?user_token=' . $this->session->userdata('user_token') . $url);
		$data['add'] = 'app.user.usergroup/add';
		$data['delete'] = base_url('user/user_permission/delete?user_token=' . $this->session->userdata('user_token') . $url);

		$data['user_groups'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit' => $this->configs->get('config_limit_admin')
		);

		$user_group_total = $this->user_group_model->getTotalUserGroups();

		$results = $this->user_group_model->getUserGroups($filter_data);


		foreach ($results as $result) {
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name'],
				// 'edit'          => base_url('user/user_permission/edit?user_token=' . $this->session->userdata('user_token') . '&user_group_id=' . $result['user_group_id'] . $url),
				'edit' =>  'app.user.usergroup/edit({code:'   ."'". $result['user_group_id']. $url. "'". '})',
			);
		}

		$data['heading_title'] = $this->lang->line('heading_title');
		
		$data['text_list'] = $this->lang->line('text_list');
		$data['text_no_results'] = $this->lang->line('text_no_results');
		$data['text_confirm'] = $this->lang->line('text_confirm');

		$data['column_name'] = $this->lang->line('column_name');
		$data['column_action'] = $this->lang->line('column_action');

		$data['button_add'] = $this->lang->line('button_add');
		$data['button_edit'] = $this->lang->line('button_edit');
		$data['button_delete'] = $this->lang->line('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}


		

		if ($this->input->post('selected')) {
			$data['selected'] = (array)$this->input->post('selected');
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['sort_name'] = base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . '&sort=name' . $url);

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

	//	$pagination = new Pagination();
		$pagination->total = $user_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->configs->get('config_limit_admin');
		// $pagination->url = base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url . '&page={page}');

		$pagination->url = 'app.user.usergroup/page({code:{page}})';

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->lang->line('text_pagination'), ($user_group_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($user_group_total - $this->configs->get('config_limit_admin'))) ? $user_group_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $user_group_total, ceil($user_group_total / $this->configs->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		

		$this->response->setOutput($this->load->view('user/user_group_list', $data));
	}

	protected function getForm() {
		if ($this->user->hasPermission('modify', 'user/User')) {
			$data['permission'] = true;
		} else {
			$data['permission'] = false;
		}
		if ($this->input->get('user_group_id')) {
			$data['user_group_id'] = $this->input->get('user_group_id');
		} else {
			$data['user_group_id'] = 0;
		}
		$this->load->model('user_group_model');
		$data['heading_title'] = $this->lang->line('heading_title');
		
		$data['text_form'] = (!$this->input->get('user_group_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		$data['text_select_all'] = $this->lang->line('text_select_all');
		$data['text_unselect_all'] = $this->lang->line('text_unselect_all');

		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_access'] = $this->lang->line('entry_access');
		$data['entry_modify'] = $this->lang->line('entry_modify');

		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => base_url('common/dashboard?user_token=' . $this->session->userdata('user_token'))
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url)
		);

		if (!$this->input->get('user_group_id')) {
			$data['action'] = base_url('user/user_permission/add?user_token=' . $this->session->userdata('user_token') . $url);
		} else {
			$data['action'] = base_url('user/user_permission/edit?user_token=' . $this->session->userdata('user_token') . '&user_group_id=' . $this->input->get('user_group_id') . $url);
		}


		if (($this->input->get('user_group_id')) && $this->input->server('REQUEST_METHOD') != 'POST') {
			$user_group_info = $this->user_group_model->getUserGroup($this->input->get('user_group_id'));
		}

		$data['save'] = base_url('user/user_permission?user_token=' . $this->session->userdata('user_token') . $url);
		$data['cancel'] = 'app.user.usergroup/page({code:' ."'"  .$url.  "'". '})';
		

		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($user_group_info)) {
			$data['name'] = $user_group_info['name'];
		} else {
			$data['name'] = '';
		}

		$ignore = array(
			'common/dashboard',
			'common/startup',
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',
			'error/not_found',
			'error/permission',
			'common/footer',
			'common/header',
			'dashboard/order',
			'dashboard/sale',
			'dashboard/customer',
			'dashboard/online',
			'dashboard/map',
			'dashboard/activity',
			'dashboard/chart',
			'dashboard/recent'
		);

		$data['permissions'] = array();

		$files = glob(APPPATH . 'controllers/*/*.php');

		foreach ($files as $file) {
			$part = explode('/', dirname($file));

			$permission = end($part) . '/' . basename($file, '.php');

			if (!in_array($permission, $ignore)) {
				$data['permissions'][] = $permission;
			}
		}



		if ($this->input->post('permission')['access']) {
			$data['access'] = $this->input->post('permission')['access'];
		} elseif (isset($user_group_info['permission']['access'])) {
			$data['access'] = $user_group_info['permission']['access'];
		} else {
			$data['access'] = array();
		}

		// if ($this->input->post('permission')['modify']) {
		// 	$data['modify'] = $this->input->post('permission')['modify'];
		// } elseif (isset($user_group_info['permission']['modify'])) {
		// 	$data['modify'] = $user_group_info['permission']['modify'];
		// } else {
		// 	$data['modify'] = array();
		// }
		if ($this->input->post('permission')) {
			$data['modify'] = $this->input->post('permission');
		} elseif (isset($user_group_info['permission']['modify'])) {
			$data['modify'] = $user_group_info['permission']['modify'];
		} else {
			$data['modify'] = array();
		}


		

		$this->response->setOutput($this->load->view('user/user_group_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/User_permission')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((strlen($this->input->post('name')) < 3) || (strlen($this->input->post('name')) > 64)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'user/User_permission')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		$this->load->model('user/user_model');

		foreach ($this->input->post('selected') as $user_group_id) {
			$user_total = $this->user_model->getTotalUsersByGroupId($user_group_id);

			if ($user_total) {
				$this->error['warning'] = sprintf($this->lang->line('error_user'), $user_total);
			}
		}

		return !$this->error;
	}
}