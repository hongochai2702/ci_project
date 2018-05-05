<?php
class Extension_model extends CI_Model {
	function getExtensions($type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = " . $this->db->escape($type) . "");

		return $query->first_row('array');
	}
}