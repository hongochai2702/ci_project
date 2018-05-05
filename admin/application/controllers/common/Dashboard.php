<?php
class Dashboard extends MX_Controller {
	public function __construct(){
		parent::__construct();
		
	}
	public function index() {
		$this->lang->load('common/dashboard');

		$this->document->setTitle($this->lang->line('heading_title'));


		$data['user_token'] = $this->session->userdata('user_token');
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['header'] = $this->load->controller('common/Header');
		$data['column_left'] = $this->load->controller('common/Column_left');

		$this->load->view('common/dashboard', $data);
	}
}