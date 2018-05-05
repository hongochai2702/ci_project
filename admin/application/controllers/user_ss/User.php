<?php
class User extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
	}
	private $error = array();

	public function index() {
		$this->lang->load('user/user');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_model');

		$this->getList();
	}

	public function add() {
		$this->lang->load('user/user');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->user_model->addUser($this->input->post());

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

			redirect(base_url('user/user?user_token=' . $this->session->userdata('user_token') ));
		}

		$this->getForm();
	}

	public function edit() {
		$this->lang->load('user/user');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->user_model->editUser($this->input->get('user_id'), $this->input->post());

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
			$this->response->redirect(base_url('user/user/edit?user_token=' . $this->session->userdata('user_token') . '&user_id=' . $this->input->get('user_id') . $url));
		}

		$this->getForm();
	}

	public function delete() {
		$this->lang->load('user/user');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('user/user_model');

		if (($this->input->post['selected']) && $this->validateDelete()) {
			foreach ($this->input->post['selected'] as $user_id) {
				$this->user_model->deleteUser($user_id);
			}

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if (($this->input->get('order'))) {
				$url .= '&order=' . $this->input->get('order');
			}

			if (($this->input->get('page'))) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect(base_url('user/user?user_token=' . $this->session->userdata('user_token') ));
		}

		$this->getList();
	}

	protected function getList() {
		if ($this->user->hasPermission('modify', 'user/User')) {
			$data['permission'] = true;
		} else {
			$data['permission'] = false;
		}
		if (($this->input->get('sort'))) {
			$sort = $this->input->get('sort');
		} else {
			$sort = 'username';
		}

		if (($this->input->get('order'))) {
			$order = $this->input->get('order');
		} else {
			$order = 'ASC';
		}

		if (($this->input->get('page'))) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		$url = '';

		if (($this->input->get('sort'))) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if (($this->input->get('order'))) {
			$url .= '&order=' . $this->input->get('order');
		}

		if (($this->input->get('page'))) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => base_url('common/dashboard?user_token=' . $this->session->userdata('user_token'), 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('user/user?user_token=' . $this->session->userdata('user_token') )
		);

		// $data['add'] = base_url('user/user/add?user_token=' . $this->session->userdata('user_token') );
		$data['add'] = 'app.user/add';
		$data['delete'] = base_url('user/user/delete?user_token=' . $this->session->userdata('user_token') );

		$data['users'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit' => $this->configs->get('config_limit_admin')
		);

		$user_total = $this->user_model->getTotalUsers();

		$results = $this->user_model->getUsers($filter_data);

		


	

		$this->load->model('tool/model_tool_image');
		foreach ($results as $result) {

			if (!empty($result['image']) && $result['image'] && is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 200, 200);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 200, 200);
			}
			$data['users'][] = array(
				'user_id'    => $result['user_id'],
				'image' => $image,
				'username'   => $result['username'],
			
				'lastname'	=> $result['lastname'],
				'firstname' => $result['firstname'],
				'status'     => ($result['status'] ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled')),
				'date_added' => date($this->lang->line('date_format_short'), strtotime($result['date_added'])),
				// 'edit'       => base_url('user/user/edit?user_token=' . $this->session->userdata('user_token') . '&user_id=' . $result['user_id'] )
				'edit' =>  'app.user.user/edit({code:'   ."'". $result['user_id'].$url."'". '})',
			);
		}

		$data['heading_title'] = $this->lang->line('heading_title');
		
		$data['text_list'] = $this->lang->line('text_list');
		$data['text_no_results'] = $this->lang->line('text_no_results');
		$data['text_confirm'] = $this->lang->line('text_confirm');

		$data['column_username'] = $this->lang->line('column_username');
		$data['column_status'] = $this->lang->line('column_status');
		$data['column_date_added'] = $this->lang->line('column_date_added');
		$data['column_action'] = $this->lang->line('column_action');

		$data['button_add'] = $this->lang->line('button_add');
		$data['button_edit'] = $this->lang->line('button_edit');
		$data['button_delete'] = $this->lang->line('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (($this->session->userdata('success'))) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}

		if (($this->input->post['selected'])) {
			$data['selected'] = (array)$this->input->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (($this->input->get('page'))) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['sort_username'] = base_url('user/user?user_token=' . $this->session->userdata('user_token') . '&sort=username' );
		$data['sort_status'] = base_url('user/user?user_token=' . $this->session->userdata('user_token') . '&sort=status' );
		$data['sort_date_added'] = base_url('user/user?user_token=' . $this->session->userdata('user_token') . '&sort=date_added' );

		$url = '';

		if (($this->input->get('sort'))) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if (($this->input->get('order'))) {
			$url .= '&order=' . $this->input->get('order');
		}

		//$pagination = new Pagination();
		$pagination->total = $user_total;
		$pagination->page = $page;
		$pagination->limit = $this->configs->get('config_limit_admin');
		$pagination->url = 'app.user.user/page({code:{page}})';

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->lang->line('text_pagination'), ($user_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($user_total - $this->configs->get('config_limit_admin'))) ? $user_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $user_total, ceil($user_total / $this->configs->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->response->setOutput($this->load->view('user/user_list', $data));
	}

	protected function getForm() {

		if ($this->user->hasPermission('modify', 'user/User')) {
			$data['permission'] = true;
		} else {
			$data['permission'] = false;
		}
		if ($this->input->get('user_id')) {
			$data['user_id'] = $this->input->get('user_id');
		} else {
			$data['user_id'] = 0;
		}
		$data['heading_title'] = $this->lang->line('heading_title');
		
		$data['text_form'] = !isset($this->input->get['user_id']) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');

		$data['entry_username'] = $this->lang->line('entry_username');
		$data['entry_position'] = $this->lang->line('entry_position');
		$data['entry_user_group'] = $this->lang->line('entry_user_group');
		$data['entry_password'] = $this->lang->line('entry_password');
		$data['entry_confirm'] = $this->lang->line('entry_confirm');
		$data['entry_firstname'] = $this->lang->line('entry_firstname');
		$data['entry_lastname'] = $this->lang->line('entry_lastname');
		$data['entry_email'] = $this->lang->line('entry_email');
		$data['entry_image'] = $this->lang->line('entry_image');
		$data['entry_status'] = $this->lang->line('entry_status');

		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}
		if (isset($this->error['position'])) {
			$data['error_position'] = $this->error['position'];
		} else {
			$data['error_position'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}
		

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
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
			'href' => base_url('common/dashboard?user_token=' . $this->session->userdata('user_token'), 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('user/user?user_token=' . $this->session->userdata('user_token') )
		);

		if (!$this->input->get('user_id')) {
			$data['action'] = base_url('user/user/add?user_token=' . $this->session->userdata('user_token') );
		} else {
			$data['action'] = base_url('user/user/edit?user_token=' . $this->session->userdata('user_token') . '&user_id=' . $this->input->get('user_id').$url);
		}
		$data['save'] = base_url('user/user?user_token=' . $this->session->userdata('user_token') . $url);
		$data['cancel'] = 'app.user.user/page({code:' ."'"  .$url.  "'". '})';
		if (($this->input->get('user_id')) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$user_info = $this->user_model->getUser($this->input->get('user_id'));
		}

		if (($this->input->post['username'])) {
			$data['username'] = $this->input->post['username'];
		} elseif (!empty($user_info)) {
			$data['username'] = $user_info['username'];
		} else {
			$data['username'] = '';
		}
	
		if ($this->input->post('user_group_id')) {
			$data['user_group_id'] = $this->input->post('user_group_id');
		} elseif (!empty($user_info)) {
			$data['user_group_id'] = $user_info['user_group_id'];
		} else {
			$data['user_group_id'] = '';
		}

		$this->load->model('user/user_group_model');

		$data['user_groups'] = $this->user_group_model->getUserGroups();

		if ($this->input->post('password')) {
			$data['password'] = $this->input->post('password');
		} else {
			$data['password'] = '';
		}

		if ($this->input->post('confirm')) {
			$data['confirm'] = $this->input->post('confirm');
		} else {
			$data['confirm'] = '';
		}

		if (($this->input->post['firstname'])) {
			$data['firstname'] = $this->input->post('firstname');
		} elseif (!empty($user_info)) {
			$data['firstname'] = $user_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (($this->input->post['lastname'])) {
			$data['lastname'] = $this->input->post('lastname');
		} elseif (!empty($user_info)) {
			$data['lastname'] = $user_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (($this->input->post['email'])) {
			$data['email'] = $this->input->post('email');
		} elseif (!empty($user_info)) {
			$data['email'] = $user_info['email'];
		} else {
			$data['email'] = '';
		}

		if (($this->input->post['image'])) {
			$data['image'] = $this->input->post('image');
		} elseif (!empty($user_info)) {
			$data['image'] = $user_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/model_tool_image');

		if (($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->input->post('image'), 100, 100);
		} elseif (!empty($user_info) && $user_info['image'] && is_file(DIR_IMAGE . $user_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($user_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (($this->input->post['status'])) {
			$data['status'] = $this->input->post['status'];
		} elseif (!empty($user_info)) {
			$data['status'] = $user_info['status'];
		} else {
			$data['status'] = 0;
		}

		
		$this->response->setOutput($this->load->view('user/user_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/User')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((strlen($this->input->post('username')) < 3) || (strlen($this->input->post['username']) > 20)) {
			$this->error['username'] = $this->lang->line('error_username');
		}
		if ((strlen($this->input->post('position')) < 3) || (strlen($this->input->post['position']) > 20)) {
			$this->error['position'] = $this->lang->line('error_position');
		}

		$user_info = $this->user_model->getUserByUsername($this->input->post['username']);

		if (!($this->input->get('user_id'))) {
			if ($user_info) {
				$this->error['warning'] = $this->lang->line('error_exists');
			}
		} else {
			if ($user_info && ($this->input->get('user_id') != $user_info['user_id'])) {
				$this->error['warning'] = $this->lang->line('error_exists');
			}
		}

		if ((strlen(trim($this->input->post('firstname'))) < 1) || (strlen(trim($this->input->post('firstname'))) > 32)) {
			$this->error['firstname'] = $this->lang->line('error_firstname');
		}

		if ((strlen(trim($this->input->post('lastname'))) < 1) || (strlen(trim($this->input->post('lastname'))) > 32)) {
			$this->error['lastname'] = $this->lang->line('error_lastname');
		}

		if (($this->input->post('password') || (!$this->input->get('user_id')))) {
			if (((strlen($this->input->post('password'))) < 4) || (strlen($this->input->post('password')) > 20)) {
				$this->error['password'] = $this->lang->line('error_password');
			}

			if ($this->input->post('password') != $this->input->post('confirm')) {
				$this->error['confirm'] = $this->lang->line('error_confirm');
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'user/User')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		foreach ($this->input->post('selected') as $user_id) {
			if ($this->user->getId() == $user_id) {
				$this->error['warning'] = $this->lang->line('error_account');
			}
		}

		return !$this->error;
	}
}