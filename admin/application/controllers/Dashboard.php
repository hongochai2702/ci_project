<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		

	}
	public function index ($page= 'dashboard'){
		$file_path = APPPATH.'controllers/header.php';
		$data['heading_title'] = 'Hello dashboard';
		 if ( ! file_exists(APPPATH.'views/common/'.$page.'.php'))
        {
                show_404();
        }
		else {
			
			$this->load->view('common/dashboard', $data);
			
		}

	}
}