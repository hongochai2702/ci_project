<?php
 class Contact_model extends CI_Model {
 	public function __Construct(){
 		parent::__Construct();
 		$this->load->library('email');
 	}
 	public function index(){

 	}
 	public function sendContact(){

 		$this->email->initialize(array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'smtp.sendgrid.net',
		  'smtp_user' => 'sendgridusername',
		  'smtp_pass' => 'sendgridpassword',
		  'smtp_port' => 587,
		  'crlf' => "\r\n",
		  'newline' => "\r\n"
		));

 	}
 }