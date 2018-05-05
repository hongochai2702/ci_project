<?php

	class Video extends MX_Controller {

		public function index($setting = array()) {
			static $module = 0;

			$this->load->model('design/video_model','model_design_video');
			$this->load->model('tool/image_model','model_tool_image');

			$data['videos'] = array();

			$results = $this->model_design_video->getVideo($setting['video_id']);
			
			foreach ($results as $result) {
				if (is_file(DIR_IMAGE . $result['image'])) {
					$data['videos'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
					);
				}
			}

			$data['module'] = $module++;
			
			return $this->load->view('default/extension/module/video_gallery_view', $data,true);
		}
	}