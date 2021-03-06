<?php
class Menu_model extends CI_Model {

	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function addMenu($data) {
		// $this->event->trigger('pre.admin.menu.add', $data);
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu SET code = '" . $this->db->escape_str($data['code']) . "', name = '" . $this->db->escape_str($data['name']) . "', type = '" . $this->db->escape_str($data['type']) . "', picture = '" . $this->db->escape_str($data['picture']) . "', image = '" . $this->db->escape_str($data['image']) . "', status = '" . (int)$data['status'] . "'");
		$menu_id = $this->db->insert_id();
		return $menu_id;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function editMenu($menu_id, $data) {
		// $this->event->trigger('pre.admin.menu.edit', $data);
		$this->db->query("UPDATE " . DB_PREFIX . "menu SET code = '" . $this->db->escape_str($data['code']) . "', name = '" . $this->db->escape_str($data['name']) . "', type = '" . $this->db->escape_str($data['type']) . "', picture = '" . $this->db->escape_str($data['picture']) . "', image = '" . $this->db->escape_str($data['image']) . "', status = '" . (int)$data['status'] . "' WHERE menu_id = '" . (int)$menu_id . "'");
		// $this->event->trigger('post.admin.menu.edit', $menu_id);
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function deleteMenu($menu_id) {
		// $this->event->trigger('pre.admin.menu.delete', $menu_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");
		// $this->event->trigger('post.admin.menu.delete', $menu_id);
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMenu($menu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "menu WHERE menu_id = '" . (int)$menu_id . "'");
		return $query->row_array();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMenus($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "menu";
		$sort_data = array('name');
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) { $sql .= " ORDER BY " . $data['sort']; } else { $sql .= " ORDER BY name"; }
		if (isset($data['order']) && ($data['order'] == 'DESC')) { $sql .= " DESC"; } else { $sql .= " ASC"; }
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) { $data['start'] = 0; }
			if ($data['limit'] < 1) { $data['limit'] = 20; }
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getTotalMenus() {
		// $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "menu");
		// return $query->row['total'];
		return $this->db->count_all('menu');
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupLists($menu_id, $parent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group WHERE parent_id = '". (int)$parent_id ."' AND menu_id = '" . (int)$menu_id . "' ORDER BY sort ASC ");
		$query = $query->result_array();
		return $query;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleAdd($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "menu_group SET menu_id = '" . (int)$data['menu_id'] . "', parent_id = '". (isset($data['parent_id']) ? (int)$data['parent_id'] : 0) ."', module_type = '". $data['module_type'] ."', module_id = '". (isset($data['module_id']) ? (int)$data['module_id'] : 0) ."', url = '" . $data['url'] . "', keyword = '" . $data['keyword'] . "', window = '" . (isset($data['window']) ? (int)$data['window'] : 0) . "', font = '" . $data['font'] . "', image = '" . $this->db->escape_str($data['image']) . "', style = '" . $this->db->escape_str($data['style']) . "' ");
		$menu_group_id = $this->db->insert_id();
		if (isset($data['keyword']) && !empty($data['keyword'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '" . $data['url'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $data['url'] . "', keyword = '" . $this->db->escape_str($data['keyword']) . "'");
		}
		foreach ($data['menu_group_languages'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_group_description SET menu_group_id = '" . (int)$menu_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape_str($value['name']) . "' ");
		}
		return $menu_group_id;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupSingleEdit($menu_group_id, $data) {
        if(isset($data['module_id'])) {
        	$this->db->query("UPDATE " . DB_PREFIX . "menu_group SET module_type = '" . $this->db->escape_str($data['module_type']) . "', url = '" . $this->db->escape_str($data['url']) . "', keyword = '" . $this->db->escape_str($data['keyword']) . "', window = '" . $this->db->escape_str($data['window']) . "', font = '" . $this->db->escape_str($data['font']) . "', image = '" . $this->db->escape_str($data['image']) . "', style = '" . $this->db->escape_str($data['style']) . "', module_id=".$this->db->escape_str($data['module_id'])." WHERE menu_group_id = '" . (int)$menu_group_id . "'");
        } else {
        	$this->db->query("UPDATE " . DB_PREFIX . "menu_group SET module_type = '" . $this->db->escape_str($data['module_type']) . "', url = '" . $this->db->escape_str($data['url']) . "', keyword = '" . $this->db->escape_str($data['keyword']) . "', window = '" . $this->db->escape_str($data['window']) . "', font = '" . $this->db->escape_str($data['font']) . "', image = '" . $this->db->escape_str($data['image']) . "', style = '" . $this->db->escape_str($data['style']) . "' WHERE menu_group_id = '" . (int)$menu_group_id . "'");
        }

		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = '" . $data['url'] . "'");
		if (isset($data['keyword']) && !empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = '" . $data['url'] . "', keyword = '" . $this->db->escape_str($data['keyword']) . "'");
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$menu_group_id . "'");
		foreach ($data['menu_group_languages'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "menu_group_description SET menu_group_id = '" . (int)$menu_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape_str($value['name']) . "'");
		}
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupMultipleAdd($data) {
		$this->load->model('admin/catalog/url_alias_model','model_catalog_url_alias');
		if($data['module_type']=="product"){
			foreach ($data['menu_product'] as $module_id) {
				$this->load->model('admin/catalog/product_model','model_catalog_product');
				$resultModule = $this->model_catalog_product->getProduct($module_id);
				$data['module_id'] = $resultModule['product_id'];
				$data['module_type'] = $data['module_type'];
				$data['url'] = 'product_id=' . $module_id;
				$data['keyword'] = '';
				$data['window'] = '0';
				$data['font'] = '';
				$data['image'] = '';
				$data['style'] = '';
				$data['menu_group_languages'] = $this->model_catalog_product->getProductDescriptions($module_id);
				$this->groupSingleAdd($data);
			}
		}
		if($data['module_type']=="category"){
			foreach ($data['menu_category'] as $module_id) {
				$this->load->model('admin/catalog/category_model','model_catalog_category');
				$resultModule = $this->model_catalog_category->getCategory($module_id);
				$data['module_id'] = $resultModule['category_id'];
				$data['module_type'] = $data['module_type'];
				$data['url'] = 'category_id=' . $module_id;
				$data['keyword'] = '';
				$data['window'] = '0';
				$data['font'] = '';
				$data['image'] = '';
				$data['style'] = '';
				$data['menu_group_languages'] = $this->model_catalog_category->getCategoryDescriptions($module_id);
				$this->groupSingleAdd($data);
			}
		}
		if($data['module_type']=="information"){
			foreach ($data['menu_information'] as $module_id) {
				$description_information = array();
				$query_informations = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description WHERE information_id = '" . (int)$module_id . "'");
				foreach ($query_informations->rows as $query_information) {
					$description_information[$query_information['language_id']] = array(
						'name' => $query_information['title']
					);
				}
				$this->load->model('admin/catalog/information_model','model_catalog_information');
				$resultModule = $this->model_catalog_information->getInformation($module_id);
				$data['module_id'] = $resultModule['information_id'];
				$data['module_type'] = $data['module_type'];
				$data['url'] = 'information_id=' . $module_id;
				$data['keyword'] = '';
				$data['window'] = '0';
				$data['font'] = '';
				$data['image'] = '';
				$data['style'] = '';
				$data['menu_group_languages'] = $description_information;
				$this->groupSingleAdd($data);
			}
		}
		if($data['module_type']=="manufacturer"){
			foreach ($data['menu_manufacturer'] as $module_id) {
				$this->load->model('admin/localisation/language_model','model_localisation_language');
				$query_languages = $this->model_localisation_language->getLanguages();
				$description_manufacturer = array();
				foreach ($query_languages as $query_language) {
					$query_manufacturers = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$module_id . "'");
					$description_manufacturer[$query_language['language_id']] = array(
						'name' => $query_manufacturers->row['name']
					);
				}
				$this->load->model('admin/catalog/manufacturer_model','model_catalog_manufacturer');
				$resultModule = $this->model_catalog_manufacturer->getManufacturer($module_id);
				$data['module_id'] = $resultModule['manufacturer_id'];
				$data['module_type'] = $data['module_type'];
				$data['url'] = 'manufacturer_id=' . $module_id;
				$data['keyword'] = '';
				$data['window'] = '0';
				$data['font'] = '';
				$data['image'] = '';
				$data['style'] = '';
				$data['menu_group_languages'] = $description_manufacturer;
				$this->groupSingleAdd($data);
			}
		}
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getGroupDescriptions($menu_group_id) {
		$menu_group_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$menu_group_id . "'");
		foreach ($query->result_array() as $result) {
			$menu_group_data[$result['language_id']] = array('name' => $result['name']);
		}
		return $menu_group_data;
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getGroup($menu_group_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group WHERE menu_group_id = '" . (int)$menu_group_id . "'");
		return $query->row_array();
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupDelete($menu_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_group WHERE menu_group_id = '" . (int)$menu_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$menu_group_id . "'");
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function groupCompose($compose_data) {
		$jsonstring = str_replace('&quot;', '"', $compose_data['menu_output']);
		$jsonDecoded = json_decode($jsonstring, true, 64);
		$readbleArray = $this->parseJsonArray($jsonDecoded);
		foreach ($readbleArray as $key => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "menu_group SET menu_id = '" . $compose_data['menu_id'] . "', parent_id = '" . $value['parentID'] . "', sort = '" . $key . "'  WHERE menu_group_id = '" . $value['id'] . "'");
		}
	}
	
	////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function parseJsonArray($jsonArray, $parentID = 0) {
	  $return = array();
	  foreach ($jsonArray as $subArray) {
		 $returnSubSubArray = array();
		 if (isset($subArray['children'])) {
		   $returnSubSubArray =  $this->parseJsonArray($subArray['children'], $subArray['id']);
		 }
		 $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
		 $return = array_merge($return, $returnSubSubArray);
	  }
	  return $return;
	}

}