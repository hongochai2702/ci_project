<?php

	class Video extends MX_Controller {

		public function index($setting = array()) {
			static $module = 0;
			$this->load->model('design/video_model','model_design_video');
			$this->load->model('tool/image_model','model_tool_image');

			$data['videos'] = array();

			$results = $this->model_design_video->getVideo($setting['video_id']);

			if( $this->input->server('HTTPS') && ( 
			 	($this->input->server('HTTPS') == 'on') || ($this->input->server('HTTPS') == '1'))) 
			{
				$http_image = URL_HOME . 'image/';
			} else {
				$http_image = URL_HOME . 'image/';
			}
			
			foreach ($results as $result) {
				$result['image'] = str_replace($http_image, '', $result['image']);
				if (is_file(DIR_IMAGE . $result['image'])) {
					if ( $result['sort_order'] == 0 ) {
						$data['videos']['featured'] = array(
							'id' => $result['video_image_id'],
							'title' => $result['title'],
							'order' => $result['sort_order'],
							'link'  => $result['link'],
							// 'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
							'image' => URL_HOME . 'image/' . $result['image']
						);
					} else {

						$data['videos']['list_videos'][] = array(
							'id' => $result['video_image_id'],
							'title' => $result['title'],
							'order' => $result['sort_order'],
							'link'  => $result['link'],
							// 'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
							'image' => URL_HOME . 'image/' . $result['image']
						);
					}
					
				}
			}

			// Mặc định video đầu tiên.
			if( !empty($data['videos']['featured']) ) {
				$featured = array_shift($results);
				$data['videos']['featured'][] = array(
					'id' 	=> $featured['video_image_id'],
					'title' => $featured['title'],
					'order' => $featured['sort_order'],
					'link'  => $featured['link'],
					'image' => URL_HOME . 'image/' . $result['image']
					// 'image' => $this->model_tool_image->resize($featured['image'], $setting['width'], $setting['height'])
				);
			}
			
			$data['module'] = $module++;
			
			return $this->load->view('default/extension/module/video_gallery_view', $data,true);
		}
	}