<?php
class Online_model extends CI_Model {
	public function addOnline($ip, $customer_id, $url, $referer) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_online` WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

		$this->db->query("REPLACE INTO `" . DB_PREFIX . "customer_online` SET `ip` = '" . $this->db->escape_str($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . $this->db->escape_str($url) . "', `referer` = '" . $this->db->escape_str($referer) . "', `date_added` = '" . $this->db->escape_str(date('Y-m-d H:i:s')) . "'");
	}
}
