<?php
class ControllerCommonContentHeader extends Controller {
	public function index() {
		$this->load->model('design/layout');

		if (isset($this->request->get['routing'])) {
			$routing = (string)$this->request->get['routing'];
		} else {
			$routing = 'common/home';
		}

		$layout_id = 0;

		if ($routing == 'product/category' && isset($this->request->get['path'])) {
			$this->load->model('category');

			$path = explode('_', (string)$this->request->get['path']);

			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
		}

		if ($routing == 'product/product' && isset($this->request->get['product_id'])) {
			$this->load->model('product');

			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		}

		if ($routing == 'information/information' && isset($this->request->get['information_id'])) {
			$this->load->model('information');

			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		}

		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($routing);
		}

		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$this->load->model('setting/module');

		$data['modules'] = array();

		$modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_header');

		foreach ($modules as $module) {
			$part = explode('.', $module['code']);

			if (isset($part[0]) && $this->config->get('module_' . $part[0] . '_status')) {
				$module_data = $this->load->controller('extension/module/' . $part[0]);

				if ($module_data) {
					$data['modules'][] = $module_data;
				}
			}

			if (isset($part[1])) {
				$setting_info = $this->model_setting_module->getModule($part[1]);

				if ($setting_info && $setting_info['status']) {
					$output = $this->load->controller('extension/module/' . $part[0], $setting_info);

					if ($output) {
						$data['modules'][] = $output;
					}
				}
			}
		}

		return $this->load->view('default/content_header', $data);
	}
}
