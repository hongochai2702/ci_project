<?php
class Menu extends MX_Controller {

	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	private $error = array();
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function index() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		$this->getList();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->addMenu($this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
			if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
			if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
			$this->response->redirect($this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->getForm();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function edit() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->editMenu($this->input->get('menu_id'), $this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
			if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
			if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
			$this->response->redirect($this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->getForm();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if ($this->input->post('selected') && $this->validateDelete()) {
			foreach ($this->input->post['selected'] as $menu_id) {
				$this->model_design_menu->deleteMenu($menu_id);
			}
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
			if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
			if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
			$this->response->redirect($this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->getList();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getList() {
		if ($this->input->get('sort')) { $sort = $this->input->get('sort'); } else { $sort = 'name'; }
		if ($this->input->get('order')) { $order = $this->input->get('order'); } else { $order = 'ASC'; }
		if ($this->input->get('page')) { $page = $this->input->get('page'); } else { $page = 1; }
		$url = '';
		if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
		if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
		if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);
		
		$data['add'] = $this->url->link('design/menu/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['delete'] = $this->url->link('design/menu/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['user_token'] = $this->session->userdata('user_token');
		$data['menus'] = array();
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit' => $this->configs->get('config_limit_admin')
		);
		$layout_total = $this->model_design_menu->getTotalMenus();
		$results = $this->model_design_menu->getMenus($filter_data);
		foreach ($results as $result) {
			if($result['type']=='horizontal'){ $types = $this->lang->line('input_horizontal'); }
			if($result['type']=='vertical'){ $types = $this->lang->line('input_vertical'); }
			if($result['type']=='mega'){ $types = $this->lang->line('input_mega'); }
			$data['menus'][] = array(
				'menu_id' => $result['menu_id'],
				'name'      => $result['name'],
				'type'      => $types,
				'edit'      => $this->url->link('design/menu/edit', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $result['menu_id'] . $url, true),
				'group'      => $this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $result['menu_id'] . $url, true)
			);
		}
		
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_list'] = $this->lang->line('text_list');
		$data['text_no_results'] = $this->lang->line('text_no_results');
		$data['text_confirm'] = $this->lang->line('text_confirm');
		$data['column_name'] = $this->lang->line('column_name');
		$data['column_type'] = $this->lang->line('column_type');
		$data['column_action'] = $this->lang->line('column_action');
		$data['button_group'] = $this->lang->line('button_group');
		$data['button_add'] = $this->lang->line('button_add');
		$data['button_edit'] = $this->lang->line('button_edit');
		$data['button_delete'] = $this->lang->line('button_delete');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if ($this->session->userdata('success')) { $data['success'] = $this->session->userdata('success'); $this->session->unset_userdata('success'); } else { $data['success'] = ''; }
		if ($this->input->post('selected')) { $data['selected'] = (array)$this->input->post['selected']; } else { $data['selected'] = array(); }
		$url = '';
		if ($order == 'ASC') { $url .= '&order=DESC'; } else { $url .= '&order=ASC'; }
		if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
		$data['sort_name'] = $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . '&sort=name' . $url, true);
		$url = '';
		if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
		if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
		
		$pagination = new Pagination();
		$pagination->total = $layout_total;
		$pagination->page = $page;
		$pagination->limit = $this->configs->get('config_limit_admin');
		$pagination->url = $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);
		$data['pagination'] = $pagination->render();
		
		$data['results'] = sprintf($this->lang->line('text_pagination'), ($layout_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($layout_total - $this->configs->get('config_limit_admin'))) ? $layout_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $layout_total, ceil($layout_total / $this->configs->get('config_limit_admin')));
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->view('design/menu_list', $data);
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getForm() {
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_form'] = !$this->input->get('menu_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		$data['text_default'] = $this->lang->line('text_default');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');
		$data['text_content_top'] = $this->lang->line('text_content_top');
		$data['text_content_bottom'] = $this->lang->line('text_content_bottom');
		$data['text_column_left'] = $this->lang->line('text_column_left');
		$data['text_column_right'] = $this->lang->line('text_column_right');
		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_code'] = $this->lang->line('entry_code');
		$data['entry_type'] = $this->lang->line('entry_type');
		$data['entry_picture'] = $this->lang->line('entry_picture');
		$data['entry_image'] = $this->lang->line('entry_image');
		$data['entry_status'] = $this->lang->line('entry_status');
		$data['entry_sort_order'] = $this->lang->line('entry_sort_order');
		$data['input_horizontal'] = $this->lang->line('input_horizontal');
		$data['input_vertical'] = $this->lang->line('input_vertical');
		$data['input_style'] = $this->lang->line('input_style');
		$data['input_style_tabbed'] = $this->lang->line('input_style_tabbed');
		$data['input_style_dropdown'] = $this->lang->line('input_style_dropdown');
		$data['input_style_lists'] = $this->lang->line('input_style_lists');
		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');
		$data['button_route_add'] = $this->lang->line('button_route_add');
		$data['button_module_add'] = $this->lang->line('button_module_add');
		$data['button_remove'] = $this->lang->line('button_remove');
		$data['user_token'] = $this->session->userdata('user_token');
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = ''; }
		if (isset($this->error['code'])) { $data['error_code'] = $this->error['code']; } else { $data['error_code'] = array(); }
		$url = '';
		if ($this->input->get('sort')) { $url .= '&sort=' . $this->input->get('sort'); }
		if ($this->input->get('order')) { $url .= '&order=' . $this->input->get('order'); }
		if ($this->input->get('page')) { $url .= '&page=' . $this->input->get('page'); }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);
		
		if (!$this->input->get('menu_id')) {
			$data['action'] = $this->url->link('design/menu/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		} else {
			$data['action'] = $this->url->link('design/menu/edit', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id') . $url, true);
		}
		
		$data['cancel'] = $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		
		if ($this->input->get('menu_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$menu_info = $this->model_design_menu->getMenu($this->input->get('menu_id'));
		}
		
		if ($this->input->get('image')) { $data['image'] = $this->input->get('image'); } elseif (!empty($menu_info)) { $data['image'] = $menu_info['image']; } else { $data['image'] = ''; }
		$this->load->model('tool/image_model','model_tool_image');
		if ($this->input->get('image') && is_file(DIR_IMAGE . $this->input->get('image'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->input->get('image'), 100, 100);
		} elseif (!empty($menu_info) && is_file(DIR_IMAGE . $menu_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($menu_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if ($this->input->post('name')) { $data['name'] = $this->input->post('name'); } elseif (!empty($menu_info)) { $data['name'] = $menu_info['name']; } else { $data['name'] = ''; }
		if ($this->input->post('code')) { $data['code'] = $this->input->post('code'); } elseif (!empty($menu_info)) { $data['code'] = $menu_info['code']; } else { $data['code'] = ''; }
		if ($this->input->post('type')) { $data['type'] = $this->input->post('type'); } elseif (!empty($menu_info)) { $data['type'] = $menu_info['type']; } else { $data['type'] = ''; }
		if ($this->input->post('picture')) { $data['picture'] = $this->input->post['picture']; } elseif (!empty($menu_info)) { $data['picture'] = $menu_info['picture']; } else { $data['picture'] = ''; }
		if ($this->input->post('status')) { $data['status'] = $this->input->post['status']; } elseif (!empty($menu_info)) { $data['status'] = $menu_info['status']; } else { $data['status'] = true; }
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->load->view('design/menu_form', $data);
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/menu')) { $this->error['warning'] = $this->lang->line('error_permission'); }
		if($this->input->post('code')){
			if ((utf8_strlen($this->input->post('code')) < 1) || (utf8_strlen($this->input->post('code')) > 64)) { $this->error['code'] = $this->lang->line('error_code'); }
		}
		if($this->input->post('menu_group_description')){
			foreach ($this->input->post('menu_group_description') as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) { $this->error['name'][$language_id] = $this->lang->line('error_name'); }
			}
		}
		if($this->input->post('menu_group_languages')){
			foreach ($this->input->post('menu_group_languages') as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) { $this->error['name'][$language_id] = $this->lang->line('error_name'); }
			}
		}
		return !$this->error;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/menu')) { $this->error['warning'] = $this->lang->line('error_permission'); }
		return !$this->error;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function group() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		$this->getDesign();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleAdd() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupSingleAdd($this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->post('menu_id')) { $url .= '&menu_id=' . $this->input->post('menu_id'); }
			$this->response->redirect($this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleEdit() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupSingleEdit($this->input->get('menu_group_id'), $this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('menu_id')) { $url .= '&menu_id=' . $this->input->get('menu_id'); }
			$this->response->redirect($this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupMultipleAdd() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupMultipleAdd($this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->post('menu_id')) { $url .= '&menu_id=' . $this->input->post('menu_id'); }
			$this->response->redirect($this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupCompose() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_menu->groupCompose($this->input->post());
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('menu_id')) { $url .= '&menu_id=' . $this->input->get('menu_id'); }
			$this->response->redirect($this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupDelete() {
		$this->lang->load('design/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('design/menu_model','model_design_menu');
		
		if ($this->input->get('menu_group_id')) {
			$this->model_design_menu->groupDelete($this->input->get('menu_group_id'));
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$url = '';
			if ($this->input->get('menu_id')) { $url .= '&menu_id=' . $this->input->get('menu_id'); }
			$this->response->redirect($this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}
		$this->group();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function getDesign() {
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_form'] = !$this->input->get('menu_id') ? $this->lang->line('text_add') : $this->lang->line('text_design');
		$data['text_default'] = $this->lang->line('text_default');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');
		$data['text_select'] = $this->lang->line('text_select');
		$data['text_links'] = $this->lang->line('text_links');
		$data['text_product'] = $this->lang->line('text_product');
		$data['text_category'] = $this->lang->line('text_category');
		$data['text_information'] = $this->lang->line('text_information');
		$data['text_manufacturer'] = $this->lang->line('text_manufacturer');
		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_code'] = $this->lang->line('entry_code');
		$data['entry_status'] = $this->lang->line('entry_status');
		$data['entry_sort_order'] = $this->lang->line('entry_sort_order');
		$data['input_collective'] = $this->lang->line('input_collective');
		$data['input_type'] = $this->lang->line('input_type');
		$data['input_species'] = $this->lang->line('input_species');
		$data['input_module'] = $this->lang->line('input_module');
		$data['input_url'] = $this->lang->line('input_url');
		$data['input_keyword'] = $this->lang->line('input_keyword');
		$data['input_font'] = $this->lang->line('input_font');
		$data['input_image'] = $this->lang->line('input_image');
		$data['input_window'] = $this->lang->line('input_window');
		$data['input_fixed'] = $this->lang->line('input_fixed');
		$data['input_popup'] = $this->lang->line('input_popup');
		$data['input_style'] = $this->lang->line('input_style');
		$data['input_style_tabbed'] = $this->lang->line('input_style_tabbed');
		$data['input_style_dropdown'] = $this->lang->line('input_style_dropdown');
		$data['input_style_lists'] = $this->lang->line('input_style_lists');
		$data['button_finished'] = $this->lang->line('button_finished');
		$data['button_expand'] = $this->lang->line('button_expand');
		$data['text_confirm'] = $this->lang->line('text_confirm');
		$data['button_collapse'] = $this->lang->line('button_collapse');
		$data['button_finished'] = $this->lang->line('button_finished');
		$data['button_menu_add'] = $this->lang->line('button_menu_add');
		$data['button_menu'] = !$this->input->get('menu_group_id') ? $this->lang->line('button_menu_add') : $this->lang->line('button_menu_save');
		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');
		$data['button_remove'] = $this->lang->line('button_remove');
		$data['user_token'] = $this->session->userdata('user_token');

		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if ($this->session->userdata('success')) { $data['success'] = $this->session->userdata('success'); $this->session->unset_userdata('success'); } else { $data['success'] = ''; }
		
		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = array(); }
		


		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token'), true)
		);
		
		$data['groupSingleAdd'] = $this->url->link('design/menu/groupSingleAdd', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id'), true);
		$data['groupMultipleAdd'] = $this->url->link('design/menu/groupMultipleAdd', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id'), true);
		$data['cancel'] = $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['token'] = $this->session->userdata('user_token');
		
		if ($this->input->get('menu_id') ) {
		
			$data['menu_info'] = $this->model_design_menu->getMenu($this->input->get('menu_id'));
			$data['group_compose'] = $this->url->link('design/menu/groupCompose', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id'), true);
			$data['group_lists'] = $this->contentParentHtml($this->input->get('menu_id'), 0);
			
			if ($this->input->get('menu_group_id') ) {
				$menu_group_info = $this->model_design_menu->getGroup($this->input->get('menu_group_id'));
				$data['menu_group']  = $this->model_design_menu->getGroup($this->input->get('menu_group_id'));
				
				
				if ($this->input->post('menu_group_languages')) {
					$data['menu_group_languages'] = $this->input->post['menu_group_languages'];
				} elseif ($this->input->get('menu_group_id')) {
					$data['menu_group_languages'] = $this->model_design_menu->getGroupDescriptions($this->input->get('menu_group_id'));
				} else {
					$data['menu_group_languages'] = array();
				}
				
				$data['groupSingleAdd'] = $this->url->link('design/menu/groupSingleEdit', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id') . '&menu_group_id=' . $this->input->get('menu_group_id'), true);
				$data['groupSingleCancel'] = $this->url->link('design/menu/group', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id'), true);
			}else{
				$data['menu_group']  = '';
			}
			
			if ($this->input->post('url')) { $data['url'] = $this->input->post['url']; } elseif (!empty($menu_group_info)) { $data['url'] = $menu_group_info['url']; } else { $data['url'] = ''; }
			if ($this->input->post('keyword')) { $data['keyword'] = $this->input->post['keyword']; } elseif (!empty($menu_group_info)) { $data['keyword'] = $menu_group_info['keyword']; } else { $data['keyword'] = ''; }
			if ($this->input->post('font')) { $data['font'] = $this->input->post['font']; } elseif (!empty($menu_group_info)) { $data['font'] = $menu_group_info['font']; } else { $data['font'] = ''; }
			if ($this->input->get('image')) { $data['image'] = $this->input->get('image'); } elseif (!empty($menu_group_info)) { $data['image'] = $menu_group_info['image']; } else { $data['image'] = ''; }
			if ($this->input->post('window')) { $data['window'] = $this->input->post['window']; } elseif (!empty($menu_group_info)) { $data['window'] = $menu_group_info['window']; } else { $data['window'] = ''; }
			if ($this->input->post('style')) { $data['style'] = $this->input->post['style']; } elseif (!empty($menu_group_info)) { $data['style'] = $menu_group_info['style']; } else { $data['style'] = ''; }
			if ($this->input->post('module_type')) { $data['module_type'] = $this->input->post['module_type']; } elseif (!empty($menu_group_info)) { $data['module_type'] = $menu_group_info['module_type']; } else { $data['module_type'] = ''; }
			if ($this->input->post('module_id')) { $data['module_id'] = $this->input->post['module_id']; } elseif (!empty($menu_group_info)) { $data['module_id'] = $menu_group_info['module_id']; } else { $data['module_id'] = ''; }
			
			$this->load->model('tool/image_model','model_tool_image');
			
			if ($this->input->get('image') && is_file(DIR_IMAGE . $this->input->get('image'))) {
				$data['thumb'] = $this->model_tool_image->resize($this->input->get('image'), 100, 100);
			} elseif (!empty($menu_group_info) && is_file(DIR_IMAGE . $menu_group_info['image'])) {
				$data['thumb'] = $this->model_tool_image->resize($menu_group_info['image'], 100, 100);
			} else {
				$data['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
			}
			$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
		
		}
		
		$this->document->addStyle('public/stylesheet/jquery-pg.nestable.css');
		$this->document->addStyle('public/stylesheet/jquery-pg.iconpicker.css');
		$this->document->addStyle('public/javascript/font-awesome/css/font-awesome.css');
		
		$this->document->addScript('public/javascript/jquery-pg.nestable.js');
		$this->document->addScript('public/javascript/jquery-pg.iconpicker.js');
		
		/// Languages
		$this->load->model('localisation/language_model','model_localisation_language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->load->view('design/menu_design', $data);
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function contentParentHtml($menu_id, $parent_id) {
		
		$outrun = "";
		$results = $this->model_design_menu->groupLists($menu_id, $parent_id);
		if( count($results) > 0 ){
			$outrun =array();
			$outrun ='<ol class="dd-list">';
			foreach ($results as $result) {
				$content_description= $this->contentDescriptions($result['module_type'], $result['menu_group_id']);
				$outrun .='<li class="dd-item dd3-item" data-id="'. $result['menu_group_id'] .'">';
				$outrun .='<div class="dd-handle dd3-handle"><i class="fa fa-bars"></i></div>';
				$outrun .='<div class="dd3-content">'. $content_description .'</div>';
				$outrun .='<div class="dd-edit"><a href="'. $this->url->link('design/menu/groupSingleEdit', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id') . '&menu_group_id=' . $result['menu_group_id'], true) .'"><i class="fa fa-pencil"></i></a></div>';
				$outrun .='<div class="dd-delete">
					<a href="'.$this->url->link('design/menu/groupDelete', 'user_token=' . $this->session->userdata('user_token') . '&menu_id=' . $this->input->get('menu_id') . '&menu_group_id=' . $result['menu_group_id'], true).'" onclick="return delete_ms();">
						<i class="fa fa-trash-o"></i>
					</a>
					</div>';
				$outrun .= $this->contentParentHtml($menu_id, $result['menu_group_id'] );
				$outrun .='</li>';
			}
			$outrun .='</ol>';
		}
		return $outrun;
		?>
	<?php }
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function contentDescriptions($menu_content_type, $module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$module_id . "' AND language_id ='" . (int)$this->configs->get('config_language_id') . "' ");

		foreach ($query->result_array() as $result) {
			$menu_content_description = $result['name'];
		}
		if(isset($menu_content_description)) {
			return $menu_content_description;
		}
		
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function species() {
	
		if($this->input->get('module_type') == "categoryblog"){
			$this->load->model('catalog/categoryblog_model','model_catalog_categoryblog');
			$results = $this->model_catalog_categoryblog->getCategories();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['category_id'] . '"';
				if ($this->input->get('module_id') == $result['category_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->output->set_content_type('text/html', 'UTF-8');
			$this->output->set_output($output);
		}
		
		if($this->input->get('module_type') == "blog"){
			$this->load->model('catalog/blog_model','model_catalog_blog');
			$results = $this->model_catalog_blog->getBlogs();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['product_id'] . '"';
				if ($this->input->get('module_id') == $result['product_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['name'] . '</option>';
			}
			$this->output->set_content_type('text/html', 'UTF-8');
			$this->output->set_output($output);
		}
		
		if($this->input->get('module_type') == "information"){
			$this->load->model('catalog/information_model','model_catalog_information');
			$results = $this->model_catalog_information->getInformations();
			$output='';
			foreach ($results as $result) {
				$output .= '<option value="' . $result['information_id'] . '"';
				if ($this->input->get('module_id') == $result['information_id']) { $output .= ' selected="selected"'; }
				$output .= '>' . $result['title'] . '</option>';
			}
			// $this->output->set_output($output);
			$this->output->set_content_type('text/html', 'UTF-8');
			$this->output->set_output($output);
		}
		
		// if($this->input->get('module_type') == "manufacturer"){
		// 	$this->load->model('catalog/manufacturer','model_catalog_manufacturer');
		// 	$results = $this->model_catalog_manufacturer->getManufacturers();
		// 	$output='';
		// 	foreach ($results as $result) {
		// 		$output .= '<option value="' . $result['manufacturer_id'] . '"';
		// 		if ($this->input->get('module_id') == $result['manufacturer_id']) { $output .= ' selected="selected"'; }
		// 		$output .= '>' . $result['name'] . '</option>';
		// 	}
		// 	$this->output->set_output($output);
		// }
	
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function moduleurl() {
	
		if($this->input->get('module_type') == "categoryblog"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$this->input->get('module_id') . "' ");
			$this->output->set_output('category_id=' . $query->row_array()['category_id']);
		}
		if($this->input->get('module_type') == "blog"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$this->input->get('module_id') . "' ");
			$this->output->set_output('product_id=' . $query->row_array()['product_id']);
		}
		if($this->input->get('module_type') == "information"){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information WHERE information_id = '" . (int)$this->input->get('module_id') . "' ");
			$this->output->set_output('information_id=' . $query->row_array()['information_id']);
		}
		// if($this->input->get('module_type') == "manufacturer"){
		// 	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$this->input->get('module_id') . "' ");
		// 	$this->output->set_output('manufacturer_id=' . $query->row['manufacturer_id']);
		// }
	
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function moduleseo() {
		if($this->input->get('module_url')){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = '" . $this->input->get('module_url') . "' ");
			$result = $query->row_array();
			if($result){ $this->output->set_output($result['keyword']); }
		}
	}
	
	//////////////////// 
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function autocompleteinformation() {
		$json = array();
		if ($this->input->get('filter_title')) {
			$this->load->model('catalog/information_model','model_catalog_information');
			$filter_data = array(
				'filter_title' => $this->input->get('filter_title'),
				'start' => 0,
				'limit' => 100
			);
			$results = $this->model_catalog_information->getInformations($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'information_id' => $result['information_id'],
					'title' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$sort_order = array();
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['title'];
		}
		array_multisort($sort_order, SORT_ASC, $json);
		$this->output->set_content_type('application/json', 'UTF-8');
		$this->output->set_output(json_encode($json));
	}

}