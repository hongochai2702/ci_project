<?php
class Module_Col extends MX_Controller {
	private $error = array();
	public function index() {
		$this->lang->load('extension/module/module_col');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('extension/module_model','model_extension_module');

		$this->document->addScript('public/javascript/dv-builder/jquery-ui.js');
		$this->document->addStyle('public/stylesheet/dv-builder/dv-builder.css');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
				
			if ($this->input->get('module_id')) {
				
				$this->model_extension_module->editModule($this->input->get('module_id'), $this->input->post());
			} else {
				$this->model_extension_module->addModule('module_col', $this->input->post());
			}
            $all_module_child=$this->model_extension_module->getModulesByCode("module_col");
            $module_child_current=array('module_id'=>0);
            foreach ($all_module_child as $key_module_child=>$item_module_child){
                if($module_child_current['module_id']<$item_module_child['module_id'])
                        $module_child_current=$item_module_child;
            }
            if(!empty($this->input->get('module_id')))
                            $module_child_current['module_id']=$this->input->get('module_id');
			$this->session->set_userdata('success',$this->lang->line('text_success'));
			$this->response->redirect($this->url->link('extension/module/module_col', 'user_token=' . $this->session->userdata('user_token')."&module_id=".$module_child_current['module_id'], TRUE));
		}
        if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_edit'] = $this->lang->line('text_edit');
		$data['text_enabled'] = $this->lang->line('text_enabled');
		$data['text_disabled'] = $this->lang->line('text_disabled');

		$data['entry_title'] = $this->lang->line('entry_title');
		$data['entry_title_show'] = $this->lang->line('entry_title_show');
		$data['entry_show'] = $this->lang->line('entry_show');
		$data['entry_hide'] = $this->lang->line('entry_hide');
		$data['entry_edit_module_custom'] = $this->lang->line('entry_edit_module_custom');
		$data['entry_alert_choose_col'] = $this->lang->line('entry_alert_choose_col');
		$data['entry_alert_input_col'] = $this->lang->line('entry_alert_input_col');
		$data['entry_add'] = $this->lang->line('entry_add');
		$data['entry_status'] = $this->lang->line('entry_status');

		$data['button_save'] = $this->lang->line('button_save');
		$data['button_cancel'] = $this->lang->line('button_cancel');
		$data['entry_module'] = $this->lang->line('entry_module');
		$data['entry_class'] = $this->lang->line('entry_class');
		$data['entry_class_placehoder'] = $this->lang->line('entry_class_placehoder');
		$data['entry_class_des'] = $this->lang->line('entry_class_des');
		$data['entry_title_bootstrap_des'] = $this->lang->line('entry_title_bootstrap_des');
		$data['entry_title_bootstrap'] = $this->lang->line('entry_title_bootstrap');
		$data['entry_hide_show'] = $this->lang->line('entry_hide_show');
		$data['entry_active'] = $this->lang->line('entry_active');
		$data['entry_full'] = $this->lang->line('entry_full');
		$data['entry_not_full'] = $this->lang->line('entry_not_full');
		$data['entry_title_full'] = $this->lang->line('entry_title_full');
		$data['entry_id_dv'] = $this->lang->line('entry_id_dv');
		$data['entry_id_placehoder'] = $this->lang->line('entry_id_placehoder');
		$data['text_module'] = $this->lang->line('text_module');

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
                
		if (isset($this->error['module'])) {
			$data['error_module'] = $this->error['module'];
		} else {
			$data['error_module'] = '';
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

		if (!$this->input->get('module_id')) {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('extension/module/module_col', 'user_token=' . $this->session->userdata('user_token'), TRUE)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('heading_title'),
				'href' => $this->url->link('extension/module/module_col', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), TRUE)
			);
		}

		if (!$this->input->get('module_id')) {
			$data['action'] = $this->url->link('extension/module/module_col', 'user_token=' . $this->session->userdata('user_token'), TRUE);
		} else {
			$data['action'] = $this->url->link('extension/module/module_col', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), TRUE);
		}

		$data['cancel'] = $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), TRUE);

		if ($this->input->get('module_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->input->get('module_id'));
		}

		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
                
		if ($this->input->post('title')) {
			$data['title'] = $this->input->post('title');
		} elseif (!empty($module_info)) {
			$data['title'] = $module_info['title'];
		} else {
			$data['title'] = '';
		}
                
        if ($this->input->post('class')) {
			$data['class'] = $this->input->post('class');
		} elseif (!empty($module_info['class'])) {
			$data['class'] = $module_info['class'];
		} else {
			$data['class'] = '';
		}
                if ($this->input->post('id_dv')) {
			$data['id_dv'] = preg_replace(array("/\s+/","/-+/"),"_", trim($this->input->post('id_dv'))); 
		} elseif (!empty($module_info['id_dv'])) {
			$data['id_dv'] = preg_replace(array("/\s+/","/-+/"),"_", trim($module_info['id_dv']));
		} else {
			$data['id_dv'] = '';
		}
                
        if ($this->input->post('col_ms')) {
			$data['col_ms'] = $this->input->post('col_ms');
		} elseif (!empty($module_info)) {
			$data['col_ms'] = $module_info['col_ms'];
		} else {
			$data['col_ms'] = 1;
		}
                
		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		if ($this->input->post('width_full')) {
			$data['width_full'] = $this->input->post('width_full');
		} elseif (!empty($module_info)) {
			$data['width_full'] = $module_info['width_full'];
		} else {
			$data['width_full'] = 0;
		}
		if ($this->input->post('title_show')) {
			$data['show_title'] = $this->input->post('show_title');
		} elseif (!empty($module_info)) {
			$data['show_title'] = $module_info['show_title'];
		} else {
			$data['show_title'] = 1;
		}
		if ($this->input->post('module')) {
			$data['module'] = $this->input->post('module');
		} elseif (!empty($module_info)) {
			$data['module'] = $module_info['module'];
		} else {
			$data['module'] = '';
		}
                $data['modules']=array();
                if(!empty($data['module'])){
                    foreach ($data['module'] as $keys=>$items){
                        $item_setting=explode("quocdvowow",$items);
                        
                        if(!empty($item_setting) && $item_setting['2']!=1){
                            $data['modules'][$keys][0]=$item_setting[0];
                            $modules_code=explode("quocdvkaka",$item_setting[2]);                            
                            $modules_name=explode("quocdvkaka",$item_setting[1]);
                            foreach($modules_code as $key=>$item_module){
                                $part=explode(".",$item_module);
                                if(isset($part[1])){
                                        $module=$this->model_extension_module->getModule($part[1]);
                                        $data['modules'][$keys][1][$key]=$module['name']; // Name
                                        $data['modules'][$keys][2][$key]=$item_module; // code
                                        $data['modules'][$keys][3][$key]=html_entity_decode($this->url->link('module/'.$part[0], 'user_token=' . $this->session->userdata('user_token')."&module_id=".$part[1], TRUE));
                                        $data['modules'][$keys][4][$key]=$module['status']; // Name
                                }
                                else{
                                    $this->lang->load('extension/module/' . $item_module);
                                    $data['modules'][$keys][1][$key]=$this->lang->line('heading_title'); // Name
                                    $data['modules'][$keys][2][$key]=$item_module; // code
                                    $data['modules'][$keys][3][$key]=  html_entity_decode($this->url->link('extension/module/'.$item_module, 'user_token=' . $this->session->userdata('user_token'), TRUE));
                                    $data['modules'][$keys][4][$key]=$this->configs->get($item_module . '_status');
                                }
                            }
                        }
                    }
                }
                //var_dump($data['modules']);
                $this->load->model('extension/extension_model','model_extension_extension');
                $extensions = $this->model_extension_extension->getInstalled('module');
                $module_data=array();
		$id_module_current=-1;
		if(!empty($this->input->get('module_id')))
                $id_module_current=$this->input->get('module_id');
                foreach ($extensions as $key_module=>$item_module){
                    $this->lang->load('extension/module/' . $item_module);
                    $modules = $this->model_extension_module->getModulesByCode($item_module);
                    $module_child = array();
                    foreach ($modules as $module) {
						if($module['module_id']!=$id_module_current) {
							$module_child[] = array(
									'name' => $module['name'],
									'module' => $item_module . "." . $module['module_id'],
									'edit_link' => $this->url->link('extension/module/'.$item_module, 'user_token=' . $this->session->userdata('user_token')."&module_id=".$module['module_id'], TRUE)
							);
						}
                    }
                    if (($this->configs->has($item_module . '_status') || $module_child) && $item_module!="module_col") {
                    $module_data[]=array(
                        'name'  => $this->lang->line('heading_title'),
                        'module'  =>$item_module,
                        'module_child'=>$module_child,
			'edit_link' => $this->url->link('extension/module/'.$item_module, 'user_token=' . $this->session->userdata('user_token'), TRUE)
                    );
                    }
                }
        $data['module_active']=$module_data;
		$this->load->model('localisation/language_model','model_localisation_language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('extension/module/module_col', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/module_col')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}
        if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
                $this->error['name'] = $this->lang->line('error_name');
        }
		if (empty($this->input->post('module'))) {
			$this->error['module'] = $this->lang->line('error_module');
		}

		return !$this->error;
	}
}