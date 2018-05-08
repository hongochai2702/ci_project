<?php 
	class Category_model extends CI_Model {
		
		public function getCategoriesAll() {
			
			$this->db->cache_on();
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->configs->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->configs->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
				$categories_data = $query->result_array();
				$this->cache->set('product.all_categories.' . (int)$this->configs->get('config_language_id') . '.' . (int)$this->configs->get('config_store_id') . '.' . $this->configs->get('config_customer_group_id'), $categories_data);
			
			

			return $categories_data;
		}
}