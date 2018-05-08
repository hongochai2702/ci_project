<?php
class Contact extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('extension/module/contact');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('setting/module_model','model_setting_module');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			if (!$this->input->get('module_id')) {
				$this->model_setting_module->addModule('contact', $this->input->post());
			} else {
				$this->model_setting_module->editModule($this->input->get('module_id'), $this->input->post());
			}

			$this->cache->delete('product');

			$session_success = $this->session->userdata('success');
$session_success = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token') . '&type=module', true));
		}
    
		$data = array();
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

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
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
				'href' => $this->url->link('extension/module/contact', 'user_token=' . $this->session->userdata('user_token'), true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('extension/module/contact', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), true)
			);
		}

		if (!$this->input->get('module_id')) {
			$data['action'] = $this->url->link('extension/module/contact', 'user_token=' . $this->session->userdata('user_token'), true);
		} else {
			$data['action'] = $this->url->link('extension/module/contact', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), true);
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

		

		

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('extension/module/contact', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/contact')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		return !$this->error;
	}
}