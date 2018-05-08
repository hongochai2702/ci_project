<?php
	class Blog extends MX_Controller {
		private $error = array();

		public function index() {
			$this->lang->load('catalog/blog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/blog_model');

			$this->getList();
		}

		public function add() {
			$this->lang->load('catalog/blog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/blog_model');

			if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->blog_model->addBlog($this->input->post());

				$this->session->data['success'] = $this->lang->line('text_success');

				$url = '';

				if ($this->input->get('filter_name')) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
				}

				if ($this->input->get('filter_model')) {
					$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
				}




				if ($this->input->get('filter_status')) {
					$url .= '&filter_status=' . $this->input->get('filter_status');
				}

				if ($this->input->get('sort')) {
					$url .= '&sort=' . $this->input->get('sort');
				}

				if ($this->input->get('order')) {
					$url .= '&order=' . $this->input->get('order');
				}

				if ($this->input->get('page')) {
					$url .= '&page=' . $this->input->get('page');
				}

				$this->response->redirect($this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getForm();
		}

		public function edit() {
			$this->lang->load('catalog/blog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/blog_model');

			if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
				$this->blog_model->editBlog($this->input->get('blog_id'), $this->input->post());

				$this->session->data['success'] = $this->lang->line('text_success');

				$url = '';

				if ($this->input->get('filter_name')) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
				}

				if ($this->input->get('filter_model')) {
					$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
				}




				if ($this->input->get('filter_status')) {
					$url .= '&filter_status=' . $this->input->get('filter_status');
				}

				if ($this->input->get('sort')) {
					$url .= '&sort=' . $this->input->get('sort');
				}

				if ($this->input->get('order')) {
					$url .= '&order=' . $this->input->get('order');
				}

				if ($this->input->get('page')) {
					$url .= '&page=' . $this->input->get('page');
				}

				$this->response->redirect($this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getForm();
		}

		public function delete() {
			$this->lang->load('catalog/blog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/blog_model');

			if (($this->input->post('selected')) && $this->validateDelete()) {
				foreach ($this->input->post('selected') as $blog_id) {
					$this->blog_model->deleteBlog($blog_id);
				}

				$this->session->data['success'] = $this->lang->line('text_success');

				$url = '';

				if ($this->input->get('filter_name')) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
				}

				if ($this->input->get('filter_model')) {
					$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
				}



				if ($this->input->get('filter_status')) {
					$url .= '&filter_status=' . $this->input->get('filter_status');
				}

				if ($this->input->get('sort')) {
					$url .= '&sort=' . $this->input->get('sort');
				}

				if ($this->input->get('order')) {
					$url .= '&order=' . $this->input->get('order');
				}

				if ($this->input->get('page')) {
					$url .= '&page=' . $this->input->get('page');
				}

				$this->response->redirect($this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true));
			}

			$this->getList();
		}

		public function copy() {
			$this->lang->load('catalog/blog');

			$this->document->setTitle($this->lang->line('heading_title'));

			$this->load->model('catalog/blog_model');

			if (($this->input->post('selected')) && $this->validateCopy()) {
				foreach ($this->input->post('selected') as $blog_id) {
					$this->blog_model->copyBlog($blog_id);
				}

				$this->session->data['success'] = $this->lang->line('text_success');

				$url = '';

				if ($this->input->get('filter_name')) {
					$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
				}

				if ($this->input->get('filter_model')) {
					$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
				}




				if ($this->input->get('filter_status')) {
					$url .= '&filter_status=' . $this->input->get('filter_status');
				}

				if ($this->input->get('sort')) {
					$url .= '&sort=' . $this->input->get('sort');
				}

				if ($this->input->get('order')) {
					$url .= '&order=' . $this->input->get('order');
				}

				if ($this->input->get('page')) {
					$url .= '&page=' . $this->input->get('page');
				}

				$this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			}

			$this->getList();
		}

		protected function getList() {
			if ($this->input->get('filter_name')) {
				$filter_name = $this->input->get('filter_name');
			} else {
				$filter_name = '';
			}

			if ($this->input->get('filter_model')) {
				$filter_model = $this->input->get('filter_model');
			} else {
				$filter_model = '';
			}

			

			if ($this->input->get('filter_status')) {
				$filter_status = $this->input->get('filter_status');
			} else {
				$filter_status = '';
			}

			if ($this->input->get('sort')) {
				$sort = $this->input->get('sort');
			} else {
				$sort = 'pd.name';
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

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}



			

			if ($this->input->get('filter_status')) {
				$url .= '&filter_status=' . $this->input->get('filter_status');
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
				'href' => $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);

			$data['add'] = $this->url->link('catalog/blog/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['copy'] = $this->url->link('catalog/blog/copy', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			$data['delete'] = $this->url->link('catalog/blog/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);

			$data['blogs'] = array();

			$filter_data = array(
				'filter_name'	  => $filter_name,
				'filter_model'	  => $filter_model,
			
				
				'filter_status'   => $filter_status,
				'sort'            => $sort,
				'order'           => $order,
				'start'           => ($page - 1) * $this->configs->get('config_limit_admin'),
				'limit'           => $this->configs->get('config_limit_admin')
			);

			$this->load->model('tool/image_model');

			$blog_total = $this->blog_model->getTotalBlogs($filter_data);

			$results = $this->blog_model->getBlogs($filter_data);

			foreach ($results as $result) {
				if (is_file(DIR_IMAGE . $result['image'])) {
					$image = $this->image_model->resize($result['image'], 40, 40);
				} else {
					$image = $this->image_model->resize('no_image.png', 40, 40);
				}


				$data['blogs'][] = array(
					'blog_id' => $result['blog_id'],
					'image'      => $image,
					'name'       => $result['name'],
					'model'      => $result['model'],

					
				
					'status'     => $result['status'] ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
					'edit'       => $this->url->link('catalog/blog/edit', 'user_token=' . $this->session->userdata('user_token') . '&blog_id=' . $result['blog_id'] . $url, true)
				);
			}

			$data['heading_title'] = $this->lang->line('heading_title');

			$data['text_list'] = $this->lang->line('text_list');
			$data['text_enabled'] = $this->lang->line('text_enabled');
			$data['text_disabled'] = $this->lang->line('text_disabled');
			$data['text_no_results'] = $this->lang->line('text_no_results');
			$data['text_confirm'] = $this->lang->line('text_confirm');

			$data['column_image'] = $this->lang->line('column_image');
			$data['column_name'] = $this->lang->line('column_name');
			$data['column_model'] = $this->lang->line('column_model');
			
			
			$data['column_status'] = $this->lang->line('column_status');
			$data['column_action'] = $this->lang->line('column_action');



			$data['entry_name'] = $this->lang->line('entry_name');
			$data['entry_model'] = $this->lang->line('entry_model');
			

			$data['entry_status'] = $this->lang->line('entry_status');
			$data['entry_image'] = $this->lang->line('entry_image');

			$data['button_copy'] = $this->lang->line('button_copy');
			$data['button_add'] = $this->lang->line('button_add');
			$data['button_edit'] = $this->lang->line('button_edit');
			$data['button_delete'] = $this->lang->line('button_delete');
			$data['button_filter'] = $this->lang->line('button_filter');

			$data['user_token'] = $this->session->userdata('user_token');

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			if (($this->input->post('selected'))) {
				$data['selected'] = (array)$this->input->post('selected');
			} else {
				$data['selected'] = array();
			}

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			

			if ($this->input->get('filter_status')) {
				$url .= '&filter_status=' . $this->input->get('filter_status');
			}

			if ($order == 'ASC') {
				$url .= '&order=DESC';
			} else {
				$url .= '&order=ASC';
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$data['sort_name'] = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . '&sort=pd.name' . $url, true);
			$data['sort_model'] = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.model' . $url, true);
			
			
			$data['sort_status'] = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.status' . $url, true);
			$data['sort_order'] = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.sort_order' . $url, true);

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			
			if ($this->input->get('filter_status')) {
				$url .= '&filter_status=' . $this->input->get('filter_status');
			}

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			$pagination = new Pagination();
			$pagination->total = $blog_total;
			$pagination->page = $page;
			$pagination->limit = $this->configs->get('config_limit_admin');
			$pagination->url = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->lang->line('text_pagination'), ($blog_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($blog_total - $this->configs->get('config_limit_admin'))) ? $blog_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $blog_total, ceil($blog_total / $this->configs->get('config_limit_admin')));

			$data['filter_name'] = $filter_name;
			$data['filter_model'] = $filter_model;
			
			
			$data['filter_status'] = $filter_status;

			$data['sort'] = $sort;
			$data['order'] = $order;

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->load->view('catalog/blog_list', $data);
		}

		protected function getForm() {
			$data['heading_title'] = $this->lang->line('heading_title');

			$data['text_form'] = !($this->input->get('blog_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
			$data['text_enabled'] = $this->lang->line('text_enabled');
			$data['text_disabled'] = $this->lang->line('text_disabled');
			$data['text_none'] = $this->lang->line('text_none');
			$data['text_yes'] = $this->lang->line('text_yes');
			$data['text_no'] = $this->lang->line('text_no');
			$data['text_plus'] = $this->lang->line('text_plus');
			$data['text_minus'] = $this->lang->line('text_minus');
			$data['text_default'] = $this->lang->line('text_default');
			$data['text_option'] = $this->lang->line('text_option');
			$data['text_option_value'] = $this->lang->line('text_option_value');
			$data['text_select'] = $this->lang->line('text_select');
			$data['text_percent'] = $this->lang->line('text_percent');
			$data['text_amount'] = $this->lang->line('text_amount');

			$data['entry_name'] = $this->lang->line('entry_name');
			$data['entry_description'] = $this->lang->line('entry_description');
			$data['entry_meta_title'] = $this->lang->line('entry_meta_title');
			$data['entry_meta_description'] = $this->lang->line('entry_meta_description');
			$data['entry_meta_keyword'] = $this->lang->line('entry_meta_keyword');
			$data['entry_keyword'] = $this->lang->line('entry_keyword');
			$data['entry_model'] = $this->lang->line('entry_model');
			
			$data['entry_location'] = $this->lang->line('entry_location');
			
			$data['entry_shipping'] = $this->lang->line('entry_shipping');
			$data['entry_date_available'] = $this->lang->line('entry_date_available');
			
			$data['entry_stock_status'] = $this->lang->line('entry_stock_status');
			$data['entry_price'] = $this->lang->line('entry_price');
			$data['entry_tax_class'] = $this->lang->line('entry_tax_class');
			
		
			$data['entry_weight_class'] = $this->lang->line('entry_weight_class');
			$data['entry_weight'] = $this->lang->line('entry_weight');
			$data['entry_dimension'] = $this->lang->line('entry_dimension');
			$data['entry_length_class'] = $this->lang->line('entry_length_class');
			$data['entry_length'] = $this->lang->line('entry_length');
		
			
			$data['entry_image'] = $this->lang->line('entry_image');
			$data['entry_additional_image'] = $this->lang->line('entry_additional_image');
			$data['entry_store'] = $this->lang->line('entry_store');
			$data['entry_author'] = $this->lang->line('entry_author');
			$data['entry_download'] = $this->lang->line('entry_download');
			$data['entry_categoryblog'] = $this->lang->line('entry_categoryblog');
			$data['entry_filter'] = $this->lang->line('entry_filter');
			$data['entry_related'] = $this->lang->line('entry_related');
			$data['entry_attribute'] = $this->lang->line('entry_attribute');
			$data['entry_text'] = $this->lang->line('entry_text');
			$data['entry_option'] = $this->lang->line('entry_option');
			$data['entry_option_value'] = $this->lang->line('entry_option_value');
			$data['entry_required'] = $this->lang->line('entry_required');
			$data['entry_sort_order'] = $this->lang->line('entry_sort_order');
			$data['entry_status'] = $this->lang->line('entry_status');
			$data['entry_date_start'] = $this->lang->line('entry_date_start');
			$data['entry_date_end'] = $this->lang->line('entry_date_end');
			$data['entry_priority'] = $this->lang->line('entry_priority');
			$data['entry_tag'] = $this->lang->line('entry_tag');
			$data['entry_customer_group'] = $this->lang->line('entry_customer_group');
			
			$data['entry_layout'] = $this->lang->line('entry_layout');
			$data['entry_recurring'] = $this->lang->line('entry_recurring');

			$data['help_keyword'] = $this->lang->line('help_keyword');
			
		
			$data['help_author'] = $this->lang->line('help_author');
			$data['help_stock_status'] = $this->lang->line('help_stock_status');
			
			$data['help_categoryblog'] = $this->lang->line('help_categoryblog');
			$data['help_filter'] = $this->lang->line('help_filter');
			$data['help_download'] = $this->lang->line('help_download');
			$data['help_related'] = $this->lang->line('help_related');
			$data['help_tag'] = $this->lang->line('help_tag');
			$data['tab_seo'] = $this->lang->line('tab_seo');
			$data['text_keyword'] = $this->lang->line('text_keyword');

			$data['button_save'] = $this->lang->line('button_save');
			$data['button_cancel'] = $this->lang->line('button_cancel');
			$data['button_attribute_add'] = $this->lang->line('button_attribute_add');
			$data['button_option_add'] = $this->lang->line('button_option_add');
			$data['button_option_value_add'] = $this->lang->line('button_option_value_add');
			$data['button_discount_add'] = $this->lang->line('button_discount_add');
			$data['button_special_add'] = $this->lang->line('button_special_add');
			$data['button_image_add'] = $this->lang->line('button_image_add');
			$data['button_remove'] = $this->lang->line('button_remove');
			$data['button_recurring_add'] = $this->lang->line('button_recurring_add');

			$data['tab_general'] = $this->lang->line('tab_general');
			$data['tab_data'] = $this->lang->line('tab_data');
			$data['tab_attribute'] = $this->lang->line('tab_attribute');
			$data['tab_option'] = $this->lang->line('tab_option');
			$data['tab_recurring'] = $this->lang->line('tab_recurring');
			$data['tab_discount'] = $this->lang->line('tab_discount');
			$data['tab_special'] = $this->lang->line('tab_special');
			$data['tab_image'] = $this->lang->line('tab_image');
			$data['tab_links'] = $this->lang->line('tab_links');
			$data['tab_seo'] = $this->lang->line('tab_seo');
		
			$data['tab_design'] = $this->lang->line('tab_design');
			$data['tab_openbay'] = $this->lang->line('tab_openbay');
			$data['text_form'] = !($this->input->get('blog_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');

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

			if (isset($this->error['model'])) {
				$data['error_model'] = $this->error['model'];
			} else {
				$data['error_model'] = '';
			}

			if (isset($this->error['keyword'])) {
				$data['error_keyword'] = $this->error['keyword'];
			} else {
				$data['error_keyword'] = '';
			}

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}




			if ($this->input->get('filter_status')) {
				$url .= '&filter_status=' . $this->input->get('filter_status');
			}

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
				'href' => $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true)
			);

			if (!($this->input->get('blog_id'))) {
				$data['action'] = $this->url->link('catalog/blog/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
			} else {
				$data['action'] = $this->url->link('catalog/blog/edit', 'user_token=' . $this->session->userdata('user_token') . '&blog_id=' . $this->input->get('blog_id') . $url, true);
			}

			$data['cancel'] = $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token') . $url, true);

			if (($this->input->get('blog_id')) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
				$blog_info = $this->blog_model->getBlog($this->input->get('blog_id'));
			}

			$data['user_token'] = $this->session->userdata('user_token');

			$this->load->model('localisation/language_model');

			$data['languages'] = $this->language_model->getLanguages();

			if ($this->input->post('blog_description')) {
				$data['blog_description'] = $this->input->post('blog_description');
			} elseif ($this->input->get('blog_id')) {
				$data['blog_description'] = $this->blog_model->getBlogDescriptions($this->input->get('blog_id'));
			} else {
				$data['blog_description'] = array();
			}

			if ($this->input->post('model')) {
				$data['model'] = $this->input->post('model');
			} elseif (!empty($blog_info)) {
				$data['model'] = $blog_info['model'];
			} else {
				$data['model'] = '';
			}

			
			if ($this->input->post('location')) {
				$data['location'] = $this->input->post('location');
			} elseif (!empty($blog_info)) {
				$data['location'] = $blog_info['location'];
			} else {
				$data['location'] = '';
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

			if ($this->input->post('blog_store')) {
				$data['blog_store'] = $this->input->post('blog_store');
			} elseif ($this->input->get('blog_id')) {
				$data['blog_store'] = $this->blog_model->getBlogStores($this->input->get('blog_id'));
			} else {
				$data['blog_store'] = array(0);
			}

			



			if ($this->input->post('date_available')) {
				$data['date_available'] = $this->input->post('date_available');
			} elseif (!empty($blog_info)) {
				$data['date_available'] = ($blog_info['date_available'] != '0000-00-00') ? $blog_info['date_available'] : '';
			} else {
				$data['date_available'] = date('Y-m-d');
			}

			

			

			

			if ($this->input->post('sort_order')) {
				$data['sort_order'] = $this->input->post('sort_order');
			} elseif (!empty($blog_info)) {
				$data['sort_order'] = $blog_info['sort_order'];
			} else {
				$data['sort_order'] = 1;
			}


			

			if ($this->input->post('status')) {
				$data['status'] = $this->input->post('status');
			} elseif (!empty($blog_info)) {
				$data['status'] = $blog_info['status'];
			} else {
				$data['status'] = true;
			}

			


			

			

			$this->load->model('catalog/author_model');

			if ($this->input->post('author_id')) {
				$data['author_id'] = $this->input->post('author_id');
			} elseif (!empty($blog_info)) {
				$data['author_id'] = $blog_info['author_id'];
			} else {
				$data['author_id'] = 0;
			}

			if ($this->input->post('author')) {
				$data['author'] = $this->input->post('author');
			} elseif (!empty($blog_info)) {
				$author_info = $this->author_model->getAuthor($blog_info['author_id']);

				if ($author_info) {
					$data['author'] = $author_info['name'];
				} else {
					$data['author'] = '';
				}
			} else {
				$data['author'] = '';
			}

			// Categories
			$this->load->model('catalog/categoryblog_model');

			if ($this->input->post('blog_categoryblog')) {
				$categories = $this->input->post('blog_categoryblog');
			} elseif ($this->input->get('blog_id')) {
				$categories = $this->blog_model->getBlogCategories($this->input->get('blog_id'));
			} else {
				$categories = array();
			}

			$data['blog_categories'] = array();

			foreach ($categories as $categoryblog_id) {
				$categoryblog_info = $this->categoryblog_model->getCategoryblog($categoryblog_id);

				if ($categoryblog_info) {
					$data['blog_categories'][] = array(
						'categoryblog_id' => $categoryblog_info['categoryblog_id'],
						'name'        => ($categoryblog_info['path']) ? $categoryblog_info['path'] . ' &gt; ' . $categoryblog_info['name'] : $categoryblog_info['name']
					);
				}
			}

			// Filters
			
		


		
		

			$this->load->model('customer/customer_group_model');

			$data['customer_groups'] = $this->customer_group_model->getCustomerGroups();

			

			

			
			// Image
			if ($this->input->post('image')) {
				$data['image'] = $this->input->post('image');
			} elseif (!empty($blog_info)) {
				$data['image'] = $blog_info['image'];
			} else {
				$data['image'] = '';
			}

			$this->load->model('tool/image_model');

			if (($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
				$data['thumb'] = $this->image_model->resize($this->input->post('image'), 100, 100);
			} elseif (!empty($blog_info) && is_file(DIR_IMAGE . $blog_info['image'])) {
				$data['thumb'] = $this->image_model->resize($blog_info['image'], 100, 100);
			} else {
				$data['thumb'] = $this->image_model->resize('no_image.png', 100, 100);
			}

			$data['placeholder'] = $this->image_model->resize('no_image.png', 100, 100);

			// Images
			if ($this->input->post('blog_image')) {
				$blog_images = $this->input->post('blog_image');
			} elseif ($this->input->get('blog_id')) {
				$blog_images = $this->blog_model->getBlogImages($this->input->get('blog_id'));
			} else {
				$blog_images = array();
			}

			$data['blog_images'] = array();

			foreach ($blog_images as $blog_image) {
				if (is_file(DIR_IMAGE . $blog_image['image'])) {
					$image = $blog_image['image'];
					$thumb = $blog_image['image'];
				} else {
					$image = '';
					$thumb = 'no_image.png';
				}

				$data['blog_images'][] = array(
					'image'      => $image,
					'thumb'      => $this->image_model->resize($thumb, 100, 100),
					'sort_order' => $blog_image['sort_order']
				);
			}

			

			if ($this->input->post('blog_related')) {
				$blogs = $this->input->post('blog_related');
			} elseif ($this->input->get('blog_id')) {
				$blogs = $this->blog_model->getBlogRelated($this->input->get('blog_id'));
			} else {
				$blogs = array();
			}

			$data['blog_relateds'] = array();

			foreach ($blogs as $blog_id) {
				$related_info = $this->blog_model->getBlog($blog_id);

				if ($related_info) {
					$data['blog_relateds'][] = array(
						'blog_id' => $related_info['blog_id'],
						'name'       => $related_info['name']
					);
				}
			}

			
		

			if ($this->input->post('blog_seo_url')) {
				$data['blog_seo_url'] = $this->input->post('blog_seo_url');
			} elseif ($this->input->get('blog_id')) {
				$data['blog_seo_url'] = $this->blog_model->getBlogSeoUrls($this->input->get('blog_id'));
			} else {
				$data['blog_seo_url'] = array();
			}

			if ($this->input->post('blog_layout')) {
				$data['blog_layout'] = $this->input->post('blog_layout');
			} elseif ($this->input->get('blog_id')) {
				$data['blog_layout'] = $this->blog_model->getBlogLayouts($this->input->get('blog_id'));
			} else {
				$data['blog_layout'] = array();
			}

			$this->load->model('design/layout_model');

			$data['layouts'] = $this->layout_model->getLayouts();
			
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->load->view('catalog/blog_form', $data);
		}

	// 	protected function validateForm() {
	// 		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
	// 			$this->error['warning'] = $this->lang->line('error_permission');
	// 		}

	// 		foreach ($this->input->post('blog_description') as $language_id => $value) {
	// 			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
	// 				$this->error['name'][$language_id] = $this->lang->line('error_name');
	// 			}

	// 			if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
	// 				$this->error['meta_title'][$language_id] = $this->lang->line('error_meta_title');
	// 			}
	// 		}

	// 		// if ((utf8_strlen($this->input->post('model')) < 1) || (utf8_strlen($this->input->post('model')) > 64)) {
	// 		// 	$this->error['model'] = $this->lang->line('error_model');
	// 		// }

	// 		if ($this->input->post('blog_seo_url')) {
	// 			$this->load->model('design/seo_url_model');
				
	// 			foreach ($this->input->post('blog_seo_url') as $store_id => $language) {
	// 				foreach ($language as $language_id => $keyword) {
	// 					if (!empty($keyword)) {
	// 						if (count(array_keys($language, $keyword)) > 1) {
	// 							$this->error['keyword'][$store_id][$language_id] = $this->lang->line('error_unique');
	// 						}						
							
	// 						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
							
	// 						foreach ($seo_urls as $seo_url) {
	// 							if (($seo_url['store_id'] == $store_id) && (!isset($this->input->get('blog_id')) || (($seo_url['query'] != 'blog_id=' . $this->input->get('blog_id'))))) {
	// 								$this->error['keyword'][$store_id][$language_id] = $this->lang->line('error_keyword');
									
	// 								break;
	// 							}
	// 						}
	// 					}
	// 				}
	// 			}
	// 		}

	// 		if ($this->error && !isset($this->error['warning'])) {
	// 			$this->error['warning'] = $this->lang->line('error_warning');
	// 		}

	// 		return !$this->error;
	// 	}

	// 	protected function validateDelete() {
	// 		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
	// 			$this->error['warning'] = $this->lang->line('error_permission');
	// 		}

	// 		return !$this->error;
	// 	}

	// 	protected function validateCopy() {
	// 		if (!$this->user->hasPermission('modify', 'catalog/blog')) {
	// 			$this->error['warning'] = $this->lang->line('error_permission');
	// 		}

	// 		return !$this->error;
	// 	}

		public function autocomplete() {
			$json = array();

			if (($this->input->get('filter_name')) || ($this->input->get('filter_model'))) {
				$this->load->model('catalog/blog_model');
			

				if ($this->input->get('filter_name')) {
					$filter_name = $this->input->get('filter_name');
				} else {
					$filter_name = '';
				}

				if ($this->input->get('filter_model')) {
					$filter_model = $this->input->get('filter_model');
				} else {
					$filter_model = '';
				}

				if ($this->input->get('limit')) {
					$limit = $this->input->get('limit');
				} else {
					$limit = 5;
				}

				$filter_data = array(
					'filter_name'  => $filter_name.'%',
					'filter_model' => $filter_model.'%',
					'start'        => 0,
					'limit'        => $limit
				);

				$results = $this->blog_model->getBlogs($filter_data);

				foreach ($results as $result) {
				

					


					$json[] = array(
						'blog_id' => $result['blog_id'],
						'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
						'model'      => $result['model'],
					

					);
				}
			}

			echo json_encode($json);
			
		}
	 }
