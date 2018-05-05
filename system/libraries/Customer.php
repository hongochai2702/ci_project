<?php
class CI_Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $customer_group_id;
	private $address_id;

	public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->database();
		$this->CI->load->library("Registry");
		//$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session');

		$this->config = $this->CI->registry->get('config');
		$this->db = $this->CI->registry->get('db');
		$this->request = $this->CI->registry->get('request');
		$this->session = $this->CI->registry->get('session');

		if (isset($this->CI->session->userdata['customer_id'])) {
			$customer_query = $this->CI->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->CI->session->userdata['customer_id'] . "' AND status = '1'");

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->address_id = $customer_query->row['address_id'];

				$this->CI->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(($this->CI->session->userdata('cart')) ? serialize($this->CI->session->userdata('cart')) : '') . "', wishlist = '" . $this->db->escape(($this->CI->session->userdata('wishlist')) ? serialize($this->CI->session->userdata('wishlist')) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

				$query = $this->CI->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->CI->session->userdata('customer_id') . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->CI->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->CI->session->userdata('customer_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			$customer_query = $this->CI->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->CI->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($customer_query->num_rows) {
			$this->CI->session->set_userdata('customer_id',$customer_query->row('customer_id'));

			if ($customer_query->row['cart'] && is_string($customer_query->row('cart'))) {
				$cart = unserialize($customer_query->row['cart']);

				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $this->CI->session->userdata('cart'))) {
						$this->CI->session->userdata['cart'][$key] = $value;
					} else {
						$this->CI->session->userdata('cart')[$key] += $value;
					}
				}
			}

			if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
				if (!$this->CI->session->userdata('wishlist')) {
					$this->CI->session->set_userdata('wishlist',array());
				}

				$wishlist = unserialize($customer_query->row('wishlist'));

				foreach ($wishlist as $product_id) {
					if (!in_array($product_id, $this->CI->session->userdata('wishlist'))) {
						$this->CI->session->userdata('wishlist')[] = $product_id;
					}
				}
			}

			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->address_id = $customer_query->row['address_id'];

			$this->CI->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		$this->CI->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(($this->CI->session->userdata('cart')) ? serialize($this->CI->session->userdata('cart')) : '') . "', wishlist = '" . $this->db->escape(($this->CI->session->userdata('wishlist')) ? serialize($this->CI->session->userdata('wishlist')) : '') . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

		$this->ci->seSSion->unset_userdata('customer_id');

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getFax() {
		return $this->fax;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->CI->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}

	public function getRewardPoints() {
		$query = $this->CI->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}
}