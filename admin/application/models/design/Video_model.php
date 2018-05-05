<?php
class Video_model extends CI_Model {
	public function addVideo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "video SET name = '" . $this->db->escape_str($data['name']) . "', status = '" . (int)$data['status'] . "'");

		$video_id = $this->db->insert_id();

		if (isset($data['video_image'])) {
			foreach ($data['video_image'] as $language_id => $value) {
				foreach ($value as $video_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "video_image SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape_str($video_image['title']) . "', link = '" .  $this->db->escape_str($video_image['link']) . "', image = '" .  $this->db->escape_str($video_image['image']) . "', sort_order = '" .  (int)$video_image['sort_order'] . "'");
				}
			}
		}

		return $video_id;
	}

	public function editVideo($video_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "video SET name = '" . $this->db->escape_str($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE video_id = '" . (int)$video_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "video_image WHERE video_id = '" . (int)$video_id . "'");

		if (isset($data['video_image'])) {
			foreach ($data['video_image'] as $language_id => $value) {
				foreach ($value as $video_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "video_image SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape_str($video_image['title']) . "', link = '" .  $this->db->escape_str($video_image['link']) . "', image = '" .  $this->db->escape_str($video_image['image']) . "', sort_order = '" . (int)$video_image['sort_order'] . "'");
				}
			}
		}
	}

	public function deleteVideo($video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_image WHERE video_id = '" . (int)$video_id . "'");
	}

	public function getVideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");

		return $query->row_array();
	}

	public function getVideos($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "video";

		$sort_data = array(
			'name',
			'status'
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

	public function getVideoImages($video_id) {
		$video_image_data = array();

		$video_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_image WHERE video_id = '" . (int)$video_id . "' ORDER BY sort_order ASC");

		foreach ($video_image_query->result_array() as $video_image) {
			$video_image_data[$video_image['language_id']][] = array(
				'title'      => $video_image['title'],
				'link'       => $video_image['link'],
				'image'      => $video_image['image'],
				'sort_order' => $video_image['sort_order']
			);
		}

		return $video_image_data;
	}

	public function getTotalVideos() {
		return $this->db->count_all('video');
	}
}
