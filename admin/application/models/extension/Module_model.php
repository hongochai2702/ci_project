<?php
class Module_model extends CI_Model {
	public function addModule($code, $data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape_str($data['name']) . "', `code` = '" . $this->db->escape_str($code) . "', `setting` = '" . $this->db->escape_str(json_encode($data)) . "'");
	}
	
	public function editModule($module_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape_str($data['name']) . "', `setting` = '" . $this->db->escape_str(json_encode($data)) . "' WHERE `module_id` = '" . (int)$module_id . "'");
	}

	public function deleteModule($module_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . (int)$module_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '%." . (int)$module_id . "'");
	}
		
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . (int)$module_id . "'");
		$result = $query->row_array();
		if ( $result ) {
			if ( is_serialized($result['setting']) )
				return unserialize($result['setting']);
			else 
				return json_decode($result['setting'], true);
			
		} else {
			return array();
		}
	}
	
	public function getModules() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` ORDER BY `code`");

		return $query->result_array();
	}	
		
	public function getModulesByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape_str($code) . "' ORDER BY `name`");

		return $query->result_array();
	}	
	
	public function deleteModulesByCode($code) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape_str($code) . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "layout_module` WHERE `code` LIKE '" . $this->db->escape_str($code) . "' OR `code` LIKE '" . $this->db->escape_str($code . '.%') . "'");
	}	
}