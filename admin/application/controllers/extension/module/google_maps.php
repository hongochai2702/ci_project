<?php
class Google_Maps extends MX_Controller
{
	private $error = array();

	public function index()
	{
		//--Check if Map Module for edit
		if ($this->input->get('module_id')) {
			$this->response->redirect($this->url->link('google_maps/mapmodule', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $this->input->get('module_id'), true));
		}

		//--Loading current active language file
		$this->load->language('module/google_maps');

		//--Load Helper
		$this->load->helper('google_maps_helper');

		//--Load and assign Info
		$data['gmaps_info']		= gmaps_make_doc();
		$data['gmaps_about']	= gmaps_make_doc('<div style="font-family: \'Courier New\', Courier, monospace">', '</div>', '  - ', '<br />', str_repeat('&nbsp;', 4));

		//--Load and assign Donate button
		$data['gmaps_donate'] = gmaps_donate_button();


		//--Assign translation to $data array
		$data = array_merge($data, array(
			'heading_title'			=> $this->lang->line('heading_title'),

			'text_about_title'		=> $this->lang->line('text_about_title'),
			'text_list'				=> $this->lang->line('text_list'),
			'text_add_marker'		=> $this->lang->line('text_add_marker'),
			'text_add_module'		=> $this->lang->line('text_add_module'),
			'text_confirm'			=> $this->lang->line('text_confirm'),

			'column_name'			=> $this->lang->line('column_name'),
			'column_count'			=> $this->lang->line('column_count'),
			'column_action'			=> $this->lang->line('column_action'),
			'column_module'			=> $this->lang->line('column_module'),

			'button_cancel'			=> $this->lang->line('button_cancel'),
			'button_add'			=> $this->lang->line('button_add'),
			'button_edit'			=> $this->lang->line('button_edit'),
			'button_close'			=> $this->lang->line('button_close'),
			'button_delete'			=> $this->lang->line('button_delete'),

			'permission_location'	=> $this->lang->line('permission_location'),
			'permission_mapmodule'	=> $this->lang->line('permission_mapmodule')
		), gmaps_info());

		//--Document Scripts and Styles
		$this->document->setTitle($data['heading_title']);


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


		//--Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->lang->line('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->lang->line('text_module'),
			'href'      => $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $data['heading_title'],
			'href'      => $this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), true)
		);
		//--

		$data['wlocation'] = true;
		$data['wmapmodule'] = true;
		if (!$this->user->hasPermission('modify', 'google_maps/location') or !$this->user->hasPermission('access', 'google_maps/location')) $data['wlocation'] = false;
		if (!$this->user->hasPermission('modify', 'google_maps/mapmodule') or !$this->user->hasPermission('access', 'google_maps/mapmodule')) $data['wmapmodule'] = false;


		$data['action_add_marker'] = $this->url->link('google_maps/location', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['action_add_module'] = $this->url->link('google_maps/mapmodule', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['cancel'] = $this->url->link('extension/module', 'user_token=' . $this->session->userdata('user_token'), true);


		//--Map Modules
		$module_data = array();
		$this->load->model('extension/module_model','model_extension_module');
		$modules = $this->model_extension_module->getModulesByCode('google_maps');

		foreach ($modules as $module) {
			$module_data[] = array(
				'module_id' => $module['module_id'],
				'name'      => $module['name'],
				'edit'      => $this->url->link('google_maps/mapmodule', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $module['module_id'], true),
				'delete'    => $this->url->link('extension/module/delete', 'user_token=' . $this->session->userdata('user_token') . '&module_id=' . $module['module_id'], true)
			);
		}
		$data['module_data'] = $module_data;
		//--


		//--Location Markers
		$data['gmaps'] = array();
		if ($this->configs->has('google_maps_module_map'))
		{
			$data['gmaps'] = $this->configs->get('google_maps_module_map');
		}
		//--


		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');


		$this->load->model('localisation/language_model','model_localisation_language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['token'] = $this->session->userdata('user_token');

		$this->load->view('module/google_maps', $data);
	}
}