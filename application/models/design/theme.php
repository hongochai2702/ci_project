<?php
class ModelDesignTheme extends Model {
	public function getTheme($routing, $theme) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "theme WHERE store_id = '" . (int)$this->config->get('config_store_id') . "' AND theme = '" . $this->db->escape_str($theme) . "' AND routing = '" . $this->db->escape_str($routing) . "'");

		return $query->row;
	}
}