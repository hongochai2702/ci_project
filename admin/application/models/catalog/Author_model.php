<?php
class Author_model extends CI_Model {
	public function addAuthor($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "author SET name = '" . $this->db->escape_str($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$author_id = $this->db->insert_id();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "author SET image = '" . $this->db->escape_str($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		if (isset($data['author_store'])) {
			foreach ($data['author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
				
		// SEO URL
		if (isset($data['author_seo_url'])) {
			foreach ($data['author_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape_str($keyword) . "'");
					}
				}
			}
		}
		
		$this->cache->delete('author');

		return $author_id;
	}

	public function editAuthor($author_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "author SET name = '" . $this->db->escape_str($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "author SET image = '" . $this->db->escape_str($data['image']) . "' WHERE author_id = '" . (int)$author_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "author_to_store WHERE author_id = '" . (int)$author_id . "'");

		if (isset($data['author_store'])) {
			foreach ($data['author_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "author_to_store SET author_id = '" . (int)$author_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'author_id=" . (int)$author_id . "'");

		if (isset($data['author_seo_url'])) {
			foreach ($data['author_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'author_id=" . (int)$author_id . "', keyword = '" . $this->db->escape_str($keyword) . "'");
					}
				}
			}
		}

		$this->cache->delete('author');
	}

	public function deleteAuthor($author_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "author` WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "author_to_store` WHERE author_id = '" . (int)$author_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'author_id=" . (int)$author_id . "'");

		$this->cache->delete('author');
	}

	public function getAuthor($author_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "author WHERE author_id = '" . (int)$author_id . "'");

		return $query->first_row('array');
	}

	public function getAuthors($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "author";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape_str($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
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

		return $query->rows;
	}

	public function getAuthorStores($author_id) {
		$author_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "author_to_store WHERE author_id = '" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$author_store_data[] = $result['store_id'];
		}

		return $author_store_data;
	}
	
	public function getAuthorSeoUrls($author_id) {
		$author_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'author_id=" . (int)$author_id . "'");

		foreach ($query->rows as $result) {
			$author_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $author_seo_url_data;
	}
	
	public function getTotalAuthors() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "author");

		return $query->row['total'];
	}
}
