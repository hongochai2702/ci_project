<?php
class Logout extends MX_Controller {
	public function index() {

		$this->user->logout();
		$this->session->unset_userdata('user_token');

		redirect(base_url('common/login'));
	}
}