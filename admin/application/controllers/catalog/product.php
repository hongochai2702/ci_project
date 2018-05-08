<?php
class Product extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('catalog/product');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/product_model');

		$this->getList();
	}

	public function add() {
		$this->lang->load('catalog/product');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/product_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->product_model->addProduct($this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_price')) {
				$url .= '&filter_price=' . $this->input->get('filter_price');
			}

			if ($this->input->get('filter_quantity')) {
				$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

			$this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		}

		$this->getForm();
	}

	public function edit() {
		$this->lang->load('catalog/product');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/product_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->product_model->editProduct($this->input->get('product_id'), $this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_price')) {
				$url .= '&filter_price=' . $this->input->get('filter_price');
			}

			if ($this->input->get('filter_quantity')) {
				$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

			$this->response->redirect($this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->lang->load('catalog/product');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/product_model');

		if (($this->input->post('selected')) && $this->validateDelete()) {
			foreach ($this->input->post('selected') as $product_id) {
				$this->product_model->deleteProduct($product_id);
			}

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_price')) {
				$url .= '&filter_price=' . $this->input->get('filter_price');
			}

			if ($this->input->get('filter_quantity')) {
				$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

			$this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		}

		$this->getList();
	}

	public function copy() {
		$this->lang->load('catalog/product');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/product_model');

		if (($this->input->post('selected')) && $this->validateCopy()) {
			foreach ($this->input->post('selected') as $product_id) {
				$this->product_model->copyProduct($product_id);
			}

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '';

			if ($this->input->get('filter_name')) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_model')) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
			}

			if ($this->input->get('filter_price')) {
				$url .= '&filter_price=' . $this->input->get('filter_price');
			}

			if ($this->input->get('filter_quantity')) {
				$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

			$this->response->redirect($this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true));
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

		if ($this->input->get('filter_price')) {
			$filter_price = $this->input->get('filter_price');
		} else {
			$filter_price = '';
		}

		if ($this->input->get('filter_quantity')) {
			$filter_quantity = $this->input->get('filter_quantity');
		} else {
			$filter_quantity = '';
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

		if ($this->input->get('filter_price')) {
			$url .= '&filter_price=' . $this->input->get('filter_price');
		}

		if ($this->input->get('filter_quantity')) {
			$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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
		$data = '';
		$data['breadcrumbs'] = array();
		$data = array_merge($data, $this->lang->loadAll());
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		$data['add'] = $this->url->link('catalog/product/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['copy'] = $this->url->link('catalog/product/copy', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['delete'] = $this->url->link('catalog/product/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit'           => $this->configs->get('config_limit_admin')
		);

		$this->load->model('tool/image_model');

		$product_total = $this->product_model->getTotalProducts($filter_data);

		$results = $this->product_model->getProducts($filter_data);



		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->image_model->resize($result['image'], 40, 40);
			} else {
				$image = $this->image_model->resize('no_image.png', 40, 40);
			}




			$special = false;

			$product_specials = $this->product_model->getProductSpecials($result['product_id']);



			foreach ($product_specials  as $product_special) {



				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $this->currency->format($product_special['price'], $this->configs->get('config_currency'));

					break;
				}
			}

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $this->currency->format($result['price'], $this->configs->get('config_currency')),
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => $result['status'] ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', 'user_token=' . $this->session->userdata('user_token') . '&product_id=' . $result['product_id'] . $url, true)
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
		$data['column_price'] = $this->lang->line('column_price');
		$data['column_quantity'] = $this->lang->line('column_quantity');
		$data['column_status'] = $this->lang->line('column_status');
		$data['column_action'] = $this->lang->line('column_action');

		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_model'] = $this->lang->line('entry_model');
		$data['entry_price'] = $this->lang->line('entry_price');
		$data['entry_quantity'] = $this->lang->line('entry_quantity');
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

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
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

		if ($this->input->get('filter_price')) {
			$url .= '&filter_price=' . $this->input->get('filter_price');
		}

		if ($this->input->get('filter_quantity')) {
			$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

		$data['sort_name'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . '&sort=p.sort_order' . $url, true);

		$url = '';

		if ($this->input->get('filter_name')) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('filter_model')) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->input->get('filter_model'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('filter_price')) {
			$url .= '&filter_price=' . $this->input->get('filter_price');
		}

		if ($this->input->get('filter_quantity')) {
			$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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

		$this->pagination = new Pagination();
		$this->pagination->total = $product_total;
		$this->pagination->page = $page;
		$this->pagination->limit = $this->configs->get('config_limit_admin');
		$this->pagination->url = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

		$data['pagination'] = $this->pagination->render();

		$data['results'] = sprintf($this->lang->line('text_pagination'), ($product_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($product_total - $this->configs->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $product_total, ceil($product_total / $this->configs->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('catalog/product_list', $data);
	}

	protected function getForm() {
		$data['text_form'] = !($this->input->get('product_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		

		$data['text_form'] = !($this->input->get('product_id')) ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['tab_seo'] = $this->lang->line('tab_seo');
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
		$data['text_keyword'] = $this->lang->line('text_keyword');

		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_description'] = $this->lang->line('entry_description');
		$data['entry_meta_title'] = $this->lang->line('entry_meta_title');
		$data['entry_meta_description'] = $this->lang->line('entry_meta_description');
		$data['entry_meta_keyword'] = $this->lang->line('entry_meta_keyword');
		$data['entry_keyword'] = $this->lang->line('entry_keyword');
		$data['entry_model'] = $this->lang->line('entry_model');
		$data['entry_sku'] = $this->lang->line('entry_sku');
		$data['entry_upc'] = $this->lang->line('entry_upc');
		$data['entry_ean'] = $this->lang->line('entry_ean');
		$data['entry_jan'] = $this->lang->line('entry_jan');
		$data['entry_isbn'] = $this->lang->line('entry_isbn');
		$data['entry_mpn'] = $this->lang->line('entry_mpn');
		$data['entry_location'] = $this->lang->line('entry_location');
		$data['entry_minimum'] = $this->lang->line('entry_minimum');
		$data['entry_shipping'] = $this->lang->line('entry_shipping');
		$data['entry_date_available'] = $this->lang->line('entry_date_available');
		$data['entry_quantity'] = $this->lang->line('entry_quantity');
		$data['entry_stock_status'] = $this->lang->line('entry_stock_status');
		$data['entry_price'] = $this->lang->line('entry_price');
		$data['entry_tax_class'] = $this->lang->line('entry_tax_class');
		$data['entry_points'] = $this->lang->line('entry_points');
		$data['entry_option_points'] = $this->lang->line('entry_option_points');
		$data['entry_subtract'] = $this->lang->line('entry_subtract');
		$data['entry_weight_class'] = $this->lang->line('entry_weight_class');
		$data['entry_weight'] = $this->lang->line('entry_weight');
		$data['entry_dimension'] = $this->lang->line('entry_dimension');
		$data['entry_length_class'] = $this->lang->line('entry_length_class');
		$data['entry_length'] = $this->lang->line('entry_length');
		$data['entry_width'] = $this->lang->line('entry_width');
		$data['entry_height'] = $this->lang->line('entry_height');
		$data['entry_image'] = $this->lang->line('entry_image');
		$data['entry_additional_image'] = $this->lang->line('entry_additional_image');
		$data['entry_store'] = $this->lang->line('entry_store');
		$data['entry_manufacturer'] = $this->lang->line('entry_manufacturer');
		$data['entry_download'] = $this->lang->line('entry_download');
		$data['entry_category'] = $this->lang->line('entry_category');
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
		$data['entry_reward'] = $this->lang->line('entry_reward');
		$data['entry_layout'] = $this->lang->line('entry_layout');
		$data['entry_recurring'] = $this->lang->line('entry_recurring');

		$data['help_keyword'] = $this->lang->line('help_keyword');
		$data['help_sku'] = $this->lang->line('help_sku');
		$data['help_upc'] = $this->lang->line('help_upc');
		$data['help_ean'] = $this->lang->line('help_ean');
		$data['help_jan'] = $this->lang->line('help_jan');
		$data['help_isbn'] = $this->lang->line('help_isbn');
		$data['help_mpn'] = $this->lang->line('help_mpn');
		$data['help_minimum'] = $this->lang->line('help_minimum');
		$data['help_manufacturer'] = $this->lang->line('help_manufacturer');
		$data['help_stock_status'] = $this->lang->line('help_stock_status');
		$data['help_points'] = $this->lang->line('help_points');
		$data['help_category'] = $this->lang->line('help_category');
		$data['help_filter'] = $this->lang->line('help_filter');
		$data['help_download'] = $this->lang->line('help_download');
		$data['help_related'] = $this->lang->line('help_related');
		$data['help_tag'] = $this->lang->line('help_tag');

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
		$data['tab_reward'] = $this->lang->line('tab_reward');
		$data['tab_design'] = $this->lang->line('tab_design');
		$data['tab_openbay'] = $this->lang->line('tab_openbay');

		$data['datepicker'] = $this->configs->get('config_admin_language');


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

		if ($this->input->get('filter_price')) {
			$url .= '&filter_price=' . $this->input->get('filter_price');
		}

		if ($this->input->get('filter_quantity')) {
			$url .= '&filter_quantity=' . $this->input->get('filter_quantity');
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
			'href' => $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		if (!($this->input->get('product_id'))) {
			$data['action'] = $this->url->link('catalog/product/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'user_token=' . $this->session->userdata('user_token') . '&product_id=' . $this->input->get('product_id') . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		if (($this->input->get('product_id')) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$product_info = $this->product_model->getProduct($this->input->get('product_id'));
		}



		$data['user_token'] = $this->session->userdata('user_token');

		$this->load->model('localisation/language_model');

		$data['languages'] = $this->language_model->getLanguages();

		if (($this->input->post('product_description'))) {
			$data['product_description'] = $this->input->post('product_description');
		} elseif (($this->input->get('product_id'))) {
			$data['product_description'] = $this->product_model->getProductDescriptions($this->input->get('product_id'));
		} else {
			$data['product_description'] = array();
		}

		

		if ($this->input->post('model')) {
			$data['model'] = $this->input->post('model');
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		if ($this->input->post('sku')) {
			$data['sku'] = $this->input->post('sku');
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if ($this->input->post('upc')) {
			$data['upc'] = $this->input->post('upc');
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if ($this->input->post('ean')) {
			$data['ean'] = $this->input->post('ean');
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if ($this->input->post('jan')) {
			$data['jan'] = $this->input->post('jan');
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if ($this->input->post('isbn')) {
			$data['isbn'] = $this->input->post('isbn');
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if ($this->input->post('mpn')) {
			$data['mpn'] = $this->input->post('mpn');
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if ($this->input->post('location')) {
			$data['location'] = $this->input->post('location');
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
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

		if (($this->input->post('product_store'))) {
			$data['product_store'] = $this->input->post('product_store');
		} elseif (($this->input->get('product_id'))) {
			$data['product_store'] = $this->product_model->getProductStores($this->input->get('product_id'));
		} else {
			$data['product_store'] = array(0);
		}

		if (($this->input->post('shipping'))) {
			$data['shipping'] = $this->input->post('shipping');
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (($this->input->post('price'))) {
			$data['price'] = $this->input->post('price');
		} elseif (!empty($product_info)) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = 
			'';
		}


		$this->load->model('catalog/recurring_model');

		$data['recurrings'] = $this->recurring_model->getRecurrings();

		if (($this->input->post('product_recurrings'))) {
			$data['product_recurrings'] = $this->input->post('product_recurrings');
		} elseif (!empty($product_info)) {
			$data['product_recurrings'] = $this->product_model->getRecurrings($product_info['product_id']);
		} else {
			$data['product_recurrings'] = array();
		}
	
		$this->load->model('localisation/tax_class_model');

		$data['tax_classes'] = $this->tax_class_model->getTaxClasses();

		if (($this->input->post('tax_class_id'))) {
			$data['tax_class_id'] = $this->input->post('tax_class_id');
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if ($this->input->post('date_available')) {
			$data['date_available'] = $this->input->post('date_available');
		} elseif (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if ($this->input->post('quantity')) {
			$data['quantity'] = $this->input->post('quantity');
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if ($this->input->post('minimum')) {
			$data['minimum'] = $this->input->post('minimum');
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if ($this->input->post('subtract')) {
			$data['subtract'] = $this->input->post('subtract');
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if ($this->input->post('sort_order')) {
			$data['sort_order'] = $this->input->post('sort_order');
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status_model');

		$data['stock_statuses'] = $this->stock_status_model->getStockStatuses();

		if ($this->input->post('stock_status_id')) {
			$data['stock_status_id'] = $this->input->post('stock_status_id');
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

		if ($this->input->post('weight')) {
			$data['weight'] = $this->input->post('weight');
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class_model');

		$data['weight_classes'] = $this->weight_class_model->getWeightClasses();

		if ($this->input->post('weight_class_id')) {
			$data['weight_class_id'] = $this->input->post('weight_class_id');
		} elseif (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->configs->get('config_weight_class_id');
		}

		if ($this->input->post('length')) {
			$data['length'] = $this->input->post('length');
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if ($this->input->post('width')) {
			$data['width'] = $this->input->post('width');
		} elseif (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if ($this->input->post('height')) {
			$data['height'] = $this->input->post('height');
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class_model');

		$data['length_classes'] = $this->length_class_model->getLengthClasses();

		if (($this->input->post('length_class_id'))) {
			$data['length_class_id'] = $this->input->post('length_class_id');
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->configs->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer_model');

		if (($this->input->post('manufacturer_id'))) {
			$data['manufacturer_id'] = $this->input->post('manufacturer_id');
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (($this->input->post('manufacturer'))) {
			$data['manufacturer'] = $this->input->post('manufacturer');
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->manufacturer_model->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category_model');

		if (($this->input->post('product_category'))) {
			$categories = $this->input->post('product_category');
		} elseif (($this->input->get('product_id'))) {
			$categories = $this->product_model->getProductCategories($this->input->get('product_id'));
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->category_model->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter_model');

		if (($this->input->post('product_filter'))) {
			$filters = $this->input->post('product_filter');
		} elseif (($this->input->get('product_id'))) {
			$filters = $this->product_model->getProductFilters($this->input->get('product_id'));
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->filter_model->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute_model');

		if (($this->input->post('product_attribute'))) {
			$product_attributes = $this->input->post('product_attribute');
		} elseif (($this->input->get('product_id'))) {
			$product_attributes = $this->product_model->getProductAttributes($this->input->get('product_id'));
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();

		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->attribute_model->getAttribute($product_attribute['attribute_id']);

			if ($attribute_info) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option_model');

		if (($this->input->post('product_option'))) {
			$product_options = $this->input->post('product_option');
		} elseif (($this->input->get('product_id'))) {
			$product_options = $this->product_model->getProductOptions($this->input->get('product_id'));
		} else {
			$product_options = array();
		}

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			$product_option_value_data = array();

			if (($product_option['product_option_value'])) {
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
			}

			$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->option_model->getOptionValues($product_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group_model');

		$data['customer_groups'] = $this->customer_group_model->getCustomerGroups();

		if (($this->input->post('product_discount'))) {
			$product_discounts = $this->input->post('product_discount');
		} elseif (($this->input->get('product_id'))) {
			$product_discounts = $this->product_model->getProductDiscounts($this->input->get('product_id'));
		} else {
			$product_discounts = array();
		}

		$data['product_discounts'] = array();

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = array(
				'customer_group_id' => $product_discount['customer_group_id'],
				'quantity'          => $product_discount['quantity'],
				'priority'          => $product_discount['priority'],
				'price'             => $product_discount['price'],
				'date_start'        => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			);
		}

		if (($this->input->post('product_special'))) {
			$product_specials = $this->input->post('product_special');
		} elseif (($this->input->get('product_id'))) {
			$product_specials = $this->product_model->getProductSpecials($this->input->get('product_id'));
		} else {
			$product_specials = array();
		}

		$data['product_specials'] = array();

		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = array(
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			);
		}
		
		// Image
		if (($this->input->post('image'))) {
			$data['image'] = $this->input->post('image');
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image_model');

		if (($this->input->post('image')) && is_file(DIR_IMAGE . $this->input->post('image'))) {
			$data['thumb'] = $this->image_model->resize($this->input->post('image'), 100, 100);
		} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->image_model->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->image_model->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->image_model->resize('no_image.png', 100, 100);

		// Images
		if (($this->input->post('product_image'))) {
			$product_images = $this->input->post('product_image');
		} elseif (($this->input->get('product_id'))) {
			$product_images = $this->product_model->getProductImages($this->input->get('product_id'));
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->image_model->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download_model');

		if (($this->input->post('product_download'))) {
			$product_downloads = $this->input->post('product_download');
		} elseif (($this->input->get('product_id'))) {
			$product_downloads = $this->product_model->getProductDownloads($this->input->get('product_id'));
		} else {
			$product_downloads = array();
		}

		$data['product_downloads'] = array();

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (($this->input->post('product_related'))) {
			$products = $this->input->post('product_related');
		} elseif (($this->input->get('product_id'))) {
			$products = $this->product_model->getProductRelated($this->input->get('product_id'));
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

		foreach ($products as $product_id) {
			$related_info = $this->product_model->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (($this->input->post('points'))) {
			$data['points'] = $this->input->post('points');
		} elseif (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}

		if (($this->input->post('product_reward'))) {
			$data['product_reward'] = $this->input->post('product_reward');
		} elseif (($this->input->get('product_id'))) {
			$data['product_reward'] = $this->product_model->getProductRewards($this->input->get('product_id'));
		} else {
			$data['product_reward'] = array();
		}

		if (($this->input->post('product_seo_url'))) {
			$data['product_seo_url'] = $this->input->post('product_seo_url');
		} elseif (($this->input->get('product_id'))) {
			$data['product_seo_url'] = $this->product_model->getProductSeoUrls($this->input->get('product_id'));
		} else {
			$data['product_seo_url'] = array();
		}

		if (($this->input->post('product_layout'))) {
			$data['product_layout'] = $this->input->post('product_layout');
		} elseif (($this->input->get('product_id'))) {
			$data['product_layout'] = $this->product_model->getProductLayouts($this->input->get('product_id'));
		} else {
			$data['product_layout'] = array();
		}

		$this->load->model('design/layout_model');

		$data['layouts'] = $this->layout_model->getLayouts();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		
		$this->load->view('catalog/product_form', $data);
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		foreach ($this->input->post('product_description') as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->lang->line('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 1) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->lang->line('error_meta_title');
			}
		}

		if ((utf8_strlen($this->input->post('model')) < 1) || (utf8_strlen($this->input->post('model')) > 64)) {
			$this->error['model'] = $this->lang->line('error_model');
		}

		if ($this->input->post('product_seo_url')) {
			$this->load->model('design/seo_url_model');
			
			foreach ($this->input->post('product_seo_url') as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->lang->line('error_unique');
						}						
						
						$seo_urls = $this->seo_url_model->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!($this->input->get('product_id')) || (($seo_url['query'] != 'product_id=' . $this->input->get('product_id'))))) {
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
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (($this->input->get('filter_name')) || ($this->input->get('filter_model'))) {
			$this->load->model('catalog/product_model');
			$this->load->model('catalog/option_model');

			if (($this->input->get('filter_name'))) {
				$filter_name = $this->input->get('filter_name');
			} else {
				$filter_name = '';
			}

			if (($this->input->get('filter_model'))) {
				$filter_model = $this->input->get('filter_model');
			} else {
				$filter_model = '';
			}

			if (($this->input->get('limit'))) {
				$limit = $this->input->get('limit');
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->product_model->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->product_model->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->option_model->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->option_model->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->configs->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
