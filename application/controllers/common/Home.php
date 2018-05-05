<?php
class Home extends MX_Controller {
	public function __Construct(){
		parent::__Construct();
	}
	public function index() {
		$this->document->setTitle($this->configs->get('config_meta_title'));
		$this->document->setDescription($this->configs->get('config_meta_description'));
		$this->document->setKeywords($this->configs->get('config_meta_keyword'));

		if ($this->input->get('routing')) {
			$this->document->addLink($this->configs->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');

		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

	

		$this->load->view('default/common/home', $data);
	}
}
