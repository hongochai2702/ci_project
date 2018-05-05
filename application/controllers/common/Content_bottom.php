<?php
class Content_bottom extends MX_Controller {
	public function index() {
		$this->load->model('design/layout_model');
		$this->load->helper('url');
		$routing = $this->uri->uri_string();
		if ( $routing != NULL ) {
		    $routing = (string)$this->uri->uri_string();
		} else {
			$routing = 'common/home';
		}
		$layout_id = 1;

		if ($routing == 'product/category' && ($this->input->get('path'))) {
			$this->load->model('category_model');

			$path = explode('_', (string)$this->input->get('path'));

			$layout_id = $this->category_model->getCategoryLayoutId(end($path));
		}

		if ($routing == 'product/product' && ($this->input->get('product_id'))) {
			$this->load->model('product_model');

			$layout_id = $this->product_model->getProductLayoutId($this->input->get('product_id'));
		}

		if ($routing == 'information/information' && ($this->input->get('information_id'))) {
			$this->load->model('information_model');

			$layout_id = $this->information_model->getInformationLayoutId($this->input->get('information_id'));
		}

		if (!$layout_id) {
			$layout_id = $this->layout_model->getLayout($routing);
		}

		if (!$layout_id) {
			$layout_id = $this->configs->get('config_layout_id');
		}

		$this->load->model('setting/module_model');

		$data['modules'] = array();

		$modules = $this->layout_model->getLayoutModules($layout_id, 'content_bottom');
		
		if($modules) {
			foreach ($modules as $module) {

    			$part = explode('.', $module['code']);
    
    			if (isset($part[0]) && $this->configs->get('module_' . $part[0] . '_status')) {
    				$module_data = $this->load->controller('extension/module/' . $part[0]);
    
    				if ($module_data) {
    					$data['modules'][] = $module_data;
    				}
    			}
    
    			if (isset($part[1])) {
    				$setting_info = $this->module_model->getModule($part[1]);
    				
    				if ($setting_info && $setting_info['status']) {
    					$output = $this->load->controller('extension/module/' . $part[0], $setting_info);
    					if ($output) {
    						$data['modules'][] = $output;
    					}
    				}
    			}
    		}
		}

		

		return $this->load->view('default/common/content_bottom', $data, true);
	}
}
