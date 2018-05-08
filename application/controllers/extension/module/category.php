<?php

class Category extends MX_Controller {

    public function index() {
        $this->load->language('extension/module/category');

        $data['heading_title'] = $this->lang->line('heading_title');

        if ($this->input->get('path')) {
            $parts = explode('_', (string) $this->input->get('path'));
        } else {
            $parts = array();
        }

        if (isset($parts[0])) {
            $data['category_id'] = $parts[0];
        } else {
            $data['category_id'] = 0;
        }

        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }
        if (isset($parts[2])) {
            $data['child2_id'] = $parts[2];
        } else {
            $data['child2_id'] = 0;
        }
        if (isset($parts[3])) {
            $data['child3_id'] = $parts[3];
        } else {
            $data['child3_id'] = 0;
        }
        if (isset($parts[4])) {
            $data['child4_id'] = $parts[4];
        } else {
            $data['child4_id'] = 0;
        }
        // Add script category.
        $this->document->addStyle('public/default/stylesheet/category.css');
        $this->document->addScript('public/default/js/category.js');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $data['categories'] = $this->menuGetLists();
        
      
            return $this->load->view('default/extension/module/category', $data,true);
       

    }

    /////////////////// menuGetLists()
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function menuGetLists() {
        $categories_group_children = $this->menuChildren();
        if($categories_group_children){
            $categories_group_create = array();
            $categories_group_create = $this->buildTree($categories_group_children, 0, "parent", "category_id");
            return $categories_group_create;
        }else{
            return array();
        }

    }
    
    /////////////////// menuChildren()
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function menuChildren() {

        $this->load->model('module/category');
        $this->load->model('tool/image');
        $query_group = $this->model_module_category->getCategoriesAll();
            
        if( count($query_group) > 0 ){
            $menu_group_create = array();
            foreach($query_group as $value_group) {
                $category_seo_url = $this->url->link('product/category', 'path=' . $value_group['parent_id'] . '_' . $value_group['category_id']);
                $menu_group_create[] = array(
                    'category_id'   => $value_group['category_id'],
                    'parent'        => $value_group['parent_id'],
                    'name'          => $value_group['name'],
                    'image'         => $value_group['image'],
                    'href'          => $category_seo_url
                );
            }
            return $menu_group_create;
        }
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