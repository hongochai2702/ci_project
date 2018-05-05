<?php
class Information extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('module/information');
		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('setting/setting_model','model_setting_setting');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_information', $this->input->post());

			$session_success = $this->session->userdata('success');
			$session_success = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('module/information', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['action'] = $this->url->link('module/information', 'user_token=' . $this->session->userdata('user_token'), true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true);

		if ($this->input->post('module_information_status')) {
			$data['module_information_status'] = $this->input->post('module_information_status');
		} else {
			$data['module_information_status'] = $this->configs->get('module_information_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data = array_merge($data, $this->lang->loadAll());

		$this->load->view('extension/module/information', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/information')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}
}