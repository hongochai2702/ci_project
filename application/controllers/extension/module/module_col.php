<?php
class Module_Col extends MX_Controller {
	public function index($setting = array()) {
		if (isset($setting['module']) && $setting['status']==1) {
			if(!empty($setting['title'][$this->configs->get('config_language_id')])){
				$data['name'] =$setting['title'][$this->configs->get('config_language_id')];
			}else{
				$data['name'] =$setting['name'];
			}
			$data['modules'] =$setting['module'];
			$data['show_title']=$setting['show_title'];
			$data['width_full']=$setting['width_full'];
			$data['id_dv']=$setting['id_dv'];
			$data['col_ms']=$setting['col_ms'];
			$data['class']=$setting['class'];
			$data['modules_content'] =array();
            $this->load->model('extension/module_model', 'model_extension_module');
            if(!empty($setting['module'])){
                foreach ($setting['module'] as $key_module=>$item_module):
                    $items=explode("quocdvowow",$item_module);
                    $item_val_modules=explode("quocdvkaka",$items[2]);
                    $data['modules_cols'][$key_module]["col"]=$items[0];
                    foreach ($item_val_modules as $item):
                        if($item!=-1){
                            $part=  explode(".", $item);
                            if (isset($part[0]) && $this->configs->get($part[0] . '_status')) :
                                $data['modules_cols'][$key_module]["content"][] =$this->load->controller('extension/module/' . $part[0]);
                            endif;
                            if (isset($part[1])):
                                $setting_info = $this->model_extension_module->getModule($part[1]);
                                if ($setting_info && $setting_info['status']) {
                                    $data['modules_cols'][$key_module]["content"][] = $this->load->controller('extension/module/' . $part[0], $setting_info);
                                }
                            endif;
                        }
                    endforeach;
                endforeach;
            }
            
            return $this->load->view('default/extension/module/module_col', $data, true);
		}
	}
}