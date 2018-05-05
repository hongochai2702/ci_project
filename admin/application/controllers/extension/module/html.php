<?php
class HTML extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('module/html');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('setting/module_model','model_setting_module');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			if (!$this->input->get('module_id')) {
				$this->model_setting_module->addModule('html', $this->input->post());
			} else {
				$this->model_setting_module->editModule($this->input->get('module_id'), $this->input->post());
			}

			$session_success = $this->session->userdata('success');
			$session_success = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data = array_merge($data, $this->lang->loadAll());

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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

		if (!$this->input->get('module_id')) {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('module/html', 'user_token=' . $this->session->userdata('user_token'), true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('module/html', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), true)
			);
		}

		if (!$this->input->get('module_id')) {
			$data['action'] = $this->url->link('module/html', 'user_token=' . $this->session->userdata('user_token'), true);
		} else {
			$data['action'] = $this->url->link('module/html', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true);

		if ($this->input->get('module_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->input->get('module_id'));
		}

		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['module_description'])) {
			$data['module_description'] = $this->request->post['module_description'];
		} elseif (!empty($module_info)) {
			$data['module_description'] = $module_info['module_description'];
		} else {
			$data['module_description'] = array();
		}

		$this->load->model('localisation/language_model','model_localisation_language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('module/html', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/html')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		return !$this->error;
	}
}