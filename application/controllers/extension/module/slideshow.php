<?php
class Slideshow extends MX_Controller {
	public function index($setting = array()) {
		static $module = 0;		

		$this->load->model('design/banner_model');
		$this->load->model('tool/image_model');

		$this->document->addStyle('public/javascript/jquery/swiper/css/swiper.min.css');
		$this->document->addStyle('public/javascript/jquery/swiper/css/opencart.css');
		$this->document->addScript('public/javascript/jquery/swiper/js/swiper.jquery.js');
		
		$data['banners'] = array();

		$results = $this->banner_model->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->image_model->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('default/extension/module/slideshow', $data,true);
	}
}