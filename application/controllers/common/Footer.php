<?php
class Footer extends MX_Controller {
	
	public function index() {
		$this->lang->load('common/footer');

		// $this->load->model('information_model');

		// $data['informations'] = array();

		// foreach ($this->information_model->getInformations() as $result) {
		// 	if ($result['bottom']) {
		// 		$data['informations'][] = array(
		// 			'title' => $result['title'],
		// 			'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
		// 		);
		// 	}
		// }
		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['tracking'] = $this->url->link('information/tracking');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/login', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);
		$data['newsletters'] = $this->load->controller('extension/module/newsletters');
		$data['telephone'] = $this->configs->get('config_telephone');
		$data['email'] = $this->configs->get('config_email');
		$data['config_address'] = $this->configs->get('config_address');

		$data['text_contact'] = $this->lang->line('text_contact');
		$data['text_return'] = $this->lang->line('text_return');
		$data['text_sitemap'] = $this->lang->line('text_sitemap');
		$data['text_extra'] = $this->lang->line('text_extra');
		$data['text_account'] = $this->lang->line('text_account');
		$data['text_order'] = $this->lang->line('text_order');
		$data['text_newsletter'] = $this->lang->line('text_newsletter');
		$data['text_information'] = $this->lang->line('text_information');
		$data['text_service'] = $this->lang->line('text_service');
		$data['text_manufacturer'] = $this->lang->line('text_manufacturer');
		$data['text_voucher'] = $this->lang->line('text_voucher');
		$data['text_affiliate'] = $this->lang->line('text_affiliate');
		$data['text_special'] = $this->lang->line('text_special');

		$data['powered'] = sprintf($this->lang->line('text_powered'), $this->configs->get('config_name'), date('Y', time()));

		// Whos Online
		/*if ($this->configs->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (($this->input->server('REMOTE_ADDR'))) {
				$ip = $this->input->server('REMOTE_ADDR');
			} else {
				$ip = '';
			}

			if (($this->input->server('HTTP_HOST')) && ($this->input->server('REQUEST_URI'))) {
				$url = ($this->input->server('HTTPS') ? 'https://' : 'http://') . $this->input->server('HTTP_HOST') . $this->input->server('REQUEST_URI');
			} else {
				$url = '';
			}

			if (($this->input->server('HTTP_REFERER'))) {
				$referer = $this->input->server('HTTP_REFERER');
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}*/

		$data['scripts'] = $this->document->getScripts('footer');
		
		return $this->load->view('default/common/footer', $data, true);
	}
}
