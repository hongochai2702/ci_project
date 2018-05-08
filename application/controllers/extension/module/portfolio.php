<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Portfolio extends MX_Controller {

		public function index() {
			$data['data']  = '';
			$this->load->view('default/extension/module/portfolio_view', $data, FALSE);
		}
	}