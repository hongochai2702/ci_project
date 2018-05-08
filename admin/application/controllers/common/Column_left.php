<?php
class Column_left extends MX_Controller {
	public function index() {
		if (($this->input->get('user_token')) && ($this->session->userdata('user_token')) && ($this->input->get('user_token') == $this->session->userdata('user_token'))) {
			$this->lang->load('common/column_left');

			$data['text_navigation'] = $this->lang->line('text_navigation');

			$data['text_complete_status'] = $this->lang->line('text_complete_status');
			$data['text_processasg_status'] = $this->lang->line('text_processasg_status');
			$data['text_other_status'] = $this->lang->line('text_other_status');
			$data['menus'][] = array(
				'id'       => 'menu-dashboard',
				'icon'	   => 'fa-dashboard',
				'name'	   => $this->lang->line('text_dashboard'),
				'href'     => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true),
				'children' => array()
			);
			
			// Catalog
			$catalog = array();
			
			if ($this->user->hasPermission('access', 'catalog/category')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_category'),
					'href'     => $this->url->link('catalog/category', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/product')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_product'),
					'href'     => $this->url->link('catalog/product', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			// Portfolio menu.
			$admin_menu_portfolio = array();
			if ($this->user->hasPermission('access', 'post_type/portfolio/portfolio')) {
				$admin_menu_portfolio[] = array(
					'name'	   => $this->lang->line('text_all_portfolio'),
					'href'     => $this->url->link('post_type/portfolio/portfolio', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			if ($this->user->hasPermission('access', 'post_type/portfolio/portfolio/add')) {
				$admin_menu_portfolio[] = array(
					'name'	   => $this->lang->line('text_add_portfolio'),
					'href'     => $this->url->link('post_type/portfolio/portfolio/add', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'post_type/portfolio/portfolio_cat')) {
				$admin_menu_portfolio[] = array(
					'name'	   => $this->lang->line('text_portfolio_cat'),
					'href'     => $this->url->link('post_type/portfolio/portfolio_cat', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			if ($this->user->hasPermission('access', 'post_type/portfolio/portfolio_tag')) {
				$admin_menu_portfolio[] = array(
					'name'	   => $this->lang->line('text_portfolio_tag'),
					'href'     => $this->url->link('post_type/portfolio/portfolio_tag', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			
			$catalogblog = array();
			if ($this->user->hasPermission('access', 'catalog/categoryblog')) {
				$catalogblog[] = array(
					'name'	   => $this->lang->line('text_categoryblog'),
					'href'     => $this->url->link('catalog/categoryblog', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/blog')) {
				$catalogblog[] = array(
					'name'	   => $this->lang->line('text_blog'),
					'href'     => $this->url->link('catalog/blog', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			if ($this->user->hasPermission('access', 'catalog/recurring')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_recurring'),
					'href'     => $this->url->link('catalog/recurring', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/filter')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_filter'),
					'href'     => $this->url->link('catalog/filter', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			
			
			// Attributes
			$attribute = array();
			
			if ($this->user->hasPermission('access', 'catalog/attribute')) {
				$attribute[] = array(
					'name'     => $this->lang->line('text_attribute'),
					'href'     => $this->url->link('catalog/attribute', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()	
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/attribute_group')) {
				$attribute[] = array(
					'name'	   => $this->lang->line('text_attribute_group'),
					'href'     => $this->url->link('catalog/attribute_group', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($attribute) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_attribute'),
					'href'     => '',
					'children' => $attribute
				);
			}

			$activity = array();
			if ($this->user->hasPermission('access', 'common/newsletter')) {
				$activity[] = array(
					'name'	   => $this->lang->line('text_newsletter'),
					'href'     => $this->url->link('common/newsletter', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			if ($this->user->hasPermission('access', 'common/newsletter_full')) {
				$activity[] = array(
					'name'	   => $this->lang->line('text_newsletter_full'),
					'href'     => $this->url->link('common/newsletter_full', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			
			if ($this->user->hasPermission('access', 'catalog/option')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_option'),
					'href'     => $this->url->link('catalog/option', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			if ($this->user->hasPermission('access', 'catalog/manufacturer')) {
				$catalogblog[] = array(
					'name'	   => $this->lang->line('text_manufacturer'),
					'href'     => $this->url->link('catalog/manufacturer', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/download')) {
				$catalog[] = array(
					'name'	   => $this->lang->line('text_download'),
					'href'     => $this->url->link('catalog/download', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'catalog/review')) {		
				$catalog[] = array(
					'name'	   => $this->lang->line('text_review'),
					'href'     => $this->url->link('catalog/review', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);		
			}
			if ($this->user->hasPermission('access', 'catalog/reviewblog')) {		
				$catalogblog[] = array(
					'name'	   => $this->lang->line('text_review'),
					'href'     => $this->url->link('catalog/reviewblog', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);		
			}
			
			if ($this->user->hasPermission('access', 'catalog/information')) {		
				$catalog[] = array(
					'name'	   => $this->lang->line('text_information'),
					'href'     => $this->url->link('catalog/information', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);					
			}
			
			if ($catalog) {
				$data['menus'][] = array(
					'id'       => 'menu-catalog',
					'icon'	   => 'fa-tags', 
					'name'	   => $this->lang->line('text_catalog'),
					'href'     => '',
					'children' => $catalog
				);		
			}
			if ($catalogblog) {
				$data['menus'][] = array(
					'id'       => 'menu-catalogblog',
					'icon'	   => 'fa-tags', 
					'name'	   => $this->lang->line('text_catalogblog'),
					'href'     => '',
					'children' => $catalogblog
				);		
			}
			if ($admin_menu_portfolio) {
				$data['menus'][] = array(
					'id'       => 'menu-portfolio',
					'icon'	   => 'fa-tags', 
					'name'	   => $this->lang->line('text_portfolio'),
					'href'     => '',
					'children' => $admin_menu_portfolio
				);		
			}
			if ($activity) {
				$data['menus'][] = array(
					'id'       => 'menu-catalogblog',
					'icon'	   => 'fa-tags', 
					'name'	   => $this->lang->line('text_activity'),
					'href'     => '',
					'children' => $activity
				);		
			}
			
			// Extension
			$marketplace = array();
			
			if ($this->user->hasPermission('access', 'marketplace/marketplace')) {		
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_marketplace'),
					'href'     => $this->url->link('marketplace/marketplace', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);					
			}
			
			if ($this->user->hasPermission('access', 'marketplace/installer')) {		
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_installer'),
					'href'     => $this->url->link('marketplace/installer', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);					
			}	
			
			if ($this->user->hasPermission('access', 'marketplace/extension')) {		
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_extension'),
					'href'     => $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}

			if ($this->user->hasPermission('access', 'feed/image_manager')) {
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_image_manager'),
					'href'     => $this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
								
			if ($this->user->hasPermission('access', 'marketplace/modification')) {
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_modification'),
					'href'     => $this->url->link('marketplace/modification', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'marketplace/event')) {
				$marketplace[] = array(
					'name'	   => $this->lang->line('text_event'),
					'href'     => $this->url->link('marketplace/event', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
					
			if ($marketplace) {					
				$data['menus'][] = array(
					'id'       => 'menu-extension',
					'icon'	   => 'fa-puzzle-piece', 
					'name'	   => $this->lang->line('text_extension'),
					'href'     => '',
					'children' => $marketplace
				);		
			}
			
			// Design
			$design = array();
			
			if ($this->user->hasPermission('access', 'design/layout')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_layout'),
					'href'     => $this->url->link('design/layout', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);	
			}

			if ($this->user->hasPermission('access', 'design/menu')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_menu'),
					'href'     => $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);	
			}
			
			if ($this->user->hasPermission('access', 'design/theme')) {	
				$design[] = array(
					'name'	   => $this->lang->line('text_theme'),
					'href'     => $this->url->link('design/theme', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'design/translation')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_language_editor'),
					'href'     => $this->url->link('design/translation', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
						
			if ($this->user->hasPermission('access', 'design/banner')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_banner'),
					'href'     => $this->url->link('design/banner', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}

			if ($this->user->hasPermission('access', 'design/video')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_video'),
					'href'     => $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'design/say')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_say'),
					'href'     => $this->url->link('design/say', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			if ($this->user->hasPermission('access', 'design/menu')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_menu'),
					'href'     => $this->url->link('design/menu', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'design/seo_url')) {
				$design[] = array(
					'name'	   => $this->lang->line('text_seo_url'),
					'href'     => $this->url->link('design/seo_url', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
						
			if ($design) {
				$data['menus'][] = array(
					'id'       => 'menu-design',
					'icon'	   => 'fa-television', 
					'name'	   => $this->lang->line('text_design'),
					'href'     => '',
					'children' => $design
				);	
			}
			
			// Sales
			$sale = array();
			
			if ($this->user->hasPermission('access', 'sale/order')) {
				$sale[] = array(
					'name'	   => $this->lang->line('text_order'),
					'href'     => $this->url->link('sale/order', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'sale/recurring')) {	
				$sale[] = array(
					'name'	   => $this->lang->line('text_recurring'),
					'href'     => $this->url->link('sale/recurring', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'sale/return')) {
				$sale[] = array(
					'name'	   => $this->lang->line('text_return'),
					'href'     => $this->url->link('sale/return', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			// Voucher
			$voucher = array();
			
			if ($this->user->hasPermission('access', 'sale/voucher')) {
				$voucher[] = array(
					'name'	   => $this->lang->line('text_voucher'),
					'href'     => $this->url->link('sale/voucher', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'sale/voucher_theme')) {
				$voucher[] = array(
					'name'	   => $this->lang->line('text_voucher_theme'),
					'href'     => $this->url->link('sale/voucher_theme', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($voucher) {
				$sale[] = array(
					'name'	   => $this->lang->line('text_voucher'),
					'href'     => '',
					'children' => $voucher		
				);		
			}
			
			if ($sale) {
				$data['menus'][] = array(
					'id'       => 'menu-sale',
					'icon'	   => 'fa-shopping-cart', 
					'name'	   => $this->lang->line('text_sale'),
					'href'     => '',
					'children' => $sale
				);
			}
			
			// Customer
			$customer = array();
			
			if ($this->user->hasPermission('access', 'customer/customer')) {
				$customer[] = array(
					'name'	   => $this->lang->line('text_customer'),
					'href'     => $this->url->link('customer/customer', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'customer/customer_group')) {
				$customer[] = array(
					'name'	   => $this->lang->line('text_customer_group'),
					'href'     => $this->url->link('customer/customer_group', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
				
			if ($this->user->hasPermission('access', 'customer/customer_approval')) {
				$customer[] = array(
					'name'	   => $this->lang->line('text_customer_approval'),
					'href'     => $this->url->link('customer/customer_approval', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
						
			if ($this->user->hasPermission('access', 'customer/custom_field')) {		
				$customer[] = array(
					'name'	   => $this->lang->line('text_custom_field'),
					'href'     => $this->url->link('customer/custom_field', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($customer) {
				$data['menus'][] = array(
					'id'       => 'menu-customer',
					'icon'	   => 'fa-user', 
					'name'	   => $this->lang->line('text_customer'),
					'href'     => '',
					'children' => $customer
				);	
			}
			
			// Marketing
			$marketing = array();
			
			if ($this->user->hasPermission('access', 'marketing/marketing')) {
				$marketing[] = array(
					'name'	   => $this->lang->line('text_marketing'),
					'href'     => $this->url->link('marketing/marketing', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'marketing/coupon')) {	
				$marketing[] = array(
					'name'	   => $this->lang->line('text_coupon'),
					'href'     => $this->url->link('marketing/coupon', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'marketing/contact')) {
				$marketing[] = array(
					'name'	   => $this->lang->line('text_contact'),
					'href'     => $this->url->link('marketing/contact', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($marketing) {
				$data['menus'][] = array(
					'id'       => 'menu-marketing',
					'icon'	   => 'fa-share-alt', 
					'name'	   => $this->lang->line('text_marketing'),
					'href'     => '',
					'children' => $marketing
				);	
			}
			
			// System
			$system = array();
			
			if ($this->user->hasPermission('access', 'setting/setting')) {
				$system[] = array(
					'name'	   => $this->lang->line('text_setting'),
					'href'     => $this->url->link('setting/store', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
		
			// Users
			$user = array();
			
			if ($this->user->hasPermission('access', 'user/user')) {
				$user[] = array(
					'name'	   => $this->lang->line('text_users'),
					'href'     => $this->url->link('user/user', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'user/user_permission')) {	
				$user[] = array(
					'name'	   => $this->lang->line('text_user_group'),
					'href'     => $this->url->link('user/user_permission', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'user/api')) {		
				$user[] = array(
					'name'	   => $this->lang->line('text_api'),
					'href'     => $this->url->link('user/api', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($user) {
				$system[] = array(
					'name'	   => $this->lang->line('text_users'),
					'href'     => '',
					'children' => $user		
				);
			}
			
			// Localisation
			$localisation = array();
			
			if ($this->user->hasPermission('access', 'localisation/location')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_location'),
					'href'     => $this->url->link('localisation/location', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
			
			if ($this->user->hasPermission('access', 'localisation/language')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_language'),
					'href'     => $this->url->link('localisation/language', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/currency')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_currency'),
					'href'     => $this->url->link('localisation/currency', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/stock_status')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_stock_status'),
					'href'     => $this->url->link('localisation/stock_status', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/order_status')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_order_status'),
					'href'     => $this->url->link('localisation/order_status', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			// Returns
			$return = array();
			
			if ($this->user->hasPermission('access', 'localisation/return_status')) {
				$return[] = array(
					'name'	   => $this->lang->line('text_return_status'),
					'href'     => $this->url->link('localisation/return_status', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/return_action')) {
				$return[] = array(
					'name'	   => $this->lang->line('text_return_action'),
					'href'     => $this->url->link('localisation/return_action', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);		
			}
			
			if ($this->user->hasPermission('access', 'localisation/return_reason')) {
				$return[] = array(
					'name'	   => $this->lang->line('text_return_reason'),
					'href'     => $this->url->link('localisation/return_reason', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($return) {	
				$localisation[] = array(
					'name'	   => $this->lang->line('text_return'),
					'href'     => '',
					'children' => $return		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/country')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_country'),
					'href'     => $this->url->link('localisation/country', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/zone')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_zone'),
					'href'     => $this->url->link('localisation/zone', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/geo_zone')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_geo_zone'),
					'href'     => $this->url->link('localisation/geo_zone', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}
			
			// Tax		
			$tax = array();
			
			if ($this->user->hasPermission('access', 'localisation/tax_class')) {
				$tax[] = array(
					'name'	   => $this->lang->line('text_tax_class'),
					'href'     => $this->url->link('localisation/tax_class', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/tax_rate')) {
				$tax[] = array(
					'name'	   => $this->lang->line('text_tax_rate'),
					'href'     => $this->url->link('localisation/tax_rate', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}
			
			if ($tax) {	
				$localisation[] = array(
					'name'	   => $this->lang->line('text_tax'),
					'href'     => '',
					'children' => $tax		
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/length_class')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_length_class'),
					'href'     => $this->url->link('localisation/length_class', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}
			
			if ($this->user->hasPermission('access', 'localisation/weight_class')) {
				$localisation[] = array(
					'name'	   => $this->lang->line('text_weight_class'),
					'href'     => $this->url->link('localisation/weight_class', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()
				);
			}
			
			if ($localisation) {																
				$system[] = array(
					'name'	   => $this->lang->line('text_localisation'),
					'href'     => '',
					'children' => $localisation	
				);
			}
			
			// Tools	
			$maintenance = array();
				
			if ($this->user->hasPermission('access', 'tool/backup')) {
				$maintenance[] = array(
					'name'	   => $this->lang->line('text_backup'),
					'href'     => $this->url->link('tool/backup', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
					
			if ($this->user->hasPermission('access', 'tool/upload')) {
				$maintenance[] = array(
					'name'	   => $this->lang->line('text_upload'),
					'href'     => $this->url->link('tool/upload', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);	
			}
						
			if ($this->user->hasPermission('access', 'tool/log')) {
				$maintenance[] = array(
					'name'	   => $this->lang->line('text_log'),
					'href'     => $this->url->link('tool/log', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
		
			if ($maintenance) {
				$system[] = array(
					'id'       => 'menu-maintenance',
					'icon'	   => 'fa-cog', 
					'name'	   => $this->lang->line('text_maintenance'),
					'href'     => '',
					'children' => $maintenance
				);
			}		
		
		
			if ($system) {
				$data['menus'][] = array(
					'id'       => 'menu-system',
					'icon'	   => 'fa-cog', 
					'name'	   => $this->lang->line('text_system'),
					'href'     => '',
					'children' => $system
				);
			}
			
			$report = array();
							
			if ($this->user->hasPermission('access', 'report/report')) {
				$report[] = array(
					'name'	   => $this->lang->line('text_reports'),
					'href'     => $this->url->link('report/report', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}


					
			if ($this->user->hasPermission('access', 'report/online')) {
				$report[] = array(
					'name'	   => $this->lang->line('text_online'),
					'href'     => $this->url->link('report/online', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}
											
			if ($this->user->hasPermission('access', 'report/statistics')) {
				$report[] = array(
					'name'	   => $this->lang->line('text_statistics'),
					'href'     => $this->url->link('report/statistics', 'user_token=' . $this->session->userdata('user_token'), true),
					'children' => array()		
				);
			}	
			if ($this->user->hasPermission('access', 'report/report')) {
			$data['menus'][] = array(
				'id'       => 'menu-report',
				'icon'	   => 'fa-bar-chart-o', 
				'name'	   => $this->lang->line('text_reports'),
				'href'     => '',
				'children' => $report
			);	
			}
			return $this->load->view('common/column_left', $data, true);
		}
	}
}