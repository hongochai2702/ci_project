<?php
class Login extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('user');
	}
	private $error = array();
	private function token($length = 32) {
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	$token = '';
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	return $token;
	}
	public function index() {
		$this->lang->load('common/login');
		$data['text_login'] = $this->lang->line('text_login');
		$data['text_forgotten'] = $this->lang->line('text_forgotten');
		$data['entry_username'] = $this->lang->line('entry_username');
		$data['entry_password'] = $this->lang->line('entry_password');
		$data['button_login'] = $this->lang->line('button_login');

		$this->document->setTitle($this->lang->line('heading_title'));

		if ($this->user->isLogged() && ($this->input->get('user_token')) && ($this->input->get('user_token') == $this->session->userdata('user_token'))) {
			redirect($this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true));
		}

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			$this->session->set_userdata('user_token', $this->token(32));
			
			if (($this->input->post('redirect')) && (strpos($this->input->post('redirect'), HTTP_SERVER) === 0 || strpos($this->input->post('redirect'), HTTPS_SERVER) === 0)) {
				redirect($this->input->post('redirect') . '&user_token=' . $this->session->userdata('user_token'));
			} else {
				redirect($this->url->link('common/dashboard', 'user_token=' . $this->session->userdata('user_token'), true));
			}
		}

		if ((($this->session->userdata('user_token')) && !($this->input->get('user_token'))) || ((($this->input->get('user_token')) && (($this->session->userdata('user_token')) && ($this->input->get('user_token') != $this->session->userdata('user_token')))))) {
			$this->error['warning'] = $this->lang->line('error_token');
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata($this->session->userdata('success'));
		} else {
			$data['success'] = '';
		}

		$data['action'] = $this->url->link('common/login', '', true);

		if ($this->input->post('username')) {
			$data['username'] = $this->input->post('username');
		} else {
			$data['username'] = '';
		}

		if ($this->input->post('password')) {
			$data['password'] = $this->input->post('password');
		} else {
			$data['password'] = '';
		}

		if ($this->input->get('routing')) {
			$routing = $this->input->get('routing');

			$this->session->unset_userdata($this->input->get('routing'));
			$this->session->unset_userdata($this->input->get('user_token'));

			$url = '';

			if ($this->input->get()) {
				$url .= http_build_query($this->request->get());
			}

			$data['redirect'] = $this->url->link($routing, $url, true);
		} else {
			$data['redirect'] = '';
		}

		if ($this->configs->get('config_password')) {
			$data['forgotten'] = $this->url->link('common/forgotten', '', true);
		} else {
			$data['forgotten'] = '';
		}


		 $this->load->view('common/login', $data);
	}

	protected function validate() {
		if (!($this->input->post('username')) || !($this->input->post('password')) || !$this->user->login($this->input->post('username'), $this->input->post('password'))) {
			$this->error['warning'] = $this->lang->line('error_login');
		}

		return !$this->error;
	}
}