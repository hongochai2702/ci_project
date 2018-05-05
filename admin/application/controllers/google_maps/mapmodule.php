<?php
class MapModule extends MX_Controller
{
	private $error = array();

	public function index()
	{
		//--Loading current active language file
		$this->load->language('google_maps/mapmodule');
		$this->load->language('google_maps/location');

		//--Load Helper
		$this->load->helper('google_maps_helper');

		//--Load and assign Info
		$data['gmaps_info']		= gmaps_make_doc();
		$data['gmaps_about']	= gmaps_make_doc('<div style="font-family: \'Courier New\', Courier, monospace">', '</div>', '  - ', '<br />', str_repeat('&nbsp;', 4));

		//--Load and assign Donate button
		$data['gmaps_donate'] = gmaps_donate_button();



		$this->load->model('extension/module_model','model_extension_module');
		//--Check form post
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			if (!$this->input->get('module_id')) {
				$this->model_extension_module->addModule('google_maps', $this->input->post());
			} else {
				$this->model_extension_module->editModule($this->input->get('module_id'), $this->input->post());
			}

			$this->session->data['success'] = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), 'SSL'));
		}


		//--Assign translation to $data array
		$data = array_merge($data, $this->lang->loadAll(), gmaps_info());


		//--Document Scripts and Styles
		$this->document->setTitle($data['heading_title']);
		$this->document->addScript( 'public/javascript/jquery/cnplugins/jquery.predefinedinput-1.0.1.js');


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

		if (isset($this->error['ids'])) {
			$data['error_ids'] = $this->error['ids'];
		} else {
			$data['error_ids'] = '';
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


		//--Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->lang->line('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->userdata('user_token'), 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->lang->line('text_module'),
			'href'      => $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->lang->line('heading_title'),
			'href'      => $this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text'      => !$this->input->get('module_id') ? $this->lang->line('text_title') : $this->lang->line('text_title_edit'),
			'href'      => $this->url->link('google_maps/mapmodule', 'user_token=' . $this->session->userdata('user_token') . (!$this->input->get('module_id') ? '' : '&module_id=' . $this->input->get('module_id')), 'SSL')
		);
		//--


		$data['action'] = $this->url->link('google_maps/mapmodule', 'user_token=' . $this->session->userdata('user_token') . (!$this->input->get('module_id') ? '' : '&module_id=' . $this->input->get('module_id')), 'SSL');
		$data['cancel'] = $this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), 'SSL');


		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');

		//--Maps
		$data['gmaps'] = array();
		if ($this->input->post('google_maps_module_map')) {
			$data['gmaps'] = $this->input->post('google_maps_module_map');
		}
		elseif ($this->configs->has('google_maps_module_map'))
		{
			$data['gmaps'] = $this->configs->get('google_maps_module_map');
		}
		//--


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

		if ($this->input->post('ids')) {
			$data['ids'] = $this->input->post('ids');
		} elseif (!empty($module_info)) {
			$data['ids'] = $module_info['ids'];
		} else {
			$data['ids'] = '';
		}

		if ($this->input->post('width')) {
			$data['width'] = $this->input->post('width');
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '';
		}

		if ($this->input->post('height')) {
			$data['height'] = $this->input->post('height');
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = '';
		}

		if ($this->input->post('zoom')) {
			$data['zoom'] = $this->input->post('zoom');
		} elseif (!empty($module_info)) {
			$data['zoom'] = $module_info['zoom'];
		} else {
			$data['zoom'] = '';
		}

		if ($this->input->post('maptype')) {
			$data['maptype'] = $this->input->post('maptype');
		} elseif (!empty($module_info)) {
			$data['maptype'] = $module_info['maptype'];
		} else {
			$data['maptype'] = '';
		}

		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}


		$this->load->model('localisation/language_model','model_localisation_language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $this->session->userdata('user_token');

		$this->load->view('google_maps/mapmodule', $data);
	}

	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'google_maps/mapmodule'))
		{
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		if (!$this->input->post('ids')) {
			$this->error['ids'] = $input->lang->line('error_ids');
		}

		if (!$this->input->post('width')) {
			$this->error['width'] = $this->lang->line('error_width');
		}

		if (!$this->input->post('height')) {
			$this->error['height'] = $this->lang->line('error_height');
		}
		return !$this->error;
	}
}