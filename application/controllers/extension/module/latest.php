<?php
class Latest extends MX_Controller {
	public function index($setting = array()) {
		$this->load->language('extension/module/latest');

		$data['heading_title'] = $this->lang->line('heading_title');

		$data['text_tax'] = $this->lang->line('text_tax');

		$data['button_cart'] = $this->lang->line('button_cart');
		$data['button_wishlist'] = $this->lang->line('button_wishlist');
		$data['button_compare'] = $this->lang->line('button_compare');

		$this->load->model('catalog/product_model');

		$this->load->model('tool/image_model');

		$data['products'] = array();

		$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->product_model->getProducts($filter_data);



		if ($results) {
			foreach ($results as $result) {



				if ($result['image']) {
					$image = $this->image_model->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->image_model->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->customer->isLogged() || !$this->configs->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->configs->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->configs->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->configs->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->configs->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->configs->get('theme_' . $this->configs->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);

			
			}

			return $this->load->view('default/extension/module/latest', $data,true);
		}
	}
}
