<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Module extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('extension/extension/module');

		$this->load->model('setting/extension_model','model_setting_extension');

		$this->load->model('setting/module_model','model_setting_module');

		$this->getList();
	}

	public function install() {
		$this->lang->load('extension/extension/module');

		$this->load->model('setting/extension_model','model_setting_extension');

		$this->load->model('setting/module_model','model_setting_module');
		$session_success = $this->session->userdata('success');
		$session_error = $this->session->userdata('error');
		if ($this->validate()) {
			$this->model_setting_extension->install('module', $this->input->get('extension'));

			$this->load->model('user/user_group_model','model_user_user_group');

			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'module/' . $this->input->get('extension'));
			$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'module/' . $this->input->get('extension'));

			// Call install method if it exsits
			// $this->load->controller('module/' . $this->input->get('extension') . '/install');

			$session_success = $this->session->userdata('success');
		} else {
			$session_error = $this->error['warning'];
		}
	
		$this->getList();
	}

	public function uninstall() {
		$this->lang->load('extension/module');

		$this->load->model('setting/extension_model','model_setting_extension');

		$this->load->model('setting/module_model','model_setting_module');
		$session_success = $this->session->userdata('success');
		if ($this->validate()) {
			$this->model_setting_extension->uninstall('module', $this->input->get('extension'));

			$this->model_setting_module->deleteModulesByCode($this->input->get('extension'));

			// Call uninstall method if it exsits
			$this->load->controller('extension/module/' . $this->input->get('extension') . '/uninstall');

			$session_success = $this->lang->line('text_success');
		}

		$this->getList();
	}
	
	public function add() {
		$this->lang->load('extension/module','model_setting_module');

		$this->load->model('setting/extension_model','model_setting_extension');

		$this->load->model('admmin/setting/module');
		$session_success = $this->session->userdata('success');
		if ($this->validate()) {
			$this->lang->load('module' . '/' . $this->input->get('extension'));
			
			$this->model_setting_module->addModule($this->input->get('extension'), $this->lang->line('heading_title'));

			$session_success = $this->session->userdata('success');
		}

		$this->getList();
	}

	public function delete() {
		$this->lang->load('extension/module');

		$this->load->model('setting/extension_model','model_setting_extension');

		$this->load->model('admmin/setting/module','model_setting_module');
		$session_success = $this->session->userdata('success');
		if ($this->input->get('module_id') && $this->validate()) {
			$this->model_setting_module->deleteModule($this->input->get('module_id'));

			$session_success = $this->session->userdata('success');
		}
		
		$this->getList();
	}

	protected function getList() {
		$data['text_layout'] = sprintf($this->lang->line('text_layout'), $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token'), true));

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

		$extensions = $this->model_setting_extension->getInstalled('module');

		foreach ($extensions as $key => $value) {
			if (!is_file(DIR_APPLICATION . 'controllers/extension/module/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controllers/extension/module/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('module', $value);

				unset($extensions[$key]);
				
				$this->model_setting_module->deleteModulesByCode($value);
			}
		}

		$data['extensions'] = array();

		// Create a new language container so we don't pollute the current one
		// $language = new Language($this->configs->get('config_language'));
		
		// Compatibility code for old extension folders
		$files = glob(DIR_APPLICATION . 'controllers/extension/module/*.php');
		// $this->lang->load('extension/module/' . $extension);
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$data_lang[$extension] = $this->lang->load('extension/module/' . $extension,false, true);
				$module_data = array();

				$modules = $this->model_setting_module->getModulesByCode($extension);

				foreach ($modules as $module) {
					if ($module['setting']) {
						$setting_info = json_decode($module['setting'], true);
					} else {
						$setting_info = array();
					}
					
					$module_data[] = array(
						'module_id' => $module['module_id'],
						'name'      => $module['name'],
						'status'    => (isset($setting_info['status']) && $setting_info['status']) ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
						'edit'      => $this->url->link('extension/module/' . $extension, 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $module['module_id'], true),
						'delete'    => $this->url->link('extension/module/delete', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $module['module_id'], true)
					);
				}

				$data['extensions'][] = array(
					'name'      => $data_lang[$extension]['heading_title'],
					'status'    => $this->configs->get('module_' . $extension . '_status') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
					'module'    => $module_data,
					'install'   => $this->url->link('extension/extension/module/install', 'user_token=' . $this->session->userdata('user_token') . '&extension=' . $extension, true),
					'uninstall' => $this->url->link('extension/extension/module/uninstall', 'user_token=' . $this->session->userdata('user_token') . '&extension=' . $extension, true),
					'installed' => in_array($extension, $extensions),
					'edit'      => $this->url->link('extension/module/' . $extension, 'user_token=' . $this->session->userdata('user_token'), true)
				);
			}
		}
			
		$sort_order = array();

		foreach ($data['extensions'] as $key => $value) {
			$sort_order[$key] = $value['name'];
		}
		$data = array_merge($data, $this->lang->loadAll());
		array_multisort($sort_order, SORT_ASC, $data['extensions']);

		$this->load->view('extension/extension/module', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}
}
