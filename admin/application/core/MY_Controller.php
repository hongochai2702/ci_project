<?php 
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// class My_Controller extends CI_Controller {
// 	var $data = array();
// 	public function __construct(){
// 		parent::__construct();
// 	}
// }


defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	protected $data = array();
	public function __construct(){
		parent::__construct();
		$data['page_title'] = "CI cms";
		$data['before_head'] = '';
		$data['before_body'] = '';
		$this->load->library('ion_auth');
		// if(!$this->session->userdata('token')){
		// 	redirect('common/login', 'refresh');
		// }
	}

	protected function render($the_view = NULL, $template = "maskter") {
	if ($template = NULL || $this->input->is_ajax_request()){
		header('Content-Type: aplication/json');
		echo json_decode($data);
	} else {
		$data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $data, true);
		$this->load->view('templates/$template');
	}
}
}


class Admin_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('ion_auth');
		// if(!$this->session->userdata('logged_in')){
		// 	redirect('common/login', 'refresh');
		// }

	}
	protected function render($the_view, $template = "admin_maskter") {
		parent::render($the_view, $template);
	}
}

class Public_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
}
