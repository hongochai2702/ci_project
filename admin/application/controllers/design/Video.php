<?php
class Video extends MX_Controller {
	private $error = array();

	public function index() {
		$this->lang->load('design/video');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('design/video_model','model_design_video');

		$this->getList();
	}

	public function add() {
		$this->lang->load('design/video');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('design/video_model','model_design_video');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_video->addVideo($this->input->post());

			$success_message = $this->session->userdata('success');
			$success_message = $this->lang->line('text_success');
			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect($this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->lang->load('design/video');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('design/video_model','model_design_video');

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validateForm()) {
			$this->model_design_video->editVideo($this->input->get('video_id'), $this->input->post());

			$success_message = $this->session->userdata('success');
			$success_message = $this->lang->line('text_success');


			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect($this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->lang->load('design/video');

		$this->document->setTitle($this->lang->line('heading_title'));

		$this->load->model('design/video_model','model_design_video');

		if ($this->input->post('selected') && $this->validateDelete()) {
			foreach ($this->input->post('selected') as $video_id) {
				$this->model_design_video->deleteVideo($video_id);
			}

			$success_message = $this->session->userdata('success');
			$success_message = $this->lang->line('text_success');


			$url = '';

			if ($this->input->get('sort')) {
				$url .= '&sort=' . $this->input->get('sort');
			}

			if ($this->input->get('order')) {
				$url .= '&order=' . $this->input->get('order');
			}

			if ($this->input->get('page')) {
				$url .= '&page=' . $this->input->get('page');
			}

			$this->response->redirect($this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if ($this->input->get('sort')) {
			$sort = $this->input->get('sort');
		} else {
			$sort = 'name';
		}

		if ($this->input->get('order')) {
			$order = $this->input->get('order');
		} else {
			$order = 'ASC';
		}

		if ($this->input->get('page')) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		$data['add'] = $this->url->link('design/video/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		$data['delete'] = $this->url->link('design/video/delete', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		$data['videos'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->configs->get('config_limit_admin'),
			'limit' => $this->configs->get('config_limit_admin')
		);

		$video_total = $this->model_design_video->getTotalVideos();

		$results = $this->model_design_video->getVideos($filter_data);

		foreach ($results as $result) {
			$data['videos'][] = array(
				'video_id' => $result['video_id'],
				'name'      => $result['name'],
				'status'    => ($result['status'] ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled')),
				'edit'      => $this->url->link('design/video/edit', 'user_token=' . $this->session->userdata('user_token') . '&video_id=' . $result['video_id'] . $url, true)
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');

			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}

		if ($this->input->post('selected')) {
			$data['selected'] = (array)$this->input->post('selected');
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['sort_name'] = $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . '&sort=status' . $url, true);

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		$pagination = new Pagination();
		$pagination->total = $video_total;
		$pagination->page = $page;
		$pagination->limit = $this->configs->get('config_limit_admin');
		$pagination->url = $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->lang->line('text_pagination'), ($video_total) ? (($page - 1) * $this->configs->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->configs->get('config_limit_admin')) > ($video_total - $this->configs->get('config_limit_admin'))) ? $video_total : ((($page - 1) * $this->configs->get('config_limit_admin')) + $this->configs->get('config_limit_admin')), $video_total, ceil($video_total / $this->configs->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data = array_merge($data, $this->lang->loadAll());
		$this->load->view('design/video_list', $data);
	}

	protected function getForm() {
		$data = array();
		$data = array_merge($data, $this->lang->loadAll());
		$data['text_form'] = !$this->input->get('video_id') ? $this->lang->line('text_add') : $this->lang->line('text_edit');
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

		if (isset($this->error['video_image'])) {
			$data['error_video_image'] = $this->error['video_image'];
		} else {
			$data['error_video_image'] = array();
		}

		$url = '';

		if ($this->input->get('sort')) {
			$url .= '&sort=' . $this->input->get('sort');
		}

		if ($this->input->get('order')) {
			$url .= '&order=' . $this->input->get('order');
		}

		if ($this->input->get('page')) {
			$url .= '&page=' . $this->input->get('page');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true)
		);

		if (!$this->input->get('video_id')) {
			$data['action'] = $this->url->link('design/video/add', 'user_token=' . $this->session->userdata('user_token') . $url, true);
		} else {
			$data['action'] = $this->url->link('design/video/edit', 'user_token=' . $this->session->userdata('user_token') . '&video_id=' . $this->input->get('video_id') . $url, true);
		}

		$data['cancel'] = $this->url->link('design/video', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		if ($this->input->get('video_id') && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$video_info = $this->model_design_video->getVideo($this->input->get('video_id'));
		}

		$data['user_token'] = $this->session->userdata('user_token');

		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($video_info)) {
			$data['name'] = $video_info['name'];
		} else {
			$data['name'] = '';
		}

		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($video_info)) {
			$data['status'] = $video_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language_model','model_localisation_language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image_model','model_tool_image');

		if ($this->input->post('video_image')) {
			$video_images = $this->input->post('video_image');
		} elseif ($this->input->get('video_id')) {
			$video_images = $this->model_design_video->getVideoImages($this->input->get('video_id'));
		} else {
			$video_images = array();
		}
		// var_dump($video_images);
		$data['video_images'] = array();

		foreach ($video_images as $key => $value) {
			foreach ($value as $video_image) {
				if (is_file(DIR_IMAGE . $video_image['image'])) {
					$image = $video_image['image'];
					$thumb = $video_image['image'];
				} else {
					$image = '';
					$thumb = 'no_image.png';
				}

				$data['video_images'][$key][] = array(
					'title'      => $video_image['title'],
					'link'       => $video_image['link'],
					'image'      => $image,
					'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
					'sort_order' => $video_image['sort_order']
				);
			}
		}
		// var_dump($data['video_images']);

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
			
		$this->load->view('design/video_form', $data);
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/video')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		if ((utf8_strlen($this->input->post('name')) < 3) || (utf8_strlen($this->input->post('name')) > 64)) {
			$this->error['name'] = $this->lang->line('error_name');
		}

		if ($this->input->post('video_image')) {
			foreach ($this->input->post('video_image') as $language_id => $value) {
				foreach ($value as $video_image_id => $video_image) {
					if ((utf8_strlen($video_image['title']) < 2) || (utf8_strlen($video_image['title']) > 64)) {
						$this->error['video_image'][$language_id][$video_image_id] = $this->lang->line('error_title');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/video')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}

		return !$this->error;
	}
}