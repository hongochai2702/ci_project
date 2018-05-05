<?php
	class BlogTest extends MX_Controller {

		private $error = array();

		public function index() {
			$this->lang->load('catalog/categoryblog');
			$data['heading_title'] = $this->lang->line('heading_title');
			$this->document->setTitle($this->lang->line('heading_title'));
			// $this->load->model('blogs/category_model');
			$this->load->model('catalog/category_model','model_catalog_category');
			$this->getList();
		}

		public function add() {
			$this->lang->load('catalog/categoryblog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('blogs/category_model');

			if (($this->input->userdata('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->model_catalog_category->addCategoryblog($this->input->post());

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

				redirect($this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getForm();
		}

		public function edit() {
			$this->lang->load('catalog/categoryblog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('blogs/category_model');

			if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->model_catalog_category->editCategoryblog($this->input->get('categoryblog_id'), $this->input->post());

				$this->session->set_userdata('success',$this->lang->line('text_success'));

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

				redirect($this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getForm();
		}

		public function delete() {
			$this->lang->load('catalog/categoryblog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/category_model','model_catalog_category');

			if (($this->input->post['selected']) && $this->validateDelete()) {
				file_put_contents(DIR_APPLICATION.'SSS', json_encode($this->input->post['selected']));
				foreach ($this->input->post['selected'] as $categoryblog_id) {
					$this->model_catalog_category->deleteCategoryblog($categoryblog_id);
				}

				$this->session->set_userdata('success',$this->lang->line('text_success'));

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

				redirect($this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getList();
		}

		public function repair() {
			$this->lang->load('catalog/categoryblog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/category_model','model_catalog_category');

			if ($this->validateRepair()) {
				$this->model_catalog_category->repairCategories();

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

				redirect($this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
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
				'href' => $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);

			$data['add'] = $this->url->link('catalog/categoryblog/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['delete'] = $this->url->link('catalog/categoryblog/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['repair'] = $this->url->link('catalog/categoryblog/repair', 'user_token=' . $this->session->userdata('user_token') . $url, true);

			$data['categories'] = array();

			$filter_data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
				'limit' => $this->configs->get('config_limit_admin')
			);
			$data['heading_title'] = $this->lang->line('heading_title');

			$data['text_list'] = $this->lang->line('text_list');
			$data['text_no_results'] = $this->lang->line('text_no_results');
			$data['text_confirm'] = $this->lang->line('text_confirm');

			$data['column_name'] = $this->lang->line('column_name');
			$data['column_sort_order'] = $this->lang->line('column_sort_order');
			$data['column_action'] = $this->lang->line('column_action');

			$data['button_add'] = $this->lang->line('button_add');
			$data['button_edit'] = $this->lang->line('button_edit');
			$data['button_delete'] = $this->lang->line('button_delete');
			$data['button_rebuild'] = $this->lang->line('button_rebuild');

			$categoryblog_total = $this->model_catalog_category->getTotalCategories();
			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$data['categories'][] = array(
					'categoryblog_id' => $result['categoryblog_id'],
					'name'        => $result['name'],
					'sort_order'  => $result['sort_order'],
					'edit'        => $this->url->link('catalog/categoryblog/edit', 'user_token=' . $this->session->userdata('user_token') . '&categoryblog_id=' . $result['categoryblog_id'] . $url, true),
					'delete'      => $this->url->link('catalog/categoryblog/delete', 'user_token=' . $this->session->userdata('user_token') . '&categoryblog_id=' . $result['categoryblog_id'] . $url, true)
				);
			}

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if ($this->session->userdata('success')) {
				$data['success'] = $this->session->userdata('success');
				$this->session->unsett_userdata('success');
			} else {
				$data['success'] = '';
			}

			if ($this->input->post('selected')) {
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

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$data['sort_name'] = $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . '&sort=name' . $url, true);
			$data['sort_sort_order'] = $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . '&sort=sort_order' . $url, true);

			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			$pagination = new Pagination();
			$pagination->total = $categoryblog_total;
			$pagination->page = $page;
			$pagination->limit = $this->configs->get('config_limit_admin');
			$pagination->url = $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->lang->line('text_pagination'), ($categoryblog_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($categoryblog_total - $this->configs->get('config_limit_admin'))) ? $categoryblog_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $categoryblog_total, ceil($categoryblog_total / $this->configs->get('config_limit_admin')));

			$data['sort'] = $sort;
			$data['order'] = $order;

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('catalog/categoryblog_list', $data));
		}

		protected function getForm() {
			$data['text_form'] = !($this->input->get('categoryblog_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
			$data['heading_title'] = $this->lang->line('heading_title');

			$data['text_none'] = $this->lang->line('text_none');
			$data['text_default'] = $this->lang->line('text_default');
			$data['text_enabled'] = $this->lang->line('text_enabled');
			$data['text_disabled'] = $this->lang->line('text_disabled');

			$data['entry_name'] = $this->lang->line('entry_name');
			$data['entry_description'] = $this->lang->line('entry_description');
			$data['entry_meta_title'] = $this->lang->line('entry_meta_title');
			$data['entry_meta_description'] = $this->lang->line('entry_meta_description');
			$data['entry_meta_keyword'] = $this->lang->line('entry_meta_keyword');
			$data['entry_keyword'] = $this->lang->line('entry_keyword');
			$data['entry_parent'] = $this->lang->line('entry_parent');
			$data['entry_filter'] = $this->lang->line('entry_filter');
			$data['entry_store'] = $this->lang->line('entry_store');
			$data['entry_image'] = $this->lang->line('entry_image');
			$data['entry_top'] = $this->lang->line('entry_top');
			$data['entry_column'] = $this->lang->line('entry_column');
			$data['entry_sort_order'] = $this->lang->line('entry_sort_order');
			$data['entry_status'] = $this->lang->line('entry_status');
			$data['entry_layout'] = $this->lang->line('entry_layout');
			$data['tab_seo'] = $this->lang->line('tab_seo');

			$data['help_filter'] = $this->lang->line('help_filter');
			$data['help_keyword'] = $this->lang->line('help_keyword');
			$data['help_top'] = $this->lang->line('help_top');
			$data['help_column'] = $this->lang->line('help_column');

			$data['button_save'] = $this->lang->line('button_save');
			$data['button_cancel'] = $this->lang->line('button_cancel');

			$data['tab_general'] = $this->lang->line('tab_general');
			$data['tab_data'] = $this->lang->line('tab_data');
			$data['tab_design'] = $this->lang->line('tab_design');
			$data['text_keyword'] = $this->lang->line('text_keyword');

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->error['name'])) {
				$data['error_name'] = $this->error['name'];
			} else {
				$data['error_name'] = array();
			}

			if (isset($this->error['meta_title'])) {
				$data['error_meta_title'] = $this->error['meta_title'];
			} else {
				$data['error_meta_title'] = array();
			}

			if (isset($this->error['keyword'])) {
				$data['error_keyword'] = $this->error['keyword'];
			} else {
				$data['error_keyword'] = '';
			}

			if (isset($this->error['parent'])) {
				$data['error_parent'] = $this->error['parent'];
			} else {
				$data['error_parent'] = '';
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
				'href' => $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);

			if (!($this->input->get('categoryblog_id'))) {
				$data['action'] = $this->url->link('catalog/categoryblog/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			} else {
				$data['action'] = $this->url->link('catalog/categoryblog/edit', 'user_token=' . $this->session->userdata('user_token') . '&categoryblog_id=' . $this->input->get('categoryblog_id') . $url, true);
			}

			$data['cancel'] = $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token') . $url, true);

			if (($this->input->get('categoryblog_id')) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
				$categoryblog_info = $this->model_catalog_category->getCategoryblog($this->input->get('categoryblog_id'));
			}

			$data['user_token'] = $this->session->userdata('user_token');

			$this->load->model('localisation/language_model');

			$data['languages'] = $this->language_model->getLanguages();

			if ($this->input->post('categoryblog_description')) {
				$data['categoryblog_description'] = $this->input->post['categoryblog_description'];
			} elseif ($this->input->get('categoryblog_id')) {
				$data['categoryblog_description'] = $this->model_catalog_category->getCategoryblogDescriptions($this->input->get('categoryblog_id'));
			} else {
				$data['categoryblog_description'] = array();
			}

			if ($this->input->post('path')) {
				$data['path'] = $this->input->post['path'];
			} elseif (!empty($categoryblog_info)) {
				$data['path'] = $categoryblog_info['path'];
			} else {
				$data['path'] = '';
			}

			if ($this->input->post('parent_id')) {
				$data['parent_id'] = $this->input->post['parent_id'];
			} elseif (!empty($categoryblog_info)) {
				$data['parent_id'] = $categoryblog_info['parent_id'];
			} else {
				$data['parent_id'] = 0;
			}

			$this->load->model('catalog/filter_model');

			if ($this->input->post('categoryblog_filter')) {
				$filters = $this->input->post['categoryblog_filter'];
			} elseif ($this->input->get('categoryblog_id')) {
				$filters = $this->model_catalog_category->getCategoryblogFilters($this->input->get('categoryblog_id'));
			} else {
				$filters = array();
			}

			$data['categoryblog_filters'] = array();

			foreach ($filters as $filter_id) {
				$filter_info = $this->model_catalog_filter->getFilter($filter_id);

				if ($filter_info) {
					$data['categoryblog_filters'][] = array(
						'filter_id' => $filter_info['filter_id'],
						'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
					);
				}
			}

			$this->load->model('setting/store_model');

			$data['stores'] = array();
			
			$data['stores'][] = array(
				'store_id' => 0,
				'name'     => $this->lang->line('text_default')
			);
			
			$stores = $this->store_model->getStores();

			foreach ($stores as $store) {
				$data['stores'][] = array(
					'store_id' => $store['store_id'],
					'name'     => $store['name']
				);
			}

			if ($this->input->post('categoryblog_store')) {
				$data['categoryblog_store'] = $this->input->post['categoryblog_store'];
			} elseif ($this->input->get('categoryblog_id')) {
				$data['categoryblog_store'] = $this->model_catalog_category->getCategoryblogStores($this->input->get('categoryblog_id'));
			} else {
				$data['categoryblog_store'] = array(0);
			}

			if ($this->input->post('image')) {
				$data['image'] = $this->input->post['image'];
			} elseif (!empty($categoryblog_info)) {
				$data['image'] = $categoryblog_info['image'];
			} else {
				$data['image'] = '';
			}

			$this->load->model('tool/image_model');

			if ($this->input->post('image') && is_file(DIR_IMAGE . $this->input->post['image'])) {
				$data['thumb'] = $this->image_model->resize($this->input->post['image'], 100, 100);
			} elseif (!empty($categoryblog_info) && is_file(DIR_IMAGE . $categoryblog_info['image'])) {
				$data['thumb'] = $this->image_model->resize($categoryblog_info['image'], 100, 100);
			} else {
				$data['thumb'] = $this->image_model->resize('no_image.png', 100, 100);
			}

			$data['placeholder'] = $this->image_model->resize('no_image.png', 100, 100);

			if ($this->input->post('top')) {
				$data['top'] = $this->input->post['top'];
			} elseif (!empty($categoryblog_info)) {
				$data['top'] = $categoryblog_info['top'];
			} else {
				$data['top'] = 0;
			}

			if ($this->input->post('column')) {
				$data['column'] = $this->input->post['column'];
			} elseif (!empty($categoryblog_info)) {
				$data['column'] = $categoryblog_info['column'];
			} else {
				$data['column'] = 1;
			}

			if ($this->input->post('sort_order')) {
				$data['sort_order'] = $this->input->post['sort_order'];
			} elseif (!empty($categoryblog_info)) {
				$data['sort_order'] = $categoryblog_info['sort_order'];
			} else {
				$data['sort_order'] = 0;
			}

			if ($this->input->post('status')) {
				$data['status'] = $this->input->post['status'];
			} elseif (!empty($categoryblog_info)) {
				$data['status'] = $categoryblog_info['status'];
			} else {
				$data['status'] = true;
			}
			
			if ($this->input->post('categoryblog_seo_url')) {
				$data['categoryblog_seo_url'] = $this->input->post['categoryblog_seo_url'];
			} elseif ($this->input->get('categoryblog_id')) {
				$data['categoryblog_seo_url'] = $this->model_catalog_category->getCategoryblogSeoUrls($this->input->get('categoryblog_id'));
			} else {
				$data['categoryblog_seo_url'] = array();
			}
					
			if ($this->input->post('categoryblog_layout')) {
				$data['categoryblog_layout'] = $this->input->post['categoryblog_layout'];
			} elseif ($this->input->get('categoryblog_id')) {
				$data['categoryblog_layout'] = $this->model_catalog_category->getCategoryblogLayouts($this->input->get('categoryblog_id'));
			} else {
				$data['categoryblog_layout'] = array();
			}

			$this->load->model('design/layout_model');

			$data['layouts'] = $this->layout_model->getLayouts();

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->load->view('catalog/categoryblog_form', $data);
		}

		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'catalog/categoryblog')) {
				$this->error['warning'] = $this->lang->line('error_permission');
			}

			foreach ($this->input->post['categoryblog_description'] as $language_id => $value) {
				if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->lang->line('error_name');
				}

				if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
					$this->error['meta_title'][$language_id] = $this->lang->line('error_meta_title');
				}
			}

			if (($this->input->get('categoryblog_id')) && $this->input->post('parent_id')) {
				$results = $this->model_catalog_category->getCategoryblogPath($this->input->post['parent_id']);
				
				foreach ($results as $result) {
					if ($result['path_id'] == $this->input->get('categoryblog_id')) {
						$this->error['parent'] = $this->lang->line('error_parent');
						
						break;
					}
				}
			}

			if ($this->input->post['categoryblog_seo_url']) {
				$this->load->model('design/seo_url_model');
				
				foreach ($this->input->post['categoryblog_seo_url'] as $store_id => $language) {
					foreach ($language as $language_id => $keyword) {
						if (!empty($keyword)) {
							if (count(array_keys($language, $keyword)) > 1) {
								$this->error['keyword'][$store_id][$language_id] = $this->lang->line('error_unique');
							}

							$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
		
							foreach ($seo_urls as $seo_url) {
								if (($seo_url['store_id'] == $store_id) && (!($this->input->get('categoryblog_id')) || ($seo_url['query'] != 'categoryblog_id=' . $this->input->get('categoryblog_id')))) {		
									$this->error['keyword'][$store_id][$language_id] = $this->lang->line('error_keyword');
					
									break;
								}
							}
						}
					}
				}
			}
			
			if ($this->error && !isset($this->error['warning'])) {
				$this->error['warning'] = $this->lang->line('error_warning');
			}
			
			return !$this->error;
		}

		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'catalog/categoryblog')) {
				$this->error['warning'] = $this->lang->line('error_permission');
			}

			return !$this->error;
		}

		protected function validateRepair() {
			if (!$this->user->hasPermission('modify', 'catalog/categoryblog')) {
				$this->error['warning'] = $this->lang->line('error_permission');
			}

			return !$this->error;
		}

		public function autocomplete() {
			$json = array();

			if ($this->input->get('filter_name')) {
				$this->load->model('catalog/category_model','model_catalog_category');

				$filter_data = array(
					'filter_name' => $this->input->get('filter_name'),
					'sort'        => 'name',
					'order'       => 'ASC',
					'start'       => 0,
					'limit'       => 5
				);

				$results = $this->model_catalog_category->getCategories($filter_data);

				foreach ($results as $result) {
					$json[] = array(
						'categoryblog_id' => $result['categoryblog_id'],
						'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
					);
				}
			}

			$sort_order = array();

			foreach ($json as $key => $value) {
				$sort_order[$key] = $value['name'];
			}

			array_multisort($sort_order, SORT_ASC, $json);

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}
	}