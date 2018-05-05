<?php
class Extension_model extends CI_Model {
	public function getInstalled($type) {
		$extension_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape_str($type) . "' ORDER BY code");
		$result_types = $query->result_array();
		foreach ($result_types as $result) {
			$extension_data[] = $result['code'];
		}
		
		return $extension_data;
	}

	public function install($type, $code) {
		$extensions = $this->getInstalled($type);

		if (!in_array($code, $extensions)) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "extension SET `type` = '" . $this->db->escape_str($type) . "', `code` = '" . $this->db->escape_str($code) . "'");
		}
	}

	public function uninstall($type, $code) {
		if (strpos($code, 'journal2_') === 0) return;
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape_str($type) . "' AND `code` = '" . $this->db->escape_str($code) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `code` = '" . $this->db->escape_str($code) . "'");
	}
}
