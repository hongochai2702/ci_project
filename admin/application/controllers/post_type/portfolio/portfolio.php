<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends MX_Controller {

	public function index() {
		$this->lang->load('post_type/portfolio');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('post_type/portfolio');

		$this->getList();
		
	}

	public function add() {
		echo __METHOD__ . ' ADMIN';
	}

	public function getList(){

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('post_type/portfolio/portfolio_list_view', $data);
	}
}
