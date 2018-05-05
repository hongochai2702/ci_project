<?php
class Language extends MX_Controller {
	public function index() {
		$this->lang->load('common/language');
		$data['action'] = $this->url->link('common/language/language', '', $this->input->server('HTTPS'));

		$data['code'] = $this->session->userdata('language');

		$this->load->model('localisation/language_model');

		$data['languages'] = array();

		$results = $this->language_model->getLanguages();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['languages'][] = array(
					'name' => $result['name'],
					'code' => $result['code']
				);
			}
		}

		if (!($this->input->get('routing'))) {
			$data['redirect'] = $this->url->link('common/home');
		} else {
			$url_data = $this->input->get();
			
			$this->session->unset_userdata($url_data['_routing_']);

			$routing = $url_data['routing'];

			$this->session->unset_userdata($url_data['routing']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['redirect'] = $this->url->link($routing, $url, $this->input->server('HTTPS'));
		}

		return $this->load->view('default/common/language', $data,true);
	}

	public function language() {
		if ($this->input->post('code')) {
			$this->session->set_userdata('language',$this->input->post('code'));
		}

		// if (($this->input->post('redirect'))) {
		// 	redirect($this->input->post('redirect'));
		// } else {
		// 	redirect($this->url->link('default/common/home'));
		// }
	}
}