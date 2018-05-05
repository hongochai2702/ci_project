<?php
class Currency extends MX_Controller {
	public function index() {
		$this->lang->load('common/currency');

		$data['action'] = $this->url->link('common/currency/currency', '', $this->input->server('HTTPS'));

		$data['code'] = $this->session->userdata('currency');

		$this->load->model('localisation/currency_model');

		$data['currencies'] = array();

		$results = $this->currency_model->getCurrencies();

		foreach ($results as $result) {
			if ($result['status']) {
				$data['currencies'][] = array(
					'title'        => $result['title'],
					'code'         => $result['code'],
					'symbol_left'  => $result['symbol_left'],
					'symbol_right' => $result['symbol_right']
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

			$data['redirect'] = $this->url->link($routing, $url, $this->input->server['HTTPS']);
		}

		return $this->load->view('default/common/currency', $data,true);
	}

	public function currency() {
		if (($this->input->post['code'])) {
			$this->session->set_userdata('currency',$this->input->post('code'));
			$this->session->unset_userdata('shipping_method');
			$this->session->unset_userdata('shipping_methods');

		}
		
		if ($this->input->post('redirect')) {
			redirect($this->input->post('redirect'));
		} else {
		//	redirect($this->url->link('common/home'));
		}
	}
}