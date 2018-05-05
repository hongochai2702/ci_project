<?php
class CategoryBlog_model extends CI_Model {
	public function addcategoryblog($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$categoryblog_id = $this->db->insert_id();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "categoryblog SET image = '" . $this->db->this->db->escape_str($data['image']) . "' WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		}

		foreach ($data['categoryblog_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_description SET categoryblog_id = '" . (int)$categoryblog_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->this->db->escape_str($value['name']) . "', description = '" . $this->db->this->db->escape_str($value['description']) . "', meta_title = '" . $this->db->this->db->escape_str($value['meta_title']) . "', meta_description = '" . $this->db->this->db->escape_str($value['meta_description']) . "', meta_keyword = '" . $this->db->this->db->escape_str($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->result_array() as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "categoryblog_path` SET `categoryblog_id` = '" . (int)$categoryblog_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "categoryblog_path` SET `categoryblog_id` = '" . (int)$categoryblog_id . "', `path_id` = '" . (int)$categoryblog_id . "', `level` = '" . (int)$level . "'");

		if (isset($data['categoryblog_filter'])) {
			foreach ($data['categoryblog_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_filter SET categoryblog_id = '" . (int)$categoryblog_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['categoryblog_store'])) {
			foreach ($data['categoryblog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_to_store SET categoryblog_id = '" . (int)$categoryblog_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		// Set which layout to use with this categoryblog
		if (isset($data['categoryblog_layout'])) {
			foreach ($data['categoryblog_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_to_layout SET categoryblog_id = '" . (int)$categoryblog_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'categoryblog_id=" . (int)$categoryblog_id . "', keyword = '" . $this->db->this->db->escape_str($data['keyword']) . "'");
		}

		$this->cache->delete('categoryblog');

		return $categoryblog_id;
	}

	public function editcategoryblog($categoryblog_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "categoryblog SET parent_id = '" . (int)$data['parent_id'] . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '" . (int)$data['column'] . "', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "categoryblog SET image = '" . $this->db->this->db->escape_str($data['image']) . "' WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_description WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		foreach ($data['categoryblog_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_description SET categoryblog_id = '" . (int)$categoryblog_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->this->db->escape_str($value['name']) . "', description = '" . $this->db->this->db->escape_str($value['description']) . "', meta_title = '" . $this->db->this->db->escape_str($value['meta_title']) . "', meta_description = '" . $this->db->this->db->escape_str($value['meta_description']) . "', meta_keyword = '" . $this->db->this->db->escape_str($value['meta_keyword']) . "'");
		}

		// MySQL Hierarchical Data Closure Table Pattern
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE path_id = '" . (int)$categoryblog_id . "' ORDER BY level ASC");

		if ($query->num_rows) {
			foreach ($query->result_array() as $categoryblog_path) {
				// Delete the path below the current one
				$this->db->query("DELETE FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$categoryblog_path['categoryblog_id'] . "' AND level < '" . (int)$categoryblog_path['level'] . "'");

				$path = array();

				// Get the nodes new parents
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

				foreach ($query->result_array() as $result) {
					$path[] = $result['path_id'];
				}

				// Get whats left of the nodes current path
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$categoryblog_path['categoryblog_id'] . "' ORDER BY level ASC");

				foreach ($query->result_array() as $result) {
					$path[] = $result['path_id'];
				}

				// Combine the paths with a new level
				$level = 0;

				foreach ($path as $path_id) {
					$this->db->query("REPLACE INTO `" . DB_PREFIX . "categoryblog_path` SET categoryblog_id = '" . (int)$categoryblog_path['categoryblog_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

					$level++;
				}
			}
		} else {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

			foreach ($query->result_array() as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "categoryblog_path` SET categoryblog_id = '" . (int)$categoryblog_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "categoryblog_path` SET categoryblog_id = '" . (int)$categoryblog_id . "', `path_id` = '" . (int)$categoryblog_id . "', level = '" . (int)$level . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_filter WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		if (isset($data['categoryblog_filter'])) {
			foreach ($data['categoryblog_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_filter SET categoryblog_id = '" . (int)$categoryblog_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_to_store WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		if (isset($data['categoryblog_store'])) {
			foreach ($data['categoryblog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_to_store SET categoryblog_id = '" . (int)$categoryblog_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_to_layout WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		if (isset($data['categoryblog_layout'])) {
			foreach ($data['categoryblog_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "categoryblog_to_layout SET categoryblog_id = '" . (int)$categoryblog_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'categoryblog_id=" . (int)$categoryblog_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'categoryblog_id=" . (int)$categoryblog_id . "', keyword = '" . $this->db->this->db->escape_str($data['keyword']) . "'");
		}

		$this->cache->delete('categoryblog');
	}

	public function deletecategoryblog($categoryblog_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_path WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog_path WHERE path_id = '" . (int)$categoryblog_id . "'");

		foreach ($query->result_array() as $result) {
			$this->deletecategoryblog($result['categoryblog_id']);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_description WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_filter WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_to_store WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "categoryblog_to_layout WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_categoryblog WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'categoryblog_id=" . (int)$categoryblog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_categoryblog WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		$this->cache->delete('categoryblog');
	}

	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog WHERE parent_id = '" . (int)$parent_id . "'");

		foreach ($query->result_array() as $categoryblog) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$categoryblog['categoryblog_id'] . "'");

			// Fix for records with no paths
			$level = 0;

			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "categoryblog_path` WHERE categoryblog_id = '" . (int)$parent_id . "' ORDER BY level ASC");

			foreach ($query->result_array() as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "categoryblog_path` SET categoryblog_id = '" . (int)$categoryblog['categoryblog_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

				$level++;
			}

			$this->db->query("REPLACE INTO `" . DB_PREFIX . "categoryblog_path` SET categoryblog_id = '" . (int)$categoryblog['categoryblog_id'] . "', `path_id` = '" . (int)$categoryblog['categoryblog_id'] . "', level = '" . (int)$level . "'");

			$this->repairCategories($categoryblog['categoryblog_id']);
		}
	}

	public function getcategoryblog($categoryblog_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') FROM " . DB_PREFIX . "categoryblog_path cp LEFT JOIN " . DB_PREFIX . "categoryblog_description cd1 ON (cp.path_id = cd1.categoryblog_id AND cp.categoryblog_id != cp.path_id) WHERE cp.categoryblog_id = c.categoryblog_id AND cd1.language_id = '" . (int)$this->configs->get('config_language_id') . "' GROUP BY cp.categoryblog_id) AS path, (SELECT DISTINCT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'categoryblog_id=" . (int)$categoryblog_id . "') AS keyword FROM " . DB_PREFIX . "categoryblog c LEFT JOIN " . DB_PREFIX . "categoryblog_description cd2 ON (c.categoryblog_id = cd2.categoryblog_id) WHERE c.categoryblog_id = '" . (int)$categoryblog_id . "' AND cd2.language_id = '" . (int)$this->configs->get('config_language_id') . "'");

		return $query->row_array();
	}

	public function getCategories($data = array()) {
		$sql = "SELECT cp.categoryblog_id AS categoryblog_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "categoryblog_path cp LEFT JOIN " . DB_PREFIX . "categoryblog c1 ON (cp.categoryblog_id = c1.categoryblog_id) LEFT JOIN " . DB_PREFIX . "categoryblog c2 ON (cp.path_id = c2.categoryblog_id) LEFT JOIN " . DB_PREFIX . "categoryblog_description cd1 ON (cp.path_id = cd1.categoryblog_id) LEFT JOIN " . DB_PREFIX . "categoryblog_description cd2 ON (cp.categoryblog_id = cd2.categoryblog_id) WHERE cd1.language_id = '" . (int)$this->configs->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->configs->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND cd2.name LIKE '%" . $this->db->this->db->escape_str($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY cp.categoryblog_id";

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
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

	public function getcategoryblogDescriptions($categoryblog_id) {
		$categoryblog_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog_description WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		foreach ($query->result_array() as $result) {
			$categoryblog_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
			);
		}

		return $categoryblog_description_data;
	}
	
	public function getcategoryblogPath($categoryblog_id) {
		$query = $this->db->query("SELECT categoryblog_id, path_id, level FROM " . DB_PREFIX . "categoryblog_path WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		return $query->result_array();
	}
	
	public function getcategoryblogFilters($categoryblog_id) {
		$categoryblog_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog_filter WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		foreach ($query->result_array() as $result) {
			$categoryblog_filter_data[] = $result['filter_id'];
		}

		return $categoryblog_filter_data;
	}

	public function getcategoryblogStores($categoryblog_id) {
		$categoryblog_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog_to_store WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		foreach ($query->result_array() as $result) {
			$categoryblog_store_data[] = $result['store_id'];
		}

		return $categoryblog_store_data;
	}

	public function getcategoryblogLayouts($categoryblog_id) {
		$categoryblog_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "categoryblog_to_layout WHERE categoryblog_id = '" . (int)$categoryblog_id . "'");

		foreach ($query->result_array() as $result) {
			$categoryblog_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $categoryblog_layout_data;
	}

	public function getTotalCategories() {
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "categoryblog");

		// return $query->row['total'];
		return $this->db->count_all('categoryblog');
	}
	
	public function getTotalCategoriesByLayoutId($layout_id) {
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "categoryblog_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		// return $query->row['total'];

		return $this->db->where('layout_id', (int)$layout_id)->count_all('categoryblog_to_layout');
	}	
}
