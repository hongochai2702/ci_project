<?php
class Reviewblog_model extends CI_Model {
	public function addReviewblog($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "reviewblog SET author = '" . $this->db->escape($data['author']) . "', blog_id = '" . (int)$data['blog_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "'");

		$reviewblog_id = $this->db->insert_id();

		$this->cache->delete('blog');

		return $reviewblog_id;
	}

	public function editReviewblog($reviewblog_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "reviewblog SET author = '" . $this->db->escape($data['author']) . "', blog_id = '" . (int)$data['blog_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_modified = NOW() WHERE reviewblog_id = '" . (int)$reviewblog_id . "'");

		$this->cache->delete('blog');
	}

	public function deleteReviewblog($reviewblog_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "reviewblog WHERE reviewblog_id = '" . (int)$reviewblog_id . "'");

		$this->cache->delete('blog');
	}

	public function getReviewblog($reviewblog_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT pd.name FROM " . DB_PREFIX . "blog_description pd WHERE pd.blog_id = r.blog_id AND pd.language_id = '" . (int)$this->configs->get('config_language_id') . "') AS blog FROM " . DB_PREFIX . "reviewblog r WHERE r.reviewblog_id = '" . (int)$reviewblog_id . "'");

		return $query->first_row('array');
	}

	public function getReviewblogs($data = array()) {
		$sql = "SELECT r.reviewblog_id, pd.name, r.author, r.rating, r.status, r.date_added FROM " . DB_PREFIX . "reviewblog r LEFT JOIN " . DB_PREFIX . "blog_description pd ON (r.blog_id = pd.blog_id) WHERE pd.language_id = '" . (int)$this->configs->get('config_language_id') . "'";

		if (!empty($data['filter_blog'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_blog']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$sort_data = array(
			'pd.name',
			'r.author',
			'r.rating',
			'r.status',
			'r.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.date_added";
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

	public function getTotalReviewblogs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "reviewblog r LEFT JOIN " . DB_PREFIX . "blog_description pd ON (r.blog_id = pd.blog_id) WHERE pd.language_id = '" . (int)$this->configs->get('config_language_id') . "'";

		if (!empty($data['filter_blog'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_blog']) . "%'";
		}

		if (!empty($data['filter_author'])) {
			$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row('total');;
	}

	public function getTotalReviewblogsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "reviewblog WHERE status = '0'");

		return $query->row('total');;
	}
}