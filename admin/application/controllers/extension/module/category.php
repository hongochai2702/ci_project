<?php
class Category extends MX_Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/category');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('setting/setting_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			$this->setting_model->editSetting('category', $this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), TRUE);
		}

		$data['heading_title'] = $this->lang->line('heading_title');

		$data['text_edit'] = $this->lang->line('text_edit');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');

		$data['entry_status'] = $this->lang->line('entry_status');

		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_module'),
			'href' => $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('extension/module/category', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);

		$data['action'] = $this->url->link('extension/module/category', 'user_token=' . $this->session->userdata('user_token'), TRUE);

		$data['cancel'] = $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), TRUE);

		if ($this->input->post('category_status')) {
			$data['category_status'] = $this->input->post('category_status');
		} else {
			$data['category_status'] = $this->configs->get('category_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('extension/module/category', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/category')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}
}