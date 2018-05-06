<?php
class VisualBuilder extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('extension/module/visualbuilder');
		
		$catalogURL = $this->getCatalogURL();
		
		$this->document->setTitle($this->lang->line('heading_title'));
		$this->document->addStyle('public/stylesheet/visualbuilder/visualbuilder.css');
		$this->document->addStyle('public/stylesheet/visualbuilder/switchy.css');
		$this->document->addStyle('public/stylesheet/visualbuilder/multiselect.css');
		$this->document->addScript('public/javascript/visualbuilder/builder.js');
		$this->document->addScript('public/javascript/visualbuilder/jquery-ui.min.js');
		$this->document->addScript('public/javascript/visualbuilder/jquery.multi-select.js');
		$this->document->addScript('public/javascript/visualbuilder/switchy.js');

		$this->load->model('extension/module/visualbuilder_model','model_module_visualbuilder');
		
		$this->getForm();
	}
	
	/**
	 * Save module settings
	 */
	public function saveModuleSettings(){
			
		$this->lang->load('extension/module/visualbuilder');
		
		if (!$this->user->hasPermission('modify', 'module/visualbuilder')) {
			$this->error['warning'] = $this->lang->line('error_permission');
			die(  $this->error['warning'] );
		}	
		
		$this->load->model('setting/setting_model','model_setting_setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('visualbuilder', $this->input->post());
			echo json_encode(array_values($this->input->post()));	
		} 
	}
	public function edit() {
			
		$this->lang->load('extension/module/visualbuilder');
		
		$this->load->model('extension/module/visualbuilder_model','model_module_visualbuilder');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			
			if ($this->input->get('layout_id')) {
				$selectedlayout = $this->input->get('layout_id');
			} else {
				$selectedlayout = 1;
			}
						
			$this->model_module_visualbuilder->editLayout($selectedlayout, $this->input->post());

			$this->session->set_userdata('success',$this->lang->line('text_success'));

			$url = '&layout_id=' . $selectedlayout;

			$this->response->redirect($this->url->link('extension/module/visualbuilder', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE));
		}

		$this->getForm();
	}

	
    /**
     *
     */
    protected function getForm() {
		
		$languageVariables = array(
            'heading_title',
            'text_module',
            'text_choose_layout',
            'text_builder',
            'text_success',
            'text_edit',
            'text_content_top',
            'text_content_bottom',
            'text_column_right',
            'text_column_left',
            'text_active_modules',
            'text_available_modules',
            'text_excluded_modules',
            'text_settings',
            'text_selected_banner',
            'text_you_are_editing',
            'text_module_settings',
            'text_module_settings_help',
            'text_module_success',
            'text_image_size',
            'text_choose_layout',
            'text_build',
            'text_view',
            'text_layout',
            'button_apply',
            'button_save',
            'button_cancel',
            'error_input_form',
         	'heading_title',
			'text_edit',
			'text_default',
			'text_enabled',
			'text_disabled',
			'text_module_disabled',
			'entry_name',
			'entry_store',
			'entry_route',
			'entry_module',
			'entry_position',
			'entry_sort_order',
			'button_save',
			'button_cancel',
			'button_route_add',
			'button_module_add',
			'button_remove',
			'text_top1',
			'text_top2',
			'text_menu',
			'text_slide',
			'text_content_buttom2',
			'text_footer_top',
			'text_footer_bottom',
			'text_descripotion_all',
			'text_descripotion_layout',


        );
       
        foreach ($languageVariables as $languageVariable) {
            $data[$languageVariable] = $this->lang->line($languageVariable);
        }

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


		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$url = '';
		
		if ($this->input->get(['sort'])) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get(['order'])) {
			$url .= '&order=' . $this->input->get('order');
		}

		if ($this->input->get(['page'])) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), TRUE)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('extension/module/visualbuilder', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE)
		);
		
		$data['saveModulePositions'] = $this->url->link('extension/module/visualbuilder/saveModuleSettings', 'user_token=' . $this->session->userdata('user_token'), TRUE);
		
		$data['excluded_modules'] = array();
		
		if($this->configs->get('visualbuilder_excluded')){
			$data['excluded_modules'] = $this->configs->get('visualbuilder_excluded');
		}
		
		$data['layouts'] = array();

		$layout_total = $this->model_module_visualbuilder->getTotalLayouts();

		$results = $this->model_module_visualbuilder->getLayouts();
		
		

		foreach ($results as $result) {
				
			$routes = $this->model_module_visualbuilder->getLayoutRoute($result['layout_id']);
			
			foreach( $routes as $route ) {
					if($route['route']=="product/product") $layout_route=$route['route'].'&product_id='.$this->getProductId();
					else if($route['route']=="product/category") $layout_route=$route['route'].'&path='.$this->getCategoryId();
					else if($route['route']=="checkout/") $layout_route=$route['route'].'cart';
					else if($route['route']=="account") $layout_route=$route['route'].'/account';
					else if($route['route']=="affiliate/") $layout_route=$route['route'].'account';
					else if($route['route']=="information/information") $layout_route=$route['route'].'&information_id='.$this->getInformationId();
					else $layout_route=$route['route'];

			}
			
			
			$data['layouts'][] = array(
				'layout_id' => $result['layout_id'],
				'name'      => $result['name'],
				'route'		=> $layout_route,
				'edit'      => $this->url->link('extension/module/visualbuilder', 'user_token=' . $this->session->userdata('user_token') . '&layout_id=' . $result['layout_id'] . $url, TRUE)
			);
		}
				
		
		if (!$this->input->get(['layout_id'])) {
			$data['selected_layout'] = 1;
		} else {
			$data['selected_layout'] = $this->input->get('layout_id');
		}
		
		$data['action'] = $this->url->link('extension/module/visualbuilder/edit', 'user_token=' . $this->session->userdata('user_token') . '&layout_id=' . $data['selected_layout'] . $url, TRUE);

		$data['cancel'] = $this->url->link('extension/module/visualbuilder', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE);


		$layout_info = $this->model_module_visualbuilder->getLayout($data['selected_layout']);
		
		$data['layoutmodules'] = $this->model_module_visualbuilder->getLayoutModules($data['selected_layout']);
		

		if (isset($this->input->post['name'])) {
			$data['name'] = $this->input->post['name'];
		} elseif (!empty($layout_info)) {
			$data['name'] = $layout_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('setting/store_model','model_setting_store');

		$data['stores'] = $this->model_setting_store->getStores();

		if ($this->input->post('layout_route')) {
			$data['layout_routes'] = $this->input->post('layout_route');
		} elseif (isset($data['selected_layout'])) {
			$data['layout_routes'] = $this->model_module_visualbuilder->getLayoutRoutes($data['selected_layout']);
		} else {
			$data['layout_routes'] = array();
		}
		
		if ($this->input->post('layout_module')) {
			$data['layout_modules'] = $this->input->post('layout_module');
		} elseif (isset($data['selected_layout'])) {
			$data['layout_modules'] = $this->model_module_visualbuilder->getLayoutModules($data['selected_layout']);
		} else {
			$data['layout_modules'] = array();
		}
		
		$this->load->model('extension/extension_model','model_extension_extension');

		$this->load->model('extension/module_model','model_extension_module');
		
		$data['modules'] = array();
		
		$extensions = $this->model_extension_extension->getInstalled('module');
		
		foreach ($extensions as $code) {
			$this->lang->load('extension/module/' . $code);
			$data = array_merge( $data, $this->lang->loadAll() );
			$module_data = array();
			$settings_data = array();

			$modules = $this->model_extension_module->getModulesByCode($code);
			
			foreach ($modules as $module) {

				if( is_serialized( $module['setting'] ) ) {
					$module_setting = unserialize($module['setting']);
				} else {
					$module_setting = json_decode($module['setting'], true);
				}

				$module_data[] = array(
					'name' => $this->lang->line('heading_title') . ' &gt; ' . $module['name'],
					'code' => $code . '.' .  $module['module_id'],
					'setting' => $module_setting,
					'href' => $this->url->link('extension/module/' . $code, 'user_token=' . $this->session->userdata('user_token') . '&module_id='.$module['module_id'] . $url, TRUE),
					'group' => $code
				);
				}
			
			if ($module_data) {
				$data['modules'][] = array(
					'name'   => $this->lang->line('heading_title'),
					'hasSettings'   => true,
					'module' => $module_data,
					'module_link' => $this->url->link('extension/module/' . $code . '', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE),
					'group' => $code
				);
			} else {
				if($code!="visualbuilder"){
					$settings_data = array(
						'name' => $this->lang->line('heading_title'),
						'status' => $this->configs->get($code.'_status')
					);
				
					$module_data[] = array(
						'name' => $this->lang->line('heading_title'),
						'code' => $code,
						'setting' => $settings_data,
						'href' => $this->url->link('extension/module/' . $code . '', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE),
						'group' => $code
					);
					
					$data['modules'][] = array(
						'name'   => $this->lang->line('heading_title'),
						'hasSettings'   => false,
						'module' => $module_data,
						'module_link' => $this->url->link('extension/module/' . $code . '', 'user_token=' . $this->session->userdata('user_token') . $url, TRUE),
						'group' => $code
					);
					
					}
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Require file position.
		$data['show_position'] = false;
		if( file_exists(DIR_CONFIG.'position.php') ){
			include DIR_CONFIG . 'position.php'; 
			if( !in_array( $this->configs->get('config_template'), $themes_not_use_position ) ){
				$data['show_position'] = true;
			}
		}

		$this->response->setOutput($this->load->view('extension/module/visualbuilder_form', $data));
	}

	protected function getProductId(){
		return $data['productId'] = $this->model_module_visualbuilder->getProductId();
	} 
	 
	protected function getCategoryId(){
		return $data['categoryId'] = $this->model_module_visualbuilder->getCategoryId();
	} 
	protected function getInformationId(){
		return $data['informationId'] = $this->model_module_visualbuilder->getInformationId();
	} 
	
	protected function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/visualbuilder')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}
		return !$this->error;
	}


}