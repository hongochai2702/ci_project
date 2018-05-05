<?php
class Search extends MX_Controller {
	public function index() {
		$this->lang->load('common/search');

		$data['text_search'] = $this->lang->line('text_search');

		if ($this->input->get('search')) {
			$data['search'] = $this->input->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('default/common/search', $data,true);
	}
}