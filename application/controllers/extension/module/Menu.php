<?php
class Menu extends MX_Controller {
	public function __Construct(){
		parent::__Construct();


	}
	/////////////////// index()
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function index($setting =array()) {

	
	
		$this->load->model('design/menu_model');
		$this->load->model('tool/image_model');
		$results = $this->menu_model->getMenu($setting['menu_id']);
		if($results){
			$data['type'] = $results['type'];
			$data['name'] = $results['name'];
			$data['picture'] = $results['picture'];
			$data['image'] = $results['image'];
			$data['code'] = $results['code'];
			$data['width'] = $setting['width'];
			$data['height'] = $setting['height'];
			$data['size'] = $setting['size'];
			$data['menus'] = $this->menuGetLists($results, $setting);
                        $data['info']=$setting;
			$data['language_current']=$this->configs->get('config_language_id');
			return $this->load->view('default/extension/module/menu', $data,true);
		
		}
	
	}
	
	// /////////////////// menuGetLists()
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function menuGetLists($data, $setting) {
		$menu_group_children = $this->menuChildren($data['code'], $data['menu_id'], $setting);
		if($menu_group_children){
			$menu_group_create= array();
			$menu_group_create = $this->buildTree($menu_group_children, 0, "parent", "id");
			return $menu_group_create;
		}else{
			return array();
		}
	}
	
	// /////////////////// menuChildren()
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function menuChildren($menu_code, $menu_group_id, $setting) {

		$this->load->model('design/menu_model');
		$query_group = $this->menu_model->get_menu_children($menu_group_id);

		if( count($query_group) > 0 ){
			foreach($query_group as $key_group => $value_group){

				if($menu_group_id == $value_group['menu_id']){
						
						if($value_group['module_type'] == "link"){
							$group_url = $value_group['url'];
						}
						
						if($value_group['module_type'] == "product"){
							$group_url = $this->url->link('product/product', 'product_id=' . $value_group['module_id']);
						}
						if($value_group['module_type'] == "category"){
							$group_url = $this->url->link('product/category', 'path=' . $value_group['module_id']);
						}
						if($value_group['module_type'] == "information"){
							$group_url = $this->url->link('information/information', 'information_id=' . $value_group['module_id']);
						}
						if($value_group['module_type'] == "manufacturer"){
							$group_url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $value_group['module_id']);
						}
						
						$menu_group_create[$value_group['menu_group_id']]['id'] = $value_group['menu_group_id'];
						$menu_group_create[$value_group['menu_group_id']]['parent'] = $value_group['parent_id'];
						$menu_group_create[$value_group['menu_group_id']]['sort'] = $value_group['sort'];
						$menu_group_create[$value_group['menu_group_id']]['module_type'] = $value_group['module_type'];
						$menu_group_create[$value_group['menu_group_id']]['module_id'] = $value_group['module_id'];
						$menu_group_create[$value_group['menu_group_id']]['title'] = $value_group['name'];
						$menu_group_create[$value_group['menu_group_id']]['url'] = $group_url;
						$menu_group_create[$value_group['menu_group_id']]['keyword'] = $value_group['keyword'];
						$menu_group_create[$value_group['menu_group_id']]['window'] = '';
						$menu_group_create[$value_group['menu_group_id']]['font'] = $value_group['font'];
						$menu_group_create[$value_group['menu_group_id']]['style'] = $value_group['style'];
						$menu_group_create[$value_group['menu_group_id']]['image'] = $value_group['image'];
						$menu_group_create[$value_group['menu_group_id']]['thumb'] = $this->image_model->resize($value_group['image'], $setting['width'], $setting['height']);
				}
			}
			return $menu_group_create;
		}
	}
	
	// /////////////////// menugroupDescriptions()
	// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function menugroupDescriptions($module_type, $module_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_group_description WHERE menu_group_id = '" . (int)$module_id . "' AND language_id ='" . (int)$this->configs->get('config_language_id') . "' ");
		foreach ($query->rows as $result) {
			$menu_group_description = $result['name'];
		}

		return $menu_group_description;
	}
	
	/////////////////// buildTree()
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected function buildTree(array $elements, $parentId = 0, $parent_name, $key_name) {
		if( !empty($elements) ){
			$branch = array();
			foreach ($elements as $element) {
				if ($element[$parent_name] == $parentId) {
					$children = $this->buildTree($elements, $element[$key_name], $parent_name, $key_name);
					if ($children) {
						$element['children'] = $children;
					}
					$branch[] = $element;
				}
			}
			return $branch;
		}
	}

}