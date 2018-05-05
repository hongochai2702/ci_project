<?php
class Location_model extends CI_Model {
	public function addLocation($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "location SET name = '" . $this->db->escape_str($data['name']) . "', address = '" . $this->db->escape_str($data['address']) . "', geocode = '" . $this->db->escape_str($data['geocode']) . "', telephone = '" . $this->db->escape_str($data['telephone']) . "', fax = '" . $this->db->escape_str($data['fax']) . "', image = '" . $this->db->escape_str($data['image']) . "', open = '" . $this->db->escape_str($data['open']) . "', comment = '" . $this->db->escape_str($data['comment']) . "'");
	
		return $this->db->insert_id();
	}

	public function editLocation($location_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "location SET name = '" . $this->db->escape_str($data['name']) . "', address = '" . $this->db->escape_str($data['address']) . "', geocode = '" . $this->db->escape_str($data['geocode']) . "', telephone = '" . $this->db->escape_str($data['telephone']) . "', fax = '" . $this->db->escape_str($data['fax']) . "', image = '" . $this->db->escape_str($data['image']) . "', open = '" . $this->db->escape_str($data['open']) . "', comment = '" . $this->db->escape_str($data['comment']) . "' WHERE location_id = '" . (int)$location_id . "'");
	}

	public function deleteLocation($location_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "location WHERE location_id = " . (int)$location_id);
	}

	public function getLocation($location_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

		return $query->row_array();
	}

	public function getLocations($data = array()) {
		$sql = "SELECT location_id, name, address FROM " . DB_PREFIX . "location";

		$sort_data = array(
			'name',
			'address',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function getTotalLocations() {
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "location");

		// return $query->row['total'];
		return $this->db->count_all('location');
	}
}
