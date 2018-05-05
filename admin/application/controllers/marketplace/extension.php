<?php
class Extension extends MX_Controller {
	private $error = array();

	public function index() {

		$data = array();
		$this->lang->load('marketplace/extension');
		$data = array_merge($data, $this->lang->loadAll());

		$data['heading_title'] = $this->lang->line('heading_title');
		$this->document->setTitle($this->lang->line('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->userdata('user_token'), true)
		);

		$data['user_token'] = $this->session->userdata('user_token');

		if ($this->input->get('type')) {
			$data['type'] = $this->input->get('type');
		} else {
			$data['type'] = '';
		}
		
		$data['categories'] = array();
		
		// $files = glob(DIR_APPLICATION . 'controllers/extension/*.php');
		$files = glob(DIR_APPLICATION . 'controllers/extension/extension/*.php');
		foreach ($files as $file) {
			$extension = basename($file, '.php');

			// Compatibility code for old extension folders
			$lang_module[$extension] = $this->lang->load('extension/' . $extension, false, true);

			$data = array_merge($data, $lang_module);
			// if ($this->user->hasPermission('access', 'module/' . $extension)) {
			if ($this->user->hasPermission('access', 'extension/' . $extension)) {
				$files = glob(DIR_APPLICATION . 'controllers/extension/module/*.php', GLOB_BRACE);
		
				$data['categories'][] = array(
					'code' => $extension,
					// 'text' => $this->lang->line('extension')->get('heading_title') . ' (' . count($files) .')',
					'text' => $lang_module[$extension]['heading_title'] . ' (' . count($files) .')',
					'href' => $this->url->link('extension/extension/' . $extension, 'user_token=' . $this->session->userdata('user_token'), true)
				);
			}			
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->view('marketplace/extension', $data);
	}
}