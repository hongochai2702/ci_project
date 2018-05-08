<?php
class Header extends MX_Controller {
	public function __Construct(){
		parent::__Construct();

	}
	public function index() {
		// // Analytics
		$this->load->language('common/header');
		$this->load->model('setting/extension_model');

		$data['analytics'] = array();

		$analytics = $this->extension_model->getExtensions('analytics');

		$routes = $this->uri->segment_array();

		$data['class'] = end($routes);

		if($analytics) {
			foreach ($analytics as $analytic) {
				if ($this->configs->get('analytics_' . $analytic['code'] . '_status')) {
					$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->configs->get('analytics_' . $analytic['code'] . '_status'));
				}
			}

		 }
		if ($this->input->server('HTTPS')) {
			$server = HTTPS_SERVER;
		} else {
			$server = HTTP_SERVER;
		}

		if (is_file(DIR_IMAGE . $this->configs->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->configs->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->configs->get('config_language');
		$data['direction'] = $this->configs->get('direction');
		$data['name'] = $this->configs->get('config_name');
		if (is_file(DIR_IMAGE . $this->configs->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->configs->get('config_logo');
		} else {
			$data['logo'] = '';
		}


		$data['text_account']  = $this->lang->line('text_account');
		$data['text_download']  = $this->lang->line('text_download');
		$data['text_logout']  = $this->lang->line('text_logout');
		$data['text_register']  = $this->lang->line('text_register');
		$data['text_login']  = $this->lang->line('text_login');
		$data['text_wishlist']  = $this->lang->line('text_wishlist');
		

		$data['text_logged'] = sprintf($this->lang->line('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->configs->get('config_telephone');
		$data['email'] = $this->configs->get('config_email');
		$data['comment'] = $this->configs->get('config_comment');

		$data['menu_header'] = $this->load->controller('common/menu_header');
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');




		return $this->load->view('default/common/header', $data,true);
	}
}
