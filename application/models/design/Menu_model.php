<?php
class Menu_model extends CI_Model {

	/////////////////// getMenu()
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "' AND status='1'");
		return $query->first_row('array');
	}
	public function get_menu_children($menu_group_id) {

				$sql = "SELECT mg.*, gd.* FROM " . DB_PREFIX . "menu_group mg LEFT JOIN " . DB_PREFIX . "menu_group_description gd ON (mg.menu_group_id = gd.menu_group_id) WHERE mg.menu_id = '" . (int)$menu_group_id . "' ORDER BY mg.sort ASC";
				$query = $this->db->query($sql);
				$menu_child_data = $query->result_array();

			
			
			return $menu_child_data;
		} 

}