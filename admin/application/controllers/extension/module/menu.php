<?php
class Menu extends MX_Controller {

	private $error = array();
	
	public function index() {
	
		$this->load->language('extension/module/menu');
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->load->model('extension/module_model');
		
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			if (!($this->input->get('module_id'))) {
				$this->module_model->addModule('menu', $this->input->post());
			} else {
				$this->module_model->editModule($this->input->get('module_id'), $this->input->post());
			}
			$this->session->set_userdata('success',$this->lang->line('text_success'));
			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token'), TRUE));
		}
		
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_edit'] = $this->lang->line('text_edit');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');
		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_menu'] = $this->lang->line('entry_menu');
		$data['entry_width'] = $this->lang->line('entry_width');
		$data['entry_height'] = $this->lang->line('entry_height');
		$data['entry_size'] = $this->lang->line('entry_size');
		$data['entry_status'] = $this->lang->line('entry_status');
		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');
		$data['entry_name_lang'] = $this->lang->line('entry_name_lang');
		
		if (isset($this->error['warning'])) { $data['error_warning'] = $this->error['warning']; } else { $data['error_warning'] = ''; }
		if (isset($this->error['name'])) { $data['error_name'] = $this->error['name']; } else { $data['error_name'] = ''; }
		if (isset($this->error['width'])) { $data['error_width'] = $this->error['width']; } else { $data['error_width'] = ''; }
		if (isset($this->error['height'])) { $data['error_height'] = $this->error['height']; } else { $data['error_height'] = ''; }
		if (isset($this->error['size'])) { $data['error_size'] = $this->error['size']; } else { $data['error_size'] = ''; }
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);
		if (!($this->input->get('module_id'))) {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('extension/module/menu', 'user_token=' . $this->session->userdata('user_token'), TRUE)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('extension/module/menu', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), TRUE)
			);
		}
		
		if (!($this->input->get('module_id'))) {
			$data['action'] = $this->url->link('extension/module/menu', 'user_token=' . $this->session->userdata('user_token'), TRUE);
		} else {
			$data['action'] = $this->url->link('extension/module/menu', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), TRUE);
		}
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token'), TRUE);
		
		if (($this->input->get('module_id')) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$module_info = $this->module_model->getModule($this->input->get('module_id'));
		}
                $this->load->model('localisation/language_model');
		$data['languages'] = $this->language_model->getLanguages();
		if (($this->input->post('name'))) { $data['name'] = $this->input->post('name'); } elseif (!empty($module_info)) { $data['name'] = $module_info['name']; } else { $data['name'] = ''; }
		if (($this->input->post('menu_id'))) { $data['menu_id'] = $this->input->post('menu_id'); } elseif (!empty($module_info)) { $data['menu_id'] = $module_info['menu_id']; } else { $data['menu_id'] = ''; }
		if (($this->input->post('width'))) { $data['width'] = $this->input->post('width'); } elseif (!empty($module_info)) { $data['width'] = $module_info['width']; } else { $data['width'] = ''; }
		if (($this->input->post('height'))) { $data['height'] = $this->input->post('height'); } elseif (!empty($module_info)) { $data['height'] = $module_info['height']; } else { $data['height'] = ''; }
		if (($this->input->post('size'))) { $data['size'] = $this->input->post('size'); } elseif (!empty($module_info)) { $data['size'] = $module_info['size']; } else { $data['size'] = ''; }
		if (($this->input->post('status'))) { $data['status'] = $this->input->post('status'); } elseif (!empty($module_info)) { $data['status'] = $module_info['status']; } else { $data['status'] = ''; }
                if (($this->input->post('name'))) 
                    { $data['name_lang'] = $this->input->post('name_lang'); }
                elseif (!empty($module_info))
                    { $data['name_lang'] = $module_info['name_lang']; }
                else 
                    { $data['name_lang'] = array(); }
		
                
		$this->load->model('design/menu_model');
		$data['menus'] = $this->menu_model->getMenus();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->load->view('extension/module/menu', $data);
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/menu')) { $this->error['warning'] = $this->lang->line('error_permission'); }
		if ((strlen($this->input->post('name')) < 3) || (strlen($this->input->post('name')) > 64)) { $this->error['name'] = $this->lang->line('error_name'); }
		if ((strlen($this->input->post('width')) < 1) || (strlen($this->input->post('width')) > 64)) { $this->error['width'] = $this->lang->line('error_width'); }
		if ((strlen($this->input->post('height')) < 1) || (strlen($this->input->post('height')) > 64)) { $this->error['height'] = $this->lang->line('error_height'); }
		if ((strlen($this->input->post('size')) < 1) || (strlen($this->input->post('size')) > 64)) { $this->error['size'] = $this->lang->line('error_size'); }
		return !$this->error;
	}

}