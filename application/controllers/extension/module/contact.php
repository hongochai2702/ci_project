<?php
class Contact extends MX_Controller {
	private $error = array();
	public function __Construct(){
		parent::__Construct();
	}

	public function index($setting = array()) {
		$this->load->language('extension/module/contact');
		$data['text_contact'] = $this->lang->line('text_contact');
		$data['entry_name'] = $this->lang->line('entry_name');
		$data['entry_email'] = $this->lang->line('entry_email');
		$data['entry_enquiry'] = $this->lang->line('entry_enquiry');
		$data['entry_phone'] = $this->lang->line('entry_phone');
		$data['button_submit'] = $this->lang->line('button_submit');
		$data['text_message'] = $this->lang->line('text_message');
		$data['entry_message'] = $this->lang->line('entry_message');
		if (($this->input->server('REQUEST_METHOD') == 'POST')) {
			// $this->load->library('email');
			// $config = array(
			//     'protocol'  => 'smtp',
			//     'smtp_host' => $this->configs->get('config_mail_smtp_hostname'), /// hossting
			//     'smtp_port' => 465,
			//     'smtp_user' => $this->configs->get('config_mail_smtp_username'),
			//     'smtp_pass' => html_entity_decode($this->configs->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8'),
			//     'mailtype'  => 'html',
			//     'charset'   => 'utf-8'
			// );
			// $this->email->initialize($config);
			// $this->email->set_mailtype("html");
			// $this->email->set_newline("\r\n");
			// $htmlContent .= '<p>This is send mail demo in website.</p>';
			// $this->email->to($this->configs->get('config_email'));
			// $this->email->from($this->configs->get('config_email'),'MyWebsite');
			// $this->email->subject('How to send email via SMTP server in CodeIgniter');
			// $this->email->message($htmlContent);
			// $this->email->send();
			// echo json_encode($data['success'] = true);
			echo json_encode("dsfsd");
		}

		// if (isset($this->error['name'])) {
		// 	$data['error_name'] = $this->error['name'];
		// } else {
		// 	$data['error_name'] = 'Input fill';
		// }

		// if ($this->input->post('name')) {
		// 	$data['name'] = $this->input->post('name');
		// } else {
		// 	$data['name'] = 'Input fill';
		// }

		// if ($this->input->post('email')) {
		// 	$data['email'] = $this->input->post('email');
		// } else {
		// 	$data['email'] = 'Input fill';
		// }

		// if ($this->input->post('enquiry')) {
		// 	$data['enquiry'] = $this->input->post('enquiry');
		// } else {
		// 	$data['enquiry'] = '';
		// }
		

		// $data = array();
		$data['action'] = $this->url->link('extension/module/contact', '', true);
		return $this->load->view('default/extension/module/contact', $data,true);
		
	}
	protected function validate() {
		if ((strlen($this->input->post('name')) < 3) || (strlen($this->input->post('name')) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((strlen($this->input->post('enquiry')) < 10) || (strlen($this->input->post('enquiry')) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		return !$this->error;
	}
}
