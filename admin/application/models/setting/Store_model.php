<?php
class Store_model extends CI_Model {
	public function addStore($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "store SET name = '" . $this->db->escape_str($data['config_name']) . "', `url` = '" . $this->db->escape_str($data['config_url']) . "', `ssl` = '" . $this->db->escape_str($data['config_ssl']) . "'");

		$store_id = $this->db->insert_id();

		// Layout Routing
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_routing WHERE store_id = '0'");

		foreach ($query->rows as $layout_routing) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout_routing SET layout_id = '" . (int)$layout_routing['layout_id'] . "', routing = '" . $this->db->escape_str($layout_routing['routing']) . "', store_id = '" . (int)$store_id . "'");
		}

		$this->cache->delete('store');

		return $store_id;
	}

	public function editStore($store_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "store SET name = '" . $this->db->escape_str($data['config_name']) . "', `url` = '" . $this->db->escape_str($data['config_url']) . "', `ssl` = '" . $this->db->escape_str($data['config_ssl']) . "' WHERE store_id = '" . (int)$store_id . "'");

		$this->cache->delete('store');
	}

	public function deleteStore($store_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_routing WHERE store_id = '" . (int)$store_id . "'");

		$this->cache->delete('store');
	}

	public function getStore($store_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");

		return $query->row_array();
	}

	public function getStores($data = array()) {
		// $store_data = $this->cache->get('store');

		// if (!$store_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");

			return $query->result_array('array');

			// $this->cache->set('store', $store_data);
		// }

		return $store_data;
	}

	public function getTotalStores() {
		return $this->db->count_all('store');
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "store");

		// $result = $query->row_array();
		// return $result['total'];
	}

	public function getTotalStoresByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_layout_id' AND `value` = '" . (int)$layout_id . "' AND store_id != '0'");
		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByLanguage($language) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_language' AND `value` = '" . $this->db->escape_str($language) . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByCurrency($currency) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_currency' AND `value` = '" . $this->db->escape_str($currency) . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_country_id' AND `value` = '" . (int)$country_id . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_zone_id' AND `value` = '" . (int)$zone_id . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByCustomerGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_customer_group_id' AND `value` = '" . (int)$customer_group_id . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}

	public function getTotalStoresByInformationId($information_id) {
		$account_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_account_id' AND `value` = '" . (int)$information_id . "' AND store_id != '0'");

		$checkout_query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_checkout_id' AND `value` = '" . (int)$information_id . "' AND store_id != '0'");

		$result_account = $account_query->row_array();
		$result_checkout = $checkout_query->row_array();
		return ($result_account['total'] + $result_checkout['total']);
	}

	public function getTotalStoresByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "setting WHERE `key` = 'config_order_status_id' AND `value` = '" . (int)$order_status_id . "' AND store_id != '0'");

		$result = $query->row_array();
		return $result['total'];
	}
}