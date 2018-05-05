<?php
class Location extends MX_Controller
{
	private $error = array();

	public function index()
	{
		//--Loading current active language file
		$this->lang->load('google_maps/location');
		$this->lang->load('google_maps/mapmodule');

		//--Load Helper
		$this->load->helper('google_maps_helper');

		//--Load and assign Info
		$data['gmaps_info']		= gmaps_make_doc();
		$data['gmaps_about']	= gmaps_make_doc('<div style="font-family: \'Courier New\', Courier, monospace">', '</div>', '  - ', '<br />', str_repeat('&nbsp;', 4));

		//--Load and assign Donate button
		$data['gmaps_donate'] = gmaps_donate_button();



		$this->load->model('setting/setting_model','model_setting_setting');
		//--Check form post
		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate())
		{
			$this->model_setting_setting->editSetting('google_maps', $this->input->post());

			$this->session->data['success'] = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), 'SSL'));
		}


		//--Assign translation to $data array
		$data = array_merge($data, array(
			'heading_title'					=> $this->lang->line('heading_title'),

			'text_about_title'				=> $this->lang->line('text_about_title'),
			'text_title'					=> $this->lang->line('text_title'),

			'entry_id'						=> $this->lang->line('entry_id'),
			'entry_alias'					=> $this->lang->line('entry_alias'),
			'entry_address'					=> $this->lang->line('entry_address'),
			'entry_latitude'				=> $this->lang->line('entry_latitude'),
			'entry_longitude'				=> $this->lang->line('entry_longitude'),
			'entry_balloon_width'			=> $this->lang->line('entry_balloon_width'),
			'entry_ballon_text'				=> $this->lang->line('entry_ballon_text'),
			'entry_textarea_1'				=> $this->lang->line('entry_textarea_1'),
			'entry_textarea_2'				=> $this->lang->line('entry_textarea_2'),

			'placeholder_id'				=> $this->lang->line('placeholder_id'),
			'placeholder_alias'				=> $this->lang->line('placeholder_alias'),
			'placeholder_address'			=> $this->lang->line('placeholder_address'),
			'placeholder_latitude'			=> $this->lang->line('placeholder_latitude'),
			'placeholder_longitude'			=> $this->lang->line('placeholder_longitude'),
			'placeholder_balloon_width'		=> $this->lang->line('placeholder_balloon_width'),

			'confirm_mapid'					=> $this->lang->line('confirm_mapid'),

			'button_save'					=> $this->lang->line('button_save'),
			'button_cancel'					=> $this->lang->line('button_cancel'),
			'button_new_map'				=> $this->lang->line('button_new_map'),
			'button_close'					=> $this->lang->line('button_close'),
			
			'te_fomat'					=> $this->lang->line('te_fomat'),
			'te_font_size'					=> $this->lang->line('te_font_size'),
			'te_color'					=> $this->lang->line('te_color'),
			'te_blod'					=> $this->lang->line('te_blod'),
			'te_italic'					=> $this->lang->line('te_italic'),
			'te_underlic'					=> $this->lang->line('te_underlic'),
			'te_list'					=> $this->lang->line('te_list'),
			'te_no_list'					=> $this->lang->line('te_no_list'),
			'te_down_arrow'					=> $this->lang->line('te_down_arrow'),
			'te_up_arrow'					=> $this->lang->line('te_up_arrow'),
			'te_left_arrow'					=> $this->lang->line('te_left_arrow'),
			'te_right_arrow'				=> $this->lang->line('te_right_arrow'),
			'te_justly_arrow_left'				=> $this->lang->line('te_justly_arrow_left'),
			'te_justly_arrow_right'				=> $this->lang->line('te_justly_arrow_right'),
			'te_justly_arrow'				=> $this->lang->line('te_justly_arrow'),
			'te_underlic_remove'				=> $this->lang->line('te_underlic_remove'),
			'te_link'					=> $this->lang->line('te_link'),
			'te_unlink'					=> $this->lang->line('te_unlink'),
			'te_remove_style'				=> $this->lang->line('te_remove_style'),
			'te_hr_style'					=> $this->lang->line('te_hr_style'),
			'te_code'					=> $this->lang->line('te_code'),
			'entry_frame'					=> $this->lang->line('entry_frame'),
			'entry_frame_line'					=> $this->lang->line('entry_frame_line'),
		), gmaps_info());


		//--Document Scripts and Styles
		$this->document->setTitle($data['heading_title']);
		$this->document->addStyle( 'public/javascript/jquery/jquery-te/jquery-te-1.4.0.css');
		$this->document->addScript( 'public/javascript/jquery/jquery-te/jquery-te-1.4.0.min.js');
		$this->document->addScript( 'public/javascript/jquery/cnplugins/jquery.predefinedinput-1.0.1.js');
                
        $key_google=$this->configs->get('AIzaSyDkhBa2ksVOCgng0CJh_QD-q1OLER5DE5Y');
		
		if(empty($key_google)) $key_google='AIzaSyDkhBa2ksVOCgng0CJh_QD-q1OLER5DE5Y';

		if ($this->input->server('HTTPS')) {
            $this->document->addScript('https://maps.google.com/maps/api/js?key='.$key_google.'&libraries=places'); 
        } else {
            $this->document->addScript('http://maps.google.com/maps/api/js?key='.$key_google.'&libraries=places');
        }
		$this->document->addScript( 'public/javascript/jquery/locationpicker/locationpicker.jquery.js');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['id'])) {
			$data['error_id'] = $this->error['id'];
		} else {
			$data['error_id'] = '';
		}

		if (isset($this->error['latitude'])) {
			$data['error_latitude'] = $this->error['latitude'];
		} else {
			$data['error_latitude'] = '';
		}

		if (isset($this->error['longitude'])) {
			$data['error_longitude'] = $this->error['longitude'];
		} else {
			$data['error_longitude'] = '';
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
			'text'      => $this->lang->line('text_title'),
			'href'      => $this->url->link('google_maps/location', 'user_token=' . $this->session->userdata('user_token'), 'SSL')
		);
		//--


		$data['action'] = $this->url->link('google_maps/location', 'user_token=' . $this->session->userdata('user_token'), 'SSL');
		$data['cancel'] = $this->url->link('module/google_maps', 'user_token=' . $this->session->userdata('user_token'), 'SSL');



		//--Maps
		$data['gmaps'] = array();
		if ($this->input->post('google_maps_module_map'))
		{
			$data['gmaps'] = $this->input->post('google_maps_module_map');
		}
		elseif ($this->configs->has('google_maps_module_map'))
		{
			$data['gmaps'] = $this->config->get('google_maps_module_map');
		}
		//--


		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');


		$this->load->model('localisation/language_model','model_localisation_language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $this->session->userdata('user_token');

		$this->load->view('google_maps/location', $data);
	}

	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'google_maps/location'))
		{
			$this->error['warning'] = $this->lang->line('error_permission');
		}


		if ($this->input->post('google_maps_module_map')) {
			foreach ($this->input->post('google_maps_module_map') as $key => $value) {
				if (!$value['id']) {
					$this->error['id'] = $this->lang->line('error_mapid');
				}

				if (!$value['latitude']) {
					$this->error['latitude'] = $this->lang->line('error_latlong');
				}

				if (!$value['longitude']) {
					$this->error['longitude'] = $this->lang->line('error_latlong');
				}

			}
		}

		return !$this->error;
	}

}