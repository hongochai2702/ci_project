<?php
class Video_model extends CI_Model {
	public function getVideo($video_id) {
		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_image bi LEFT JOIN " . DB_PREFIX . "video_image_description bid ON (bi.video_image_id  = bid.video_image_id) WHERE bi.video_id = '" . (int)$video_id . "' AND bid.language_id = '" . (int)$this->configs->get('config_language_id') . "' ORDER BY bi.sort_order ASC");
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_image WHERE video_id = '" . (int)$video_id . "' ORDER BY sort_order ASC");

		return $query->result_array();
	}
}