<?php
class Module_model extends CI_Model {
	public function getModule($module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$module_id . "'");
		$result = $query->row_array();
		if ($result) {
		    if ( is_serialized( $result['setting'] ) )
    		    return unserialize($result['setting']);
		    else
		        return json_decode($result['setting'], true);
		} else {
			return array();	
		}
	}		
}