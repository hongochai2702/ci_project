<?php
class Upload_model extends CI_Model {
	public function addUpload($name, $filename) {
		$code = sha1(uniqid(mt_rand(), true));

		$this->db->query("INSERT INTO `" . DB_PREFIX . "upload` SET `name` = '" . $this->db->escape_str($name) . "', `filename` = '" . $this->db->escape_str($filename) . "', `code` = '" . $this->db->escape_str($code) . "', `date_added` = NOW()");

		return $code;
	}

	public function getUploadByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "upload` WHERE code = '" . $this->db->escape_str($code) . "'");

		return $query->row;
	}
}