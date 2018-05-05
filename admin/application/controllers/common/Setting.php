<?php 
Class Setting extends MX_Controller {
	public function index(){
		$data['user_token'] = $this->session->userdata('user_token');
		$this->load->view('common/setting', $data);
	}
}