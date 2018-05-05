<?php
class Information extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('catalog/information');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/information_model','model_catalog_information');

		$this->getList();
	}

	public function add() {
		$this->lang->load('catalog/information');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/information_model','model_catalog_information');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_catalog_information->addInformation($this->input->post());

			$success_data = $this->session->userdata('success');
			$success_data = $this->lang->line('text_success');

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

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->lang->load('catalog/information');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/information_model','model_catalog_information');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_catalog_information->editInformation($this->input->get('information_id'), $this->input->post());

			$success_data = $this->session->userdata('success');
$success_data = $this->lang->line('text_success');

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

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->lang->load('catalog/information');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('catalog/information_model','model_catalog_information');

		if ($this->input->post('selected') && $this->validateDelete()) {
			foreach ($this->input->post('selected') as $information_id) {
				$this->model_catalog_information->deleteInformation($information_id);
			}

			$success_data = $this->session->userdata('success');
$success_data = $this->lang->line('text_success');

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

			$this->response->redirect($this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if ($this->input->get('sort')) {
			$sort = $this->input->get('sort');
		} else {
			$sort = 'id.title';
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
		$data = array_merge($data, $this->lang->loadAll());
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		$data['add'] = $this->url->link('catalog/information/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['delete'] = $this->url->link('catalog/information/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		$data['informations'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit' => $this->configs->get('config_limit_admin')
		);

		$information_total = $this->model_catalog_information->getTotalInformations();

		$results = $this->model_catalog_information->getInformations($filter_data);

		foreach ($results as $result) {
			$data['informations'][] = array(
				'information_id' => $result['information_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'edit'           => $this->url->link('catalog/information/edit', 'user_token=' . $this->session->userdata('user_token') . '&information_id=' . $result['information_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->lang->line('heading_title');

		$data['text_list'] = $this->lang->line('text_list');
		$data['text_no_results'] = $this->lang->line('text_no_results');
		$data['text_confirm'] = $this->lang->line('text_confirm');

		$data['column_title'] = $this->lang->line('column_title');
		$data['column_sort_order'] = $this->lang->line('column_sort_order');
		$data['column_action'] = $this->lang->line('column_action');

		$data['button_add'] = $this->lang->line('button_add');
		$data['button_edit'] = $this->lang->line('button_edit');
		$data['button_delete'] = $this->lang->line('button_delete');

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

		$data['sort_title'] = $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . '&sort=i.sort_order' . $url, true);

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		$pagination = new Pagination();
		$pagination->total = $information_total;
		$pagination->page = $page;
		$pagination->limit = $this->configs->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->lang->line('text_pagination'), ($information_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($information_total - $this->configs->get('config_limit_admin'))) ? $information_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $information_total, ceil($information_total / $this->configs->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('catalog/information_list', $data);
	}

	protected function getForm() {

		$data['heading_title'] = $this->lang->line('heading_title');

		$data['text_form'] = !$this->input->get('information_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
		$data = array_merge($data, $this->lang->loadAll());

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
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
			'href' => $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		if (!$this->input->get('information_id')) {
			$data['action'] = $this->url->link('catalog/information/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/information/edit', 'user_token=' . $this->session->userdata('user_token') . '&information_id=' . $this->input->get('information_id') . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		if ($this->input->get('information_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$information_info = $this->model_catalog_information->getInformation($this->input->get('information_id'));
		}

		$data['user_token'] = $this->session->userdata('user_token');

		$this->load->model('localisation/language_model','model_localisation_language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if ($this->input->post('information_description')) {
			$data['information_description'] = $this->input->post('information_description');
		} elseif ($this->input->get('information_id')) {
			$data['information_description'] = $this->model_catalog_information->getInformationDescriptions($this->input->get('information_id'));
		} else {
			$data['information_description'] = array();
		}

		$this->load->model('setting/store_model','model_setting_store');

		$data['stores'] = $this->model_setting_store->getStores();

		if ($this->input->post('information_store')) {
			$data['information_store'] = $this->input->post('information_store');
		} elseif ($this->input->get('information_id')) {
			$data['information_store'] = $this->model_catalog_information->getInformationStores($this->input->get('information_id'));
		} else {
			$data['information_store'] = array(0);
		}

		if ($this->input->post('keyword')) {
			$data['keyword'] = $this->input->post('keyword');
		} elseif (!empty($information_info)) {
			$data['keyword'] = $information_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if ($this->input->post('bottom')) {
			$data['bottom'] = $this->input->post('bottom');
		} elseif (!empty($information_info)) {
			$data['bottom'] = $information_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($information_info)) {
			$data['status'] = $information_info['status'];
		} else {
			$data['status'] = true;
		}

		if ($this->input->post('sort_order')) {
			$data['sort_order'] = $this->input->post('sort_order');
		} elseif (!empty($information_info)) {
			$data['sort_order'] = $information_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if ($this->input->post('information_layout')) {
			$data['information_layout'] = $this->input->post('information_layout');
		} elseif ($this->input->get('information_id')) {
			$data['information_layout'] = $this->model_catalog_information->getInformationLayouts($this->input->get('information_id'));
		} else {
			$data['information_layout'] = array();
		}

		$this->load->model('design/layout_model','model_design_layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('catalog/information_form', $data);
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		foreach ($this->input->post('information_description') as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->lang->line('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->lang->line('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->lang->line('error_meta_title');
			}
		}

		if (utf8_strlen($this->input->post('keyword')) > 0) {
			$this->load->model('catalog/seo_url_model','model_catalog_seo_url');

			$seo_url_info = $this->model_catalog_seo_url->getUrlAlias($this->input->post('keyword'));

			if (($seo_url_info && $this->input->get('information_id')) && ($seo_url_info['query'] != 'information_id=' . $this->input->get('information_id'))) {
				$this->error['keyword'] = sprintf($this->lang->line('error_keyword'));
			}

			if ($seo_url_info && !$this->input->get('information_id')) {
				$this->error['keyword'] = sprintf($this->lang->line('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->lang->line('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		$this->load->model('setting/store_model','model_setting_store');

		foreach ($this->input->post('selected') as $information_id) {
			if ($this->configs->get('config_account_id') == $information_id) {
				$this->error['warning'] = $this->lang->line('error_account');
			}

			if ($this->configs->get('config_checkout_id') == $information_id) {
				$this->error['warning'] = $this->lang->line('error_checkout');
			}

			if ($this->configs->get('config_affiliate_id') == $information_id) {
				$this->error['warning'] = $this->lang->line('error_affiliate');
			}

			if ($this->configs->get('config_return_id') == $information_id) {
				$this->error['warning'] = $this->lang->line('error_return');
			}

			$store_total = $this->model_setting_store->getTotalStoresByInformationId($information_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->lang->line('error_store'), $store_total);
			}
		}

		return !$this->error;
	}
}