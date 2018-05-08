<?php
class ModelSettingStore extends CI_Model {
	public function getStores($data = array()) {
		$store_data = $this->cache->get('store');

		if (!$store_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");

			$store_data = $query->result_array();

			$this->cache->set('store', $store_data);
		}

		return $store_data;
	}
}