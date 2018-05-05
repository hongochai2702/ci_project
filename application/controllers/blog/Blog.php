<?php
class Blog extends MX_Controller {
	private $error = array();

	public function index() {
		$this->load->language('blog/blog');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('categoryblog_model');

		if (($this->input->get('path'))) {
			$path = '';

			$parts = explode('_', (string)$this->input->get('path'));

			$categoryblog_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$categoryblog_info = $this->categoryblog_model->getCategoryblog($path_id);

				if ($categoryblog_info) {
					$data['breadcrumbs'][] = array(
						'text' => $categoryblog_info['name'],
						'href' => $this->url->link('blog/categoryblog', 'path=' . $path)
					);
				}
			}

			// Set the last categoryblog breadcrumb
			$categoryblog_info = $this->categoryblog_model->getCategoryblog($categoryblog_id);

			if ($categoryblog_info) {
				$url = '';

				if (($this->input->get('sort'))) {
					$url .= '&sort=' . $this->input->get('sort');
				}

				if (($this->input->get('order'))) {
					$url .= '&order=' . $this->input->get('order');
				}

				if (($this->input->get('page'))) {
					$url .= '&page=' . $this->input->get('page');
				}

				if (($this->input->get('limit'))) {
					$url .= '&limit=' . $this->input->get('limit');
				}

				$data['breadcrumbs'][] = array(
					'text' => $categoryblog_info['name'],
					'href' => $this->url->link('blog/categoryblog', 'path=' . $this->input->get('path') . $url)
				);
			}
		}

		$this->load->model('manufacturer_model');

		if (($this->input->get('manufacturer_id'))) {
			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('text_brand'),
				'href' => $this->url->link('blog/manufacturer')
			);

			$url = '';

			if (($this->input->get('sort'))) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if (($this->input->get('order'))) {
				$url .= '&order=' . $this->input->get('order');
			}

			if (($this->input->get('page'))) {
				$url .= '&page=' . $this->input->get('page');
			}

			if (($this->input->get('limit'))) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$manufacturer_info = $this->manufacturer_model->getManufacturer($this->input->get('manufacturer_id'));


