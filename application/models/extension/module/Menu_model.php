<?php 
	class Menu_model extends CI_Model {

		public function get_menu_children($menu_group_id) {

			$menu_child_data = $this->cache->get('get.menu.children.menu_id.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$menu_group_id);
			if ( !$menu_child_data ) {
				$sql = "SELECT mg.*, gd.* FROM " . DB_PREFIX . "menu_group mg LEFT JOIN " . DB_PREFIX . "menu_group_description gd ON (mg.menu_group_id = gd.menu_group_id) WHERE mg.menu_id = '" . (int)$menu_group_id . "' ORDER BY mg.sort ASC";
				$query = $this->db->query($sql);
				$menu_child_data = $query->rows;

				$this->cache->set('get.menu.children.menu_id.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$menu_group_id, $menu_child_data);
			}
			return $menu_child_data;
		} 
	}
 ?>
