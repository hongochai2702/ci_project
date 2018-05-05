<?php
class Layout_model extends CI_Model {
	public function __Construct(){
		parent::__Construct();
	}
	public function getLayout($routing) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_routing WHERE '" . $this->db->escape_str($routing) . "' LIKE routing AND store_id = " . (int)$this->configs->get('config_store_id') . " ORDER BY routing DESC LIMIT 1");
		if ($query->result_array()) {
			return (int)$query->row('layout_id');
		} else {
			return 0;
		}
	}
	
	public function getLayoutModules($layout_id, $position) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' AND position = '" . $this->db->escape_str($position) . "' ORDER BY sort_order");

		
		
		return $query->result_array();
	}
}