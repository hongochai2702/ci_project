<?php
class ModelDesignSay extends Model {
	public function getSay($say_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "say b LEFT JOIN " . DB_PREFIX . "say_image bi ON (b.say_id = bi.say_id) WHERE b.say_id = '" . (int)$say_id . "' AND b.status = '1' AND bi.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
		return $query->rows;
	}
}