			if ($manufacturer_info) {
				$data['breadcrumbs'][] = array(
					'text' => $manufacturer_info['name'],
					'href' => $this->url->link('blog/manufacturer/info', 'manufacturer_id=' . $this->input->get('manufacturer_id') . $url)
				);
			}
		}

		if (($this->input->get('search')) || ($this->input->get('tag'))) {
			$url = '';

			if (($this->input->get('search'))) {
				$url .= '&search=' . $this->input->get('search');
			}

			if (($this->input->get('tag'))) {
				$url .= '&tag=' . $this->input->get('tag');
			}

			if (($this->input->get('description'))) {
				$url .= '&description=' . $this->input->get('description');
			}

			if (($this->input->get('categoryblog_id'))) {
				$url .= '&categoryblog_id=' . $this->input->get('categoryblog_id');
			}

			if (($this->input->get('sub_categoryblog'))) {
				$url .= '&sub_categoryblog=' . $this->input->get('sub_categoryblog');
			}

			if (($this->input->get('sort'))) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if (($this->input->get('order'))) {
				$url .= '&order=' . $this->input->get('order');
			}

			if (($this->input->get('page'))) {
				$url .= '&page=' . $this->input->get('page');
			}

			if (($this->input->get('limit'))) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('text_search'),
				'href' => $this->url->link('blog/search', $url)
			);
		}

		if (($this->input->get('blog_id'))) {
			$blog_id = (int)$this->input->get('blog_id');
		} else {
			$blog_id = 0;
		}

		$this->load->model('blog_model');

		$blog_info = $this->blog_model->getBlog($blog_id);

		if ($blog_info) {
			$url = '';

			if (($this->input->get('path'))) {
				$url .= '&path=' . $this->input->get('path');
			}

			if (($this->input->get('filter'))) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if (($this->input->get('manufacturer_id'))) {
				$url .= '&manufacturer_id=' . $this->input->get('manufacturer_id');
			}

			if (($this->input->get('search'))) {
				$url .= '&search=' . $this->input->get('search');
			}

			if (($this->input->get('tag'))) {
				$url .= '&tag=' . $this->input->get('tag');
			}

			if (($this->input->get('description'))) {
				$url .= '&description=' . $this->input->get('description');
			}

			if (($this->input->get('categoryblog_id'))) {
				$url .= '&categoryblog_id=' . $this->input->get('categoryblog_id');
			}

			if (($this->input->get('sub_categoryblog'))) {
				$url .= '&sub_categoryblog=' . $this->input->get('sub_categoryblog');
			}

			if (($this->input->get('sort'))) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if (($this->input->get('order'))) {
				$url .= '&order=' . $this->input->get('order');
			}

			if (($this->input->get('page'))) {
				$url .= '&page=' . $this->input->get('page');
			}

			if (($this->input->get('limit'))) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$data['breadcrumbs'][] = array(
				'text' => $blog_info['name'],
				'href' => $this->url->link('blog/blog', $url . '&blog_id=' . $this->input->get('blog_id'))
			);

			$this->document->setTitle($blog_info['meta_title']);
			$this->document->setDescription($blog_info['meta_description']);
			$this->document->setKeywords($blog_info['meta_keyword']);
			$this->document->addLink($this->url->link('blog/blog', 'blog_id=' . $this->input->get('blog_id')), 'canonical');
			
			

			$data['heading_title'] = $blog_info['name'];

			$data['text_minimum'] = sprintf($this->lang->line('text_minimum'), $blog_info['minimum']);
			$data['text_login'] = sprintf($this->lang->line('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));

			$this->load->model('reviewblog');

			$data['tab_reviewblog'] = sprintf($this->lang->line('tab_reviewblog'), $blog_info['reviewblogs']);

			$data['blog_id'] = (int)$this->input->get('blog_id');
			$data['manufacturer'] = $blog_info['manufacturer'];
			$data['manufacturers'] = $this->url->link('blog/manufacturer/info', 'manufacturer_id=' . $blog_info['manufacturer_id']);

			$data['model'] = $blog_info['model'];
			$data['reward'] = $blog_info['reward'];
			$data['points'] = $blog_info['points'];
			$data['description'] = html_entity_decode($blog_info['description'], ENT_QUOTES, 'UTF-8');
			$data['date_available'] = $blog_info['date_available'];

			$data['manufacturer_info'] = $this->manufacturer_model->getManufacturer($blog_info['manufacturer_id']);





			if ($blog_info['quantity'] <= 0) {
				$data['stock'] = $blog_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$data['stock'] = $blog_info['quantity'];
			} else {
				$data['stock'] = $this->lang->line('text_instock');
			}

			$this->load->model('tool/image');

			if ($blog_info['image']) {
				$data['popup'] = $this->model_tool_image->resize($blog_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height'));
			} else {
				$data['popup'] = '';
			}

			if ($blog_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($blog_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['images'] = array();

			$results = $this->blog_model->getBlogImages($this->input->get('blog_id'));

			foreach ($results as $result) {
				$data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_additional_height'))
				);
			}

			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$data['price'] = $this->currency->format($this->tax->calculate($blog_info['price'], $blog_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['price'] = false;
			}

			if ((float)$blog_info['special']) {
				$data['special'] = $this->currency->format($this->tax->calculate($blog_info['special'], $blog_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
				$data['special'] = false;
			}

			if ($this->config->get('config_tax')) {
				$data['tax'] = $this->currency->format((float)$blog_info['special'] ? $blog_info['special'] : $blog_info['price'], $this->session->data['currency']);
			} else {
				$data['tax'] = false;
			}

			$discounts = $this->blog_model->getBlogDiscounts($this->input->get('blog_id'));

			$data['discounts'] = array();

			foreach ($discounts as $discount) {
				$data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $blog_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
				);
			}

			$data['options'] = array();

			foreach ($this->blog_model->getBlogOptions($this->input->get('blog_id')) as $option) {
				$blog_option_value_data = array();

				foreach ($option['blog_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], $blog_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
						} else {
							$price = false;
						}

						$blog_option_value_data[] = array(
							'blog_option_value_id' => $option_value['blog_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'blog_option_id'    => $option['blog_option_id'],
					'blog_option_value' => $blog_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

			if ($blog_info['minimum']) {
				$data['minimum'] = $blog_info['minimum'];
			} else {
				$data['minimum'] = 1;
			}

			$data['reviewblog_status'] = $this->config->get('config_reviewblog_status');

			if ($this->config->get('config_reviewblog_guest') || $this->customer->isLogged()) {
				$data['reviewblog_guest'] = true;
			} else {
				$data['reviewblog_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

			$data['reviewblogs'] = sprintf($this->lang->line('text_reviewblogs'), (int)$blog_info['reviewblogs']);
			$data['rating'] = (int)$blog_info['rating'];

			// Captcha
			if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('reviewblog', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('blog/blog', 'blog_id=' . (int)$this->input->get('blog_id'));

			$data['attribute_groups'] = $this->blog_model->getBlogAttributes($this->input->get('blog_id'));

			$data['blogs'] = array();

			$results = $this->blog_model->getBlogRelated($this->input->get('blog_id'));

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_related_height'));
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_reviewblog_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}

				$data['blogs'][] = array(
					'blog_id'  => $result['blog_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_blog_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $rating,
					'href'        => $this->url->link('blog/blog', 'blog_id=' . $result['blog_id'])
				);
			}

			$data['tags'] = array();

			if ($blog_info['tag']) {
				$tags = explode(',', $blog_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/search', 'tag=' . trim($tag))
					);
				}
			}

			$data['recurrings'] = $this->blog_model->getProfiles($this->input->get('blog_id'));

			$this->blog_model->updateViewed($this->input->get('blog_id'));
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->load->view('default/blog/allblog', $data);
		} else {
			$url = '';

			if (($this->input->get('path'))) {
				$url .= '&path=' . $this->input->get('path');
			}

			if (($this->input->get('filter'))) {
				$url .= '&filter=' . $this->input->get('filter');
			}

			if (($this->input->get('manufacturer_id'))) {
				$url .= '&manufacturer_id=' . $this->input->get('manufacturer_id');
			}

			if (($this->input->get('search'))) {
				$url .= '&search=' . $this->input->get('search');
			}

			if (($this->input->get('tag'))) {
				$url .= '&tag=' . $this->input->get('tag');
			}

			if (($this->input->get('description'))) {
				$url .= '&description=' . $this->input->get('description');
			}

			if (($this->input->get('categoryblog_id'))) {
				$url .= '&categoryblog_id=' . $this->input->get('categoryblog_id');
			}

			if (($this->input->get('sub_categoryblog'))) {
				$url .= '&sub_categoryblog=' . $this->input->get('sub_categoryblog');
			}

			if (($this->input->get('sort'))) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if (($this->input->get('order'))) {
				$url .= '&order=' . $this->input->get('order');
			}

			if (($this->input->get('page'))) {
				$url .= '&page=' . $this->input->get('page');
			}

			if (($this->input->get('limit'))) {
				$url .= '&limit=' . $this->input->get('limit');
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->lang->line('text_error'),
				'href' => $this->url->link('blog/blog', $url . '&blog_id=' . $blog_id)
			);

			$this->document->setTitle($this->lang->line('text_error'));

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->input->server('SERVER_PROTOCOL') . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->load->view('default/error/not_found', $data);
		}
	}

	public function reviewblog() {
		$this->load->language('blog/blog');

		$this->load->model('reviewblog');

		if (($this->input->get('page'))) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		$data['reviewblogs'] = array();

		$reviewblog_total = $this->model_catalog_reviewblog->getTotalReviewblogsByBlogId($this->input->get('blog_id'));

		$results = $this->model_catalog_reviewblog->getReviewblogsByBlogId($this->input->get('blog_id'), ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['reviewblogs'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'rating'     => (int)$result['rating'],
				'date_added' => date($this->lang->line('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $reviewblog_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('blog/blog/reviewblog', 'blog_id=' . $this->input->get('blog_id') . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->lang->line('text_pagination'), ($reviewblog_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($reviewblog_total - 5)) ? $reviewblog_total : ((($page - 1) * 5) + 5), $reviewblog_total, ceil($reviewblog_total / 5));

		$this->load->view('default/blog/reviewblog', $data);
	}

	public function write() {
		$this->load->language('blog/blog');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->lang->line('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->lang->line('error_text');
			}

			if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
				$json['error'] = $this->lang->line('error_rating');
			}

			// Captcha
			if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('reviewblog', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('reviewblog');

				$this->model_catalog_reviewblog->addReviewblog($this->input->get('blog_id'), $this->request->post);

				$json['success'] = $this->lang->line('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getRecurringDescription() {
		$this->load->language('blog/blog');
		$this->load->model('blog');

		if (($this->request->post['blog_id'])) {
			$blog_id = $this->request->post['blog_id'];
		} else {
			$blog_id = 0;
		}

		if (($this->request->post['recurring_id'])) {
			$recurring_id = $this->request->post['recurring_id'];
		} else {
			$recurring_id = 0;
		}

		if (($this->request->post['quantity'])) {
			$quantity = $this->request->post['quantity'];
		} else {
			$quantity = 1;
		}

		$blog_info = $this->blog_model->getBlog($blog_id);
		
		$recurring_info = $this->blog_model->getProfile($blog_id, $recurring_id);

		$json = array();

		if ($blog_info && $recurring_info) {
			if (!$json) {
				$frequencies = array(
					'day'        => $this->lang->line('text_day'),
					'week'       => $this->lang->line('text_week'),
					'semi_month' => $this->lang->line('text_semi_month'),
					'month'      => $this->lang->line('text_month'),
					'year'       => $this->lang->line('text_year'),
				);

				if ($recurring_info['trial_status'] == 1) {
					$price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $blog_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$trial_text = sprintf($this->lang->line('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
				} else {
					$trial_text = '';
				}

				$price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $blog_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

				if ($recurring_info['duration']) {
					$text = $trial_text . sprintf($this->lang->line('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				} else {
					$text = $trial_text . sprintf($this->lang->line('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
				}

				$json['success'] = $text;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
