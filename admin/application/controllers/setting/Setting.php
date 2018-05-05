<?php
class Setting extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('setting/setting');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('setting/setting_model','setting_model');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			$this->setting_model->editSetting('config', $this->input->post());

			if ($this->configs->get('config_currency_auto')) {
				$this->load->model('localisation/currency_model','model_localisation_currency');

				$this->model_localisation_currency->refresh();
			}

			$this->session->data['success'] = $this->lang->line('text_success');

			$this->response->redirect($this->url->link('setting/store', 'user_token=' . $this->session->userdata('user_token'), true));
		}
		$data = array();
		$data = array_merge($data, $this->lang->loadAll());
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['owner'])) {
			$data['error_owner'] = $this->error['owner'];
		} else {
			$data['error_owner'] = '';
		}

		if (isset($this->error['address'])) {
			$data['error_address'] = $this->error['address'];
		} else {
			$data['error_address'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['customer_group_display'])) {
			$data['error_customer_group_display'] = $this->error['customer_group_display'];
		} else {
			$data['error_customer_group_display'] = '';
		}

		if (isset($this->error['login_attempts'])) {
			$data['error_login_attempts'] = $this->error['login_attempts'];
		} else {
			$data['error_login_attempts'] = '';
		}

		if (isset($this->error['voucher_min'])) {
			$data['error_voucher_min'] = $this->error['voucher_min'];
		} else {
			$data['error_voucher_min'] = '';
		}

		if (isset($this->error['voucher_max'])) {
			$data['error_voucher_max'] = $this->error['voucher_max'];
		} else {
			$data['error_voucher_max'] = '';
		}

		if (isset($this->error['processing_status'])) {
			$data['error_processing_status'] = $this->error['processing_status'];
		} else {
			$data['error_processing_status'] = '';
		}

		if (isset($this->error['complete_status'])) {
			$data['error_complete_status'] = $this->error['complete_status'];
		} else {
			$data['error_complete_status'] = '';
		}

		if (isset($this->error['log'])) {
			$data['error_log'] = $this->error['log'];
		} else {
			$data['error_log'] = '';
		}

		if (isset($this->error['limit_admin'])) {
			$data['error_limit_admin'] = $this->error['limit_admin'];
		} else {
			$data['error_limit_admin'] = '';
		}

		if (isset($this->error['encryption'])) {
			$data['error_encryption'] = $this->error['encryption'];
		} else {
			$data['error_encryption'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_stores'),
			'href' => $this->url->link('setting/store', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('setting/setting', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('setting/setting', 'user_token=' . $this->session->userdata('user_token'), true);

		$data['cancel'] = $this->url->link('setting/store', 'user_token=' . $this->session->userdata('user_token'), true);

		$data['user_token'] = $this->session->userdata('user_token');

		if ($this->input->post('config_alert_email')) {
			$data['config_alert_email'] = $this->input->post('config_alert_email');
		} else {
			$data['config_alert_email'] = $this->configs->get('config_alert_email');
		}

		if ($this->input->post('config_meta_title')) {
			$data['config_meta_title'] = $this->input->post('config_meta_title');
		} else {
			$data['config_meta_title'] = $this->configs->get('config_meta_title');
		}

		if ($this->input->post('config_meta_description')) {
			$data['config_meta_description'] = $this->input->post('config_meta_description');
		} else {
			$data['config_meta_description'] = $this->configs->get('config_meta_description');
		}

		if ($this->input->post('config_meta_keyword')) {
			$data['config_meta_keyword'] = $this->input->post('config_meta_keyword');
		} else {
			$data['config_meta_keyword'] = $this->configs->get('config_meta_keyword');
		}

		if ($this->input->post('config_theme')) {
			$data['config_theme'] = $this->input->post('config_theme');
		} else {
			$data['config_theme'] = $this->configs->get('config_theme');
		}

		if ($this->input->server('HTTPS')) {
			$data['store_url'] = HTTPS_CATALOG;
		} else {
			$data['store_url'] = HTTP_CATALOG;
		}

		$data['themes'] = array();

		$this->load->model('setting/extension_model','model_setting_extension');

		$extensions = $this->model_setting_extension->getInstalled('theme');

		foreach ($extensions as $code) {
			$this->lang->load('extension/theme/' . $code, 'extension');
			
			$data['themes'][] = array(
				'text'  => $this->lang->line('extension')->get('heading_title'),
				'value' => $code
			);
		}
			
		if ($this->input->post('config_layout_id')) {
			$data['config_layout_id'] = $this->input->post('config_layout_id');
		} else {
			$data['config_layout_id'] = $this->configs->get('config_layout_id');
		}

		$this->load->model('design/layout_model','model_design_layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		if ($this->input->post('config_name')) {
			$data['config_name'] = $this->input->post('config_name');
		} else {
			$data['config_name'] = $this->configs->get('config_name');
		}

		if ($this->input->post('config_owner')) {
			$data['config_owner'] = $this->input->post('config_owner');
		} else {
			$data['config_owner'] = $this->configs->get('config_owner');
		}

		if ($this->input->post('config_address')) {
			$data['config_address'] = $this->input->post('config_address');
		} else {
			$data['config_address'] = $this->configs->get('config_address');
		}

		if ($this->input->post('config_geocode')) {
			$data['config_geocode'] = $this->input->post('config_geocode');
		} else {
			$data['config_geocode'] = $this->configs->get('config_geocode');
		}

		if ($this->input->post('config_email')) {
			$data['config_email'] = $this->input->post('config_email');
		} else {
			$data['config_email'] = $this->configs->get('config_email');
		}

		if ($this->input->post('config_telephone')) {
			$data['config_telephone'] = $this->input->post('config_telephone');
		} else {
			$data['config_telephone'] = $this->configs->get('config_telephone');
		}
		
		if ($this->input->post('config_fax')) {
			$data['config_fax'] = $this->input->post('config_fax');
		} else {
			$data['config_fax'] = $this->configs->get('config_fax');
		}
		
		if ($this->input->post('config_image')) {
			$data['config_image'] = $this->input->post('config_image');
		} else {
			$data['config_image'] = $this->configs->get('config_image');
		}

		$this->load->model('tool/image_model','model_tool_image');

		if ($this->input->post('config_image') && is_file(DIR_IMAGE . $this->input->post('config_image'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->input->post('config_image'), 100, 100);
		} elseif ($this->configs->get('config_image') && is_file(DIR_IMAGE . $this->configs->get('config_image'))) {
			$data['thumb'] = $this->model_tool_image->resize($this->configs->get('config_image'), 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if ($this->input->post('config_open')) {
			$data['config_open'] = $this->input->post('config_open');
		} else {
			$data['config_open'] = $this->configs->get('config_open');
		}

		if ($this->input->post('config_comment')) {
			$data['config_comment'] = $this->input->post('config_comment');
		} else {
			$data['config_comment'] = $this->configs->get('config_comment');
		}

		$this->load->model('localisation/location_model','model_localisation_location');

		$data['locations'] = $this->model_localisation_location->getLocations();

		if ($this->input->post('config_location')) {
			$data['config_location'] = $this->input->post('config_location');
		} elseif ($this->configs->get('config_location')) {
			$data['config_location'] = $this->configs->get('config_location');
		} else {
			$data['config_location'] = array();
		}

		if ($this->input->post('config_country_id')) {
			$data['config_country_id'] = $this->input->post('config_country_id');
		} else {
			$data['config_country_id'] = $this->configs->get('config_country_id');
		}

		$this->load->model('localisation/country_model','model_localisation_country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		if ($this->input->post('config_zone_id')) {
			$data['config_zone_id'] = $this->input->post('config_zone_id');
		} else {
			$data['config_zone_id'] = $this->configs->get('config_zone_id');
		}

		if ($this->input->post('config_language')) {
			$data['config_language'] = $this->input->post('config_language');
		} else {
			$data['config_language'] = $this->configs->get('config_language');
		}

		$this->load->model('localisation/language_model','model_localisation_language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if ($this->input->post('config_admin_language')) {
			$data['config_admin_language'] = $this->input->post('config_admin_language');
		} else {
			$data['config_admin_language'] = $this->configs->get('config_admin_language');
		}

		if ($this->input->post('config_mail_protocol')) {
			$data['config_mail_protocol'] = $this->input->post('config_mail_protocol');
		} else {
			$data['config_mail_protocol'] = $this->configs->get('config_mail_protocol');
		}

		if ($this->input->post('config_currency')) {
			$data['config_currency'] = $this->input->post('config_currency');
		} else {
			$data['config_currency'] = $this->configs->get('config_currency');
		}

		if ($this->input->post('config_currency_auto')) {
			$data['config_currency_auto'] = $this->input->post('config_currency_auto');
		} else {
			$data['config_currency_auto'] = $this->configs->get('config_currency_auto');
		}

		$this->load->model('localisation/currency_model','model_localisation_currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		if ($this->input->post('config_length_class_id')) {
			$data['config_length_class_id'] = $this->input->post('config_length_class_id');
		} else {
			$data['config_length_class_id'] = $this->configs->get('config_length_class_id');
		}

		// $this->load->model('localisation/length_class_model','model_localisation_length_class');

		// $data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		// if ($this->input->post('config_weight_class_id')) {
		// 	$data['config_weight_class_id'] = $this->input->post('config_weight_class_id');
		// } else {
		// 	$data['config_weight_class_id'] = $this->configs->get('config_weight_class_id');
		// }

		// $this->load->model('localisation/weight_class_model','model_localisation_weight_class');

		// $data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if ($this->input->post('config_limit_admin')) {
			$data['config_limit_admin'] = $this->input->post('config_limit_admin');
		} else {
			$data['config_limit_admin'] = $this->configs->get('config_limit_admin');
		}

		if ($this->input->post('config_blog_count')) {
			$data['config_blog_count'] = $this->input->post('config_blog_count');
		} else {
			$data['config_blog_count'] = $this->configs->get('config_blog_count');
		}

		// if ($this->input->post('config_review_status')) {
		// 	$data['config_review_status'] = $this->input->post('config_review_status');
		// } else {
		// 	$data['config_review_status'] = $this->configs->get('config_review_status');
		// }
		// if ($this->input->post('config_reviewblog_status')) {
		// 	$data['config_reviewblog_status'] = $this->input->post('config_reviewblog_status');
		// } else {
		// 	$data['config_reviewblog_status'] = $this->configs->get('config_reviewblog_status');
		// }

		// if ($this->input->post('config_review_guest')) {
		// 	$data['config_review_guest'] = $this->input->post('config_review_guest');
		// } else {
		// 	$data['config_review_guest'] = $this->configs->get('config_review_guest');
		// }
		// if ($this->input->post('config_reviewblog_guest')) {
		// 	$data['config_reviewblog_guest'] = $this->input->post('config_reviewblog_guest');
		// } else {
		// 	$data['config_reviewblog_guest'] = $this->configs->get('config_reviewblog_guest');
		// }

		// if ($this->input->post('config_voucher_min')) {
		// 	$data['config_voucher_min'] = $this->input->post('config_voucher_min');
		// } else {
		// 	$data['config_voucher_min'] = $this->configs->get('config_voucher_min');
		// }

		// if ($this->input->post('config_voucher_max')) {
		// 	$data['config_voucher_max'] = $this->input->post('config_voucher_max');
		// } else {
		// 	$data['config_voucher_max'] = $this->configs->get('config_voucher_max');
		// }

		// if ($this->input->post('config_tax')) {
		// 	$data['config_tax'] = $this->input->post('config_tax');
		// } else {
		// 	$data['config_tax'] = $this->configs->get('config_tax');
		// }

		// if ($this->input->post('config_tax_default')) {
		// 	$data['config_tax_default'] = $this->input->post('config_tax_default');
		// } else {
		// 	$data['config_tax_default'] = $this->configs->get('config_tax_default');
		// }

		// if ($this->input->post('config_tax_customer')) {
		// 	$data['config_tax_customer'] = $this->input->post('config_tax_customer');
		// } else {
		// 	$data['config_tax_customer'] = $this->configs->get('config_tax_customer');
		// }

		// if ($this->input->post('config_customer_online')) {
		// 	$data['config_customer_online'] = $this->input->post('config_customer_online');
		// } else {
		// 	$data['config_customer_online'] = $this->configs->get('config_customer_online');
		// }

		// if ($this->input->post('config_customer_activity')) {
		// 	$data['config_customer_activity'] = $this->input->post('config_customer_activity');
		// } else {
		// 	$data['config_customer_activity'] = $this->configs->get('config_customer_activity');
		// }

		// if ($this->input->post('config_customer_search')) {
		// 	$data['config_customer_search'] = $this->input->post('config_customer_search');
		// } else {
		// 	$data['config_customer_search'] = $this->configs->get('config_customer_search');
		// }

		// if ($this->input->post('config_customer_group_id')) {
		// 	$data['config_customer_group_id'] = $this->input->post('config_customer_group_id');
		// } else {
		// 	$data['config_customer_group_id'] = $this->configs->get('config_customer_group_id');
		// }

		// $this->load->model('customer/customer_group_model','model_customer_customer_group');

		// $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// if ($this->input->post('config_customer_group_display')) {
		// 	$data['config_customer_group_display'] = $this->input->post('config_customer_group_display');
		// } elseif ($this->configs->get('config_customer_group_display')) {
		// 	$data['config_customer_group_display'] = $this->configs->get('config_customer_group_display');
		// } else {
		// 	$data['config_customer_group_display'] = array();
		// }

		// if ($this->input->post('config_customer_price')) {
		// 	$data['config_customer_price'] = $this->input->post('config_customer_price');
		// } else {
		// 	$data['config_customer_price'] = $this->configs->get('config_customer_price');
		// }

		// if ($this->input->post('config_login_attempts')) {
		// 	$data['config_login_attempts'] = $this->input->post('config_login_attempts');
		// } elseif ($this->configs->has('config_login_attempts')) {
		// 	$data['config_login_attempts'] = $this->configs->get('config_login_attempts');
		// } else {
		// 	$data['config_login_attempts'] = 5;
		// }

		// if ($this->input->post('config_account_id')) {
		// 	$data['config_account_id'] = $this->input->post('config_account_id');
		// } else {
		// 	$data['config_account_id'] = $this->configs->get('config_account_id');
		// }

		// $this->load->model('catalog/information');

		// $data['informations'] = $this->model_catalog_information->getInformations();

		// if ($this->input->post('config_cart_weight')) {
		// 	$data['config_cart_weight'] = $this->input->post('config_cart_weight');
		// } else {
		// 	$data['config_cart_weight'] = $this->configs->get('config_cart_weight');
		// }

		// if ($this->input->post('config_checkout_guest')) {
		// 	$data['config_checkout_guest'] = $this->input->post('config_checkout_guest');
		// } else {
		// 	$data['config_checkout_guest'] = $this->configs->get('config_checkout_guest');
		// }

		// if ($this->input->post('config_checkout_id')) {
		// 	$data['config_checkout_id'] = $this->input->post('config_checkout_id');
		// } else {
		// 	$data['config_checkout_id'] = $this->configs->get('config_checkout_id');
		// }

		// if ($this->input->post('config_invoice_prefix')) {
		// 	$data['config_invoice_prefix'] = $this->input->post('config_invoice_prefix');
		// } elseif ($this->configs->get('config_invoice_prefix')) {
		// 	$data['config_invoice_prefix'] = $this->configs->get('config_invoice_prefix');
		// } else {
		// 	$data['config_invoice_prefix'] = 'INV-' . date('Y') . '-00';
		// }

		// if ($this->input->post('config_order_status_id')) {
		// 	$data['config_order_status_id'] = $this->input->post('config_order_status_id');
		// } else {
		// 	$data['config_order_status_id'] = $this->configs->get('config_order_status_id');
		// }

		// if ($this->input->post('config_processing_status')) {
		// 	$data['config_processing_status'] = $this->input->post('config_processing_status');
		// } elseif ($this->configs->get('config_processing_status')) {
		// 	$data['config_processing_status'] = $this->configs->get('config_processing_status');
		// } else {
		// 	$data['config_processing_status'] = array();
		// }

		// if ($this->input->post('config_complete_status')) {
		// 	$data['config_complete_status'] = $this->input->post('config_complete_status');
		// } elseif ($this->configs->get('config_complete_status')) {
		// 	$data['config_complete_status'] = $this->configs->get('config_complete_status');
		// } else {
		// 	$data['config_complete_status'] = array();
		// }

		// if ($this->input->post('config_fraud_status_id')) {
		// 	$data['config_fraud_status_id'] = $this->input->post('config_fraud_status_id');
		// } else {
		// 	$data['config_fraud_status_id'] = $this->configs->get('config_fraud_status_id');
		// }

		// $this->load->model('localisation/order_status');

		// $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// if ($this->input->post('config_api_id')) {
		// 	$data['config_api_id'] = $this->input->post('config_api_id');
		// } else {
		// 	$data['config_api_id'] = $this->configs->get('config_api_id');
		// }

		// $this->load->model('user/api');

		// $data['apis'] = $this->model_user_api->getApis();

		// if ($this->input->post('config_stock_display')) {
		// 	$data['config_stock_display'] = $this->input->post('config_stock_display');
		// } else {
		// 	$data['config_stock_display'] = $this->configs->get('config_stock_display');
		// }

		// if ($this->input->post('config_stock_warning')) {
		// 	$data['config_stock_warning'] = $this->input->post('config_stock_warning');
		// } else {
		// 	$data['config_stock_warning'] = $this->configs->get('config_stock_warning');
		// }

		// if ($this->input->post('config_stock_checkout')) {
		// 	$data['config_stock_checkout'] = $this->input->post('config_stock_checkout');
		// } else {
		// 	$data['config_stock_checkout'] = $this->configs->get('config_stock_checkout');
		// }

		// if ($this->input->post('config_affiliate_group_id')) {
		// 	$data['config_affiliate_group_id'] = $this->input->post('config_affiliate_group_id');
		// } else {
		// 	$data['config_affiliate_group_id'] = $this->configs->get('config_affiliate_group_id');
		// }

		// if ($this->input->post('config_affiliate_approval')) {
		// 	$data['config_affiliate_approval'] = $this->input->post('config_affiliate_approval');
		// } elseif ($this->configs->has('config_affiliate_approval')) {
		// 	$data['config_affiliate_approval'] = $this->configs->get('config_affiliate_approval');
		// } else {
		// 	$data['config_affiliate_approval'] = '';
		// }

		// if ($this->input->post('config_affiliate_auto')) {
		// 	$data['config_affiliate_auto'] = $this->input->post('config_affiliate_auto');
		// } elseif ($this->configs->has('config_affiliate_auto')) {
		// 	$data['config_affiliate_auto'] = $this->configs->get('config_affiliate_auto');
		// } else {
		// 	$data['config_affiliate_auto'] = '';
		// }

		// if ($this->input->post('config_affiliate_commission')) {
		// 	$data['config_affiliate_commission'] = $this->input->post('config_affiliate_commission');
		// } elseif ($this->configs->has('config_affiliate_commission')) {
		// 	$data['config_affiliate_commission'] = $this->configs->get('config_affiliate_commission');
		// } else {
		// 	$data['config_affiliate_commission'] = '5.00';
		// }

		// if ($this->input->post('config_affiliate_id')) {
		// 	$data['config_affiliate_id'] = $this->input->post('config_affiliate_id');
		// } else {
		// 	$data['config_affiliate_id'] = $this->configs->get('config_affiliate_id');
		// }

		// if ($this->input->post('config_return_id')) {
		// 	$data['config_return_id'] = $this->input->post('config_return_id');
		// } else {
		// 	$data['config_return_id'] = $this->configs->get('config_return_id');
		// }

		// if ($this->input->post('config_return_status_id')) {
		// 	$data['config_return_status_id'] = $this->input->post('config_return_status_id');
		// } else {
		// 	$data['config_return_status_id'] = $this->configs->get('config_return_status_id');
		// }

		// $this->load->model('localisation/return_status');

		// $data['return_statuses'] = $this->model_localisation_return_status->getReturnStatuses();

		if ($this->input->post('config_captcha')) {
			$data['config_captcha'] = $this->input->post('config_captcha');
		} else {
			$data['config_captcha'] = $this->configs->get('config_captcha');
		}
		
		$this->load->model('setting/extension','model_setting_extension');

		$data['captchas'] = array();

		// Get a list of installed captchas
		$extensions = $this->model_setting_extension->getInstalled('captcha');

		foreach ($extensions as $code) {
			$this->lang->load('extension/captcha/' . $code, 'extension');

			if ($this->configs->get('captcha_' . $code . '_status')) {
				$data['captchas'][] = array(
					'text'  => $this->lang->line('extension')->get('heading_title'),
					'value' => $code
				);
			}
		}		

		if ($this->input->post('config_captcha_page')) {
			$data['config_captcha_page'] = $this->input->post('config_captcha_page');
		} elseif ($this->configs->has('config_captcha_page')) {
		   	$data['config_captcha_page'] = $this->configs->get('config_captcha_page');
		} else {
			$data['config_captcha_page'] = array();
		}

		$data['captcha_pages'] = array();

		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_register'),
			'value' => 'register'
		);
		
		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_guest'),
			'value' => 'guest'
		);
		
		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_review'),
			'value' => 'review'
		);
		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_reviewblog'),
			'value' => 'reviewblog'
		);


		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_return'),
			'value' => 'return'
		);

		$data['captcha_pages'][] = array(
			'text'  => $this->lang->line('text_contact'),
			'value' => 'contact'
		);

		if ($this->input->post('config_logo')) {
			$data['config_logo'] = $this->input->post('config_logo');
		} else {
			$data['config_logo'] = $this->configs->get('config_logo');
		}

		if ($this->input->post('config_logo') && is_file(DIR_IMAGE . $this->input->post('config_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->input->post('config_logo'), 100, 100);
		} elseif ($this->configs->get('config_logo') && is_file(DIR_IMAGE . $this->configs->get('config_logo'))) {
			$data['logo'] = $this->model_tool_image->resize($this->configs->get('config_logo'), 100, 100);
		} else {
			$data['logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if ($this->input->post('config_icon')) {
			$data['config_icon'] = $this->input->post('config_icon');
		} else {
			$data['config_icon'] = $this->configs->get('config_icon');
		}

		if ($this->input->post('config_icon') && is_file(DIR_IMAGE . $this->input->post('config_icon'))) {
			$data['icon'] = $this->model_tool_image->resize($this->input->post('config_icon'), 100, 100);
		} elseif ($this->configs->get('config_icon') && is_file(DIR_IMAGE . $this->configs->get('config_icon'))) {
			$data['icon'] = $this->model_tool_image->resize($this->configs->get('config_icon'), 100, 100);
		} else {
			$data['icon'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if ($this->input->post('config_mail_engine')) {
			$data['config_mail_engine'] = $this->input->post('config_mail_engine');
		} else {
			$data['config_mail_engine'] = $this->configs->get('config_mail_engine');
		}

		if ($this->input->post('config_mail_parameter')) {
			$data['config_mail_parameter'] = $this->input->post('config_mail_parameter');
		} else {
			$data['config_mail_parameter'] = $this->configs->get('config_mail_parameter');
		}

		if ($this->input->post('config_mail_smtp_hostname')) {
			$data['config_mail_smtp_hostname'] = $this->input->post('config_mail_smtp_hostname');
		} else {
			$data['config_mail_smtp_hostname'] = $this->configs->get('config_mail_smtp_hostname');
		}

		if ($this->input->post('config_mail_smtp_username')) {
			$data['config_mail_smtp_username'] = $this->input->post('config_mail_smtp_username');
		} else {
			$data['config_mail_smtp_username'] = $this->configs->get('config_mail_smtp_username');
		}

		if ($this->input->post('config_mail_smtp_password')) {
			$data['config_mail_smtp_password'] = $this->input->post('config_mail_smtp_password');
		} else {
			$data['config_mail_smtp_password'] = $this->configs->get('config_mail_smtp_password');
		}

		if ($this->input->post('config_mail_smtp_port')) {
			$data['config_mail_smtp_port'] = $this->input->post('config_mail_smtp_port');
		} elseif ($this->configs->has('config_mail_smtp_port')) {
			$data['config_mail_smtp_port'] = $this->configs->get('config_mail_smtp_port');
		} else {
			$data['config_mail_smtp_port'] = 25;
		}

		if ($this->input->post('config_mail_smtp_timeout')) {
			$data['config_mail_smtp_timeout'] = $this->input->post('config_mail_smtp_timeout');
		} elseif ($this->configs->has('config_mail_smtp_timeout')) {
			$data['config_mail_smtp_timeout'] = $this->configs->get('config_mail_smtp_timeout');
		} else {
			$data['config_mail_smtp_timeout'] = 5;
		}

		if ($this->input->post('config_mail_alert')) {
			$data['config_mail_alert'] = $this->input->post('config_mail_alert');
		} elseif ($this->configs->has('config_mail_alert')) {
		   	$data['config_mail_alert'] = $this->configs->get('config_mail_alert');
		} else {
			$data['config_mail_alert'] = array();
		}

		$data['mail_alerts'] = array();

		$data['mail_alerts'][] = array(
			'text'  => $this->lang->line('text_mail_account'),
			'value' => 'account'
		);

		$data['mail_alerts'][] = array(
			'text'  => $this->lang->line('text_mail_affiliate'),
			'value' => 'affiliate'
		);

		$data['mail_alerts'][] = array(
			'text'  => $this->lang->line('text_mail_order'),
			'value' => 'order'
		);

		$data['mail_alerts'][] = array(
			'text'  => $this->lang->line('text_mail_review'),
			'value' => 'review'
		);
		$data['mail_alerts'][] = array(
			'text'  => $this->lang->line('text_mail_reviewblog'),
			'value' => 'reviewblog'
		);

		if ($this->input->post('config_mail_alert_email')) {
			$data['config_mail_alert_email'] = $this->input->post('config_mail_alert_email');
		} else {
			$data['config_mail_alert_email'] = $this->configs->get('config_mail_alert_email');
		}
		
		if ($this->input->post('config_secure')) {
			$data['config_secure'] = $this->input->post('config_secure');
		} else {
			$data['config_secure'] = $this->configs->get('config_secure');
		}

		if ($this->input->post('config_shared')) {
			$data['config_shared'] = $this->input->post('config_shared');
		} else {
			$data['config_shared'] = $this->configs->get('config_shared');
		}

		if ($this->input->post('config_robots')) {
			$data['config_robots'] = $this->input->post('config_robots');
		} else {
			$data['config_robots'] = $this->configs->get('config_robots');
		}

		if ($this->input->post('config_seo_url')) {
			$data['config_seo_url'] = $this->input->post('config_seo_url');
		} else {
			$data['config_seo_url'] = $this->configs->get('config_seo_url');
		}

		if ($this->input->post('config_file_max_size')) {
			$data['config_file_max_size'] = $this->input->post('config_file_max_size');
		} elseif ($this->configs->get('config_file_max_size')) {
			$data['config_file_max_size'] = $this->configs->get('config_file_max_size');
		} else {
			$data['config_file_max_size'] = 300000;
		}

		if ($this->input->post('config_file_ext_allowed')) {
			$data['config_file_ext_allowed'] = $this->input->post('config_file_ext_allowed');
		} else {
			$data['config_file_ext_allowed'] = $this->configs->get('config_file_ext_allowed');
		}

		if ($this->input->post('config_file_mime_allowed')) {
			$data['config_file_mime_allowed'] = $this->input->post('config_file_mime_allowed');
		} else {
			$data['config_file_mime_allowed'] = $this->configs->get('config_file_mime_allowed');
		}

		if ($this->input->post('config_maintenance')) {
			$data['config_maintenance'] = $this->input->post('config_maintenance');
		} else {
			$data['config_maintenance'] = $this->configs->get('config_maintenance');
		}

		if ($this->input->post('config_password')) {
			$data['config_password'] = $this->input->post('config_password');
		} else {
			$data['config_password'] = $this->configs->get('config_password');
		}

		if ($this->input->post('config_encryption')) {
			$data['config_encryption'] = $this->input->post('config_encryption');
		} else {
			$data['config_encryption'] = $this->configs->get('config_encryption');
		}

		if ($this->input->post('config_compression')) {
			$data['config_compression'] = $this->input->post('config_compression');
		} else {
			$data['config_compression'] = $this->configs->get('config_compression');
		}

		if ($this->input->post('config_error_display')) {
			$data['config_error_display'] = $this->input->post('config_error_display');
		} else {
			$data['config_error_display'] = $this->configs->get('config_error_display');
		}

		if ($this->input->post('config_error_log')) {
			$data['config_error_log'] = $this->input->post('config_error_log');
		} else {
			$data['config_error_log'] = $this->configs->get('config_error_log');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('setting/setting', $data);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if (!$this->input->post('config_meta_title')) {
			$this->error['meta_title'] = $this->lang->line('error_meta_title');
		}

		if (!$this->input->post('config_name')) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		if ((utf8_strlen($this->input->post('config_owner')) < 3) || (utf8_strlen($this->input->post('config_owner')) > 64)) {
			$this->error['owner'] = $this->lang->line('error_owner');
		}

		if ((utf8_strlen($this->input->post('config_address')) < 3) || (utf8_strlen($this->input->post('config_address')) > 256)) {
			$this->error['address'] = $this->lang->line('error_address');
		}

		if ((utf8_strlen($this->input->post('config_email')) > 96) || !filter_var($this->input->post('config_email'), FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->lang->line('error_email');
		}

		if ((utf8_strlen($this->input->post('config_telephone')) < 3) || (utf8_strlen($this->input->post('config_telephone')) > 32)) {
			$this->error['telephone'] = $this->lang->line('error_telephone');
		}
		
		if ((utf8_strlen($this->input->post('config_encryption')) < 32) || (utf8_strlen($this->input->post('config_encryption')) > 1024)) {
			$this->error['encryption'] = $this->lang->line('error_encryption');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->lang->line('error_warning');
		}

		return !$this->error;
	}
	
	public function theme() {
		if ($this->input->server['HTTPS']) {
			$server = HTTPS_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}
		
		// This is only here for compatibility with old themes.
		if ($this->request->get['theme'] == 'theme_default') {
			$theme = $this->configs->get('theme_default_directory');
		} else {
			$theme = basename($this->request->get['theme']);
		}
		
		if (is_file(DIR_CATALOG . 'view/theme/' . $theme . '/image/' . $theme . '.png')) {
			$this->response->setOutput($server . 'catalog/view/theme/' . $theme . '/image/' . $theme . '.png');
		} else {
			$this->response->setOutput($server . 'image/no_image.png');
		}
	}	
}
