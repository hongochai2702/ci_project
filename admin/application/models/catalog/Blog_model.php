<?php
class Blog_model extends CI_Model {
	public function addBlog($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "blog SET  location = '" . $this->db->escape_str($data['location']) . "', date_available = '" . $this->db->escape_str($data['date_available']) . "', author_id = '" . (int)$data['author_id'] . "',   status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW(), date_modified = NOW()");

		$blog_id = $this->db->insert_id();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog SET image = '" . $this->db->escape_str($data['image']) . "' WHERE blog_id = '" . (int)$blog_id . "'");
		}

		foreach ($data['blog_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_description SET blog_id = '" . (int)$blog_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape_str($value['name']) . "', description = '" . $this->db->escape_str($value['description']) . "', tag = '" . $this->db->escape_str($value['tag']) . "', meta_title = '" . $this->db->escape_str($value['meta_title']) . "', meta_description = '" . $this->db->escape_str($value['meta_description']) . "', meta_keyword = '" . $this->db->escape_str($value['meta_keyword']) . "'");
		}

		if (isset($data['blog_store'])) {
			foreach ($data['blog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_store SET blog_id = '" . (int)$blog_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		

		

		
		
		

		

		if (isset($data['blog_image'])) {
			foreach ($data['blog_image'] as $blog_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_image SET blog_id = '" . (int)$blog_id . "', image = '" . $this->db->escape_str($blog_image['image']) . "', sort_order = '" . (int)$blog_image['sort_order'] . "'");
			}
		}

	

		if (isset($data['blog_categoryblog'])) {
			foreach ($data['blog_categoryblog'] as $categoryblog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_categoryblog SET blog_id = '" . (int)$blog_id . "', categoryblog_id = '" . (int)$categoryblog_id . "'");
			}
		}

		

		if (isset($data['blog_related'])) {
			foreach ($data['blog_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$blog_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET blog_id = '" . (int)$blog_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET blog_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_id . "'");
			}
		}

		
		
		// SEO URL
		if (isset($data['blog_seo_url'])) {
			foreach ($data['blog_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_id=" . (int)$blog_id . "', keyword = '" . $this->db->escape_str($keyword) . "'");
					}
				}
			}
		}
		
		if (isset($data['blog_layout'])) {
			foreach ($data['blog_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_layout SET blog_id = '" . (int)$blog_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}


		$this->cache->delete('blog');

		return $blog_id;
	}

	public function editBlog($blog_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "blog SET model = '" . $this->db->escape_str($data['model']) . "', location = '" . $this->db->escape_str($data['location']) . "',   date_available = '" . $this->db->escape_str($data['date_available']) . "', author_id = '" . (int)$data['author_id'] . "',  status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "blog SET image = '" . $this->db->escape_str($data['image']) . "' WHERE blog_id = '" . (int)$blog_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($data['blog_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blog_description SET blog_id = '" . (int)$blog_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape_str($value['name']) . "', description = '" . $this->db->escape_str($value['description']) . "', tag = '" . $this->db->escape_str($value['tag']) . "', meta_title = '" . $this->db->escape_str($value['meta_title']) . "', meta_description = '" . $this->db->escape_str($value['meta_description']) . "', meta_keyword = '" . $this->db->escape_str($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_store'])) {
			foreach ($data['blog_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_store SET blog_id = '" . (int)$blog_id . "', store_id = '" . (int)$store_id . "'");
			}
		}


		
		

		

	


		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_image WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_image'])) {
			foreach ($data['blog_image'] as $blog_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_image SET blog_id = '" . (int)$blog_id . "', image = '" . $this->db->escape_str($blog_image['image']) . "', sort_order = '" . (int)$blog_image['sort_order'] . "'");
			}
		}


		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_categoryblog WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_categoryblog'])) {
			foreach ($data['blog_categoryblog'] as $categoryblog_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_categoryblog SET blog_id = '" . (int)$blog_id . "', categoryblog_id = '" . (int)$categoryblog_id . "'");
			}
		}

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE related_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_related'])) {
			foreach ($data['blog_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$blog_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET blog_id = '" . (int)$blog_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$related_id . "' AND related_id = '" . (int)$blog_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_related SET blog_id = '" . (int)$related_id . "', related_id = '" . (int)$blog_id . "'");
			}
		}

		// SEO URL
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_id=" . (int)$blog_id . "'");
		
		if (isset($data['blog_seo_url'])) {
			foreach ($data['blog_seo_url']as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'blog_id=" . (int)$blog_id . "', keyword = '" . $this->db->escape_str($keyword) . "'");
					}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");

		if (isset($data['blog_layout'])) {
			foreach ($data['blog_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "blog_to_layout SET blog_id = '" . (int)$blog_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('blog');
	}

	public function copyBlog($blog_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog p WHERE p.blog_id = '" . (int)$blog_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			
			$data['blog_description'] = $this->getBlogDescriptions($blog_id);
		
			
			$data['blog_image'] = $this->getBlogImages($blog_id);
			
			$data['blog_related'] = $this->getBlogRelated($blog_id);
		
		
			$data['blog_categoryblog'] = $this->getBlogCategories($blog_id);
		
			$data['blog_layout'] = $this->getBlogLayouts($blog_id);
			$data['blog_store'] = $this->getBlogStores($blog_id);
			

			$this->addBlog($data);
		}
	}

	public function deleteBlog($blog_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog WHERE blog_id = '" . (int)$blog_id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");
	
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_image WHERE blog_id = '" . (int)$blog_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_related WHERE related_id = '" . (int)$blog_id . "'");
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_categoryblog WHERE blog_id = '" . (int)$blog_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "reviewblog WHERE blog_id = '" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_id=" . (int)$blog_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_blog WHERE blog_id = '" . (int)$blog_id . "'");

		$this->cache->delete('blog');
	}

	public function getBlog($blog_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "blog p LEFT JOIN " . DB_PREFIX . "blog_description pd ON (p.blog_id = pd.blog_id) WHERE p.blog_id = '" . (int)$blog_id . "' AND pd.language_id = '" . (int)$this->configs->get('config_language_id') . "'");

		return $query->first_row('array');
	}

	public function getBlogs($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "blog p LEFT JOIN " . DB_PREFIX . "blog_description pd ON (p.blog_id = pd.blog_id) WHERE pd.language_id = '" . (int)$this->configs->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE " . $this->db->escape_str($data['filter_name']) . "";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE " . $this->db->escape_str($data['filter_model']) . "";
		}

		

		

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY p.blog_id";

		$sort_data = array(
			'pd.name',
			'p.model',
		
		
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getBlogsByCategoryblogId($categoryblog_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog p LEFT JOIN " . DB_PREFIX . "blog_description pd ON (p.blog_id = pd.blog_id) LEFT JOIN " . DB_PREFIX . "blog_to_categoryblog p2c ON (p.blog_id = p2c.blog_id) WHERE pd.language_id = '" . (int)$this->configs->get('config_language_id') . "' AND p2c.categoryblog_id = '" . (int)$categoryblog_id . "' ORDER BY pd.name ASC");

		return $query->result_array();
	}

	public function getBlogDescriptions($blog_id) {
		$blog_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_description WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $blog_description_data;
	}

	public function getBlogCategories($blog_id) {
		$blog_categoryblog_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_categoryblog WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_categoryblog_data[] = $result['categoryblog_id'];
		}

		return $blog_categoryblog_data;
	}

	
	
	


	public function getBlogImages($blog_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_image WHERE blog_id = '" . (int)$blog_id . "' ORDER BY sort_order ASC");

		return $query->result_array();
	}

	
	


	public function getBlogStores($blog_id) {
		$blog_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_store WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_store_data[] = $result['store_id'];
		}

		return $blog_store_data;
	}
	
	public function getBlogSeoUrls($blog_id) {
		$blog_seo_url_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'blog_id=" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
		}

		return $blog_seo_url_data;
	}
	
	public function getBlogLayouts($blog_id) {
		$blog_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_to_layout WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $blog_layout_data;
	}

	public function getBlogRelated($blog_id) {
		$blog_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "blog_related WHERE blog_id = '" . (int)$blog_id . "'");

		foreach ($query->result_array() as $result) {
			$blog_related_data[] = $result['related_id'];
		}

		return $blog_related_data;
	}

	
	public function getTotalBlogs($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.blog_id) AS total FROM " . DB_PREFIX . "blog p LEFT JOIN " . DB_PREFIX . "blog_description pd ON (p.blog_id = pd.blog_id)";

		$sql .= " WHERE pd.language_id = '" . (int)$this->configs->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '" . $this->db->escape_str($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape_str($data['filter_model']) . "%'";
		}

	
		

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row('total');
	}






	

	public function getTotalBlogsByAuthorId($author_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE author_id = '" . (int)$author_id . "'");

		return $query->row('total');
	}

	

	

	

	public function getTotalBlogsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row('total');
	}
}
