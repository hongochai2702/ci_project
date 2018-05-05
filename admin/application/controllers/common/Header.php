<?php
class Header extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('language');
	}
	public function index() {
		
		$data['title'] = $this->document->getTitle();

		if ($this->input->server('HTTPS')) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		// Nhúng thư viện FileManager vào.
		$routes = $this->uri->segment_array();
		$ignore_routes = array('edit','add');
		foreach ($ignore_routes as $ignore) {
			if (in_array($ignore, $routes)) {
				$this->document->addScript('public/javascript/plugins/elFinder/jquery/jquery-migrate-1.2.1.min.js');
				$this->document->addScript('public/javascript/plugins/elFinder/jquery-ui/jquery-ui.js');   
				$this->document->addStyle('public/javascript/plugins/elFinder/jquery-ui/jquery-ui.css');
				$this->document->addStyle('public/javascript/plugins/elFinder/css/elfinder.min.css');   
				$this->document->addScript('public/javascript/plugins/elFinder/js/elFinder.js');	
				$this->document->addScript('public/javascript/plugins/elFinder/js/ui/elfinder-ui.js');	
				$this->document->addScript('public/javascript/plugins/elFinder/js/commands/commands.js');
				$this->document->addScript('public/javascript/plugins/elFinder/js/i18n/elfinder.'.$this->lang->line('code').'.js');	
				$this->document->addScript('public/javascript/plugins/elFinder/js/proxy/elFinderSupportVer1.js');
			}
		}

		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->lang->line('code');
		$data['direction'] = $this->lang->line('direction');

		
		$get_route = 'common/dashboard';
		if (isset($this->request->get['route'])) {
				$get_route = $this->request->get['route'];
		}

		
		$data['user_token'] = $this->session->userdata('user_token');
		$this->lang->load('common/header');
		$data['heading_title'] = $this->lang->line('heading_title');
		$data['text_profile'] = $this->lang->line('text_profile');
		$data['text_store'] = $this->lang->line('text_store');
		$data['text_homepage'] = $this->lang->line('text_homepage');
		$data['text_documentation'] = $this->lang->line('text_documentation');
		$data['text_support'] = $this->lang->line('text_support');
		$data['text_logout'] = $this->lang->line('text_logout');
		
		
		$data['text_logged'] = sprintf($this->lang->line('text_logged'), $this->user->getUserName());

		if (!($this->input->get('user_token')) || !($this->session->userdata('user_token')) || ($this->input->get('user_token') != $this->session->userdata('user_token'))) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/dashboard', '', true);
		} else {
			$data['logged'] = true;

			$data['home'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true);
			$data['logout'] = $this->url->link('common/logout', 'user_token=' . $this->session->userdata('user_token'), true);
			$data['profile'] = $this->url->link('common/profile', 'user_token=' . $this->session->userdata('user_token'), true);
		
			$this->load->model('user/user_model');
	
			$this->load->model('tool/image_model');
	
			$user_info = $this->user_model->getUser($this->user->getId());
	
			if ($user_info) {
				$data['firstname'] = $user_info['firstname'];
				$data['lastname'] = $user_info['lastname'];
				$data['username']  = $user_info['username'];
				$data['user_group'] = $user_info['user_group'];
	
				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$data['image'] = $this->image_model->resize($user_info['image'], 45, 45);
				} else {
					$data['image'] = $this->image_model->resize('profile.png', 45, 45);
				}
			} else {
				$data['firstname'] = '';
				$data['lastname'] = '';
				$data['user_group'] = '';
				$data['image'] = '';
			}			
			
			// Online Stores
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->configs->get('config_name'),
				'href' => HTTP_CATALOG
			);

			$this->load->model('setting/store_model');

			$results = $this->store_model->getStores();

			foreach ($results as $result) {
				$data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
		}

		return $this->load->view('common/header', $data, true);
	}
}