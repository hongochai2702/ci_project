<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Layout extends MX_Controller {
		public function __construct(){
			parent::__construct();
		}
		private $error = array();
		public function index() {
			$this->lang->load('design/layout');
			$this->document->setTitle($this->lang->line('heading_title'));
			
			$this->load->model('design/layout_model');
			$this->getList();
		}
		public function add() {
			$this->lang->load('design/layout');
			$this->document->setTitle($this->lang->line('heading_title'));
			$this->load->model('design/layout_model');
			if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->layout_model->addLayout($this->input->post);
				// $this->session->userdata('success') = $this->lang->line('text_success');
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
				$this->response->redirect($this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}
			$this->getForm();
		}
		public function edit() {
			$this->lang->load('design/layout');
			$this->document->setTitle($this->lang->line('heading_title'));
			$this->load->model('design/layout_model');
			$session_success = $this->session->userdata('success');
			
			if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->layout_model->editLayout($this->input->get('layout_id'), $this->input->post());
				$session_success = $this->lang->line('text_success');
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
				$this->response->redirect($this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}
			$this->getForm();
		}
		public function delete() {
			$this->load->language('design/layout');
			$this->document->setTitle($this->lang->line('heading_title'));
			$this->load->model('design/layout');
			if ($this->input->post('selected') && $this->validateDelete()) {
				foreach ($this->input->post('selected') as $layout_id) {
					$this->layout_model->deleteLayout($layout_id);
				}
				// $this->session->userdata('success') = $this->lang->line('text_success');
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
				$this->response->redirect($this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}
			$this->getList();
		}
		protected function getList() {
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
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);
			$data = array_merge($data, $this->lang->loadAll());
			$data['add'] = $this->url->link('design/layout/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['delete'] = $this->url->link('design/layout/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['layouts'] = array();
			$filter_data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
				'limit' => $this->configs->get('config_limit_admin')
			);
			$layout_total = $this->layout_model->getTotalLayouts();
			$results = $this->layout_model->getLayouts($filter_data);
			foreach ($results as $result) {
				$data['layouts'][] = array(
					'layout_id' => $result['layout_id'],
					'name'      => $result['name'],
					'edit'      => $this->url->link('design/layout/edit', 'user_token=' . $this->session->userdata('user_token') . '&layout_id=' . $result['layout_id'] . $url, true)
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
				// unset($this->session->userdata('success'));
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
			$data['sort_name'] = $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . '&sort=name' . $url, true);
			$url = '';
			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}
			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}
            $this->load->library('pagination');
            $pagination = new Pagination();
			$pagination->total = $layout_total;
			$pagination->page = $page;
			$pagination->limit = $this->configs->get('config_limit_admin');
			$pagination->url = $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);
			$data['pagination'] = $pagination->render();
			$data['results'] = sprintf($this->lang->line('text_pagination'), ($layout_total) ? (($page - 1) * 15) + 1 : 0, ((($page - 1) * 15) > ($layout_total - 15)) ? $layout_total : ((($page - 1) * 15) + 15), $layout_total, ceil($layout_total / 15));
			$data['sort'] = $sort;
			$data['order'] = $order;
		$data['header'] = $this->load->controller('common/Header');
		$data['column_left'] = $this->load->controller('common/Column_left');
			
			$data['footer'] = $this->load->controller('common/footer');
			$this->load->view('design/layout_list', $data);
		}
		protected function getForm() {
			$data['text_form'] = !$this->input->get('layout_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
			$data = array_merge($data, $this->lang->loadAll());
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
			$data['breadcrumbs'] = array();
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
			);
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);
			if (!$this->input->get('layout_id')) {
				$data['action'] = $this->url->link('design/layout/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			} else {
				$data['action'] = $this->url->link('design/layout/edit', 'user_token=' . $this->session->userdata('user_token') . '&layout_id=' . $this->input->get('layout_id') . $url, true);
			}
			$data['cancel'] = $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['token'] = $this->session->userdata('user_token');
			$this->load->model('designs/layout_model', 'layout_model');
			if ($this->input->get('layout_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
				$layout_info = $this->layout_model->getLayout($this->input->get('layout_id'));
			}
			if ($this->input->post('name')) {
				$data['name'] = $this->input->post('name');
			} elseif (!empty($layout_info)) {
				$data['name'] = $layout_info['name'];
			} else {
				$data['name'] = '';
			}
			// $this->load->model('setting/store');
			$data['stores'][] = array( 'name' => 'Default', 'store_id' => 1 );
			if ($this->input->post('layout_route')) {
				$data['layout_routes'] = $this->input->post('layout_route');
			} elseif ($this->input->get('layout_id')) {
				$data['layout_routes'] = $this->layout_model->getLayoutRoutes($this->input->get('layout_id'));
			} else {
				$data['layout_routes'] = array();
			}
			$this->load->model('extension/extension_model');
			$this->load->model('extension/module_model','extension_module_model');
			$data['extensions'] = array();
			// Get a list of installed modules
			$extensions = $this->extension_model->getInstalled('module');
			
			// Add all the modules which have multiple settings for each module
			foreach ($extensions as $code) {
				$this->lang->load('extension/module/' . $code);
				$module_data = array();
				$modules = $this->extension_module_model->getModulesByCode($code);
				foreach ($modules as $module) {
					$module_data[] = array(
						'name' => strip_tags($module['name']),
						'code' => $code . '.' .  $module['module_id']
					);
				}
				if ($this->configs->has($code . '_status') || $module_data) {
					$data['extensions'][] = array(
						'name'   => strip_tags($this->lang->line('heading_title')),
						'code'   => $code,
						'module' => $module_data
					);
				}
			}
			// Modules layout
			if ($this->input->post('layout_module')) {
				$layout_modules = $this->input->post('layout_module');
			} elseif ($this->input->get('layout_id')) {
				$layout_modules = $this->layout_model->getLayoutModules($this->input->get('layout_id'));
				// var_dump($layout_modules);
			} else {
				$layout_modules = array();
			}
			$data['layout_modules'] = array();
			// Add all the modules which have multiple settings for each module
			foreach ($layout_modules as $layout_module) {
				$part = explode('.', $layout_module['code']);
					
				$this->lang->load('extension/module/' . $part[0]);
				
				if (!isset($part[1])) {
					$data['layout_modules'][] = array(
						'name'       => strip_tags($this->lang->line('heading_title')),
						'code'       => $layout_module['code'],
						'edit'       => $this->url->link('extension/module/' . $part[0], 'user_token=' . $this->session->userdata('user_token'), true),
						'position'   => $layout_module['position'],
						'sort_order' => $layout_module['sort_order']
					);
				} else {
					$module_info = $this->extension_module_model->getModule($part[1]);
					if ($module_info) {
						$data['layout_modules'][] = array(
							'name'       => strip_tags($module_info['name']),
							'code'       => $layout_module['code'],
							'edit'       => $this->url->link('extension/module/' . $part[0], 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $part[1], true),
							'position'   => $layout_module['position'],
							'sort_order' => $layout_module['sort_order']
						);
					}				
				}
			}		
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view('design/layout_form', $data));
		}
		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'design/layout')) {
				$this->error['warning'] = $this->lang->line('error_permission');
			}
			if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
				$this->error['name'] = $this->lang->line('error_name');
			}
			return !$this->error;
		}
		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'design/layout')) {
				$this->error['warning'] = $this->lang->line('error_permission');
			}
			$this->load->model('setting/store');
			$this->load->model('catalog/product');
			$this->load->model('catalog/category');
			$this->load->model('catalog/information');
			foreach ($this->input->post('selected') as $layout_id) {
				if ($this->config->get('config_layout_id') == $layout_id) {
					$this->error['warning'] = $this->lang->line('error_default');
				}
				$store_total = $this->model_setting_store->getTotalStoresByLayoutId($layout_id);
				if ($store_total) {
					$this->error['warning'] = sprintf($this->lang->line('error_store'), $store_total);
				}
				$product_total = $this->model_catalog_product->getTotalProductsByLayoutId($layout_id);
				if ($product_total) {
					$this->error['warning'] = sprintf($this->lang->line('error_product'), $product_total);
				}
				$category_total = $this->model_catalog_category->getTotalCategoriesByLayoutId($layout_id);
				if ($category_total) {
					$this->error['warning'] = sprintf($this->lang->line('error_category'), $category_total);
				}
				$information_total = $this->model_catalog_information->getTotalInformationsByLayoutId($layout_id);
				if ($information_total) {
					$this->error['warning'] = sprintf($this->lang->line('error_information'), $information_total);
				}
			}
			return !$this->error;
		}
	}