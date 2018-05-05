<?php
class HTML extends MX_Controller {
	public function index($setting = array()) {
		$module_id = 0;
		if (isset($setting['module_description'][$this->configs->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->configs->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->configs->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
			$data['module_id'] = $module_id++;

			return $this->load->view('default/extension/module/html_view', $data, true);
		}
	}
}