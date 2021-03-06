<?php
class FileManager extends MX_Controller {
	public function index() {
		$this->lang->load('common/filemanager');

		// Find which protocol to use to pass the full image link back
		if ($this->input->server('HTTPS')) {
			$server = URL_HOME;
		} else {
			$server = URL_HOME;
		}

		if ($this->input->get('filter_name')) {
			$filter_name = rtrim(str_replace(array('*', '/', '\\'), '', $this->input->get('filter_name')), '/');
		} else {
			$filter_name = '';
		}

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace('*', '', $this->input->get('directory')), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		if ($this->input->get('page')) {
			$page = $this->input->get('page');
		} else {
			$page = 1;
		}

		$directories = array();
		$files = array();

		$data['images'] = array();
		$data = array_merge($data, $this->lang->loadAll());
		$this->load->model('tool/image_model','model_tool_image');

		if (substr(str_replace('\\', '/', realpath($directory) . '/' . $filter_name), 0, strlen(DIR_IMAGE . 'catalog')) == str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			// Get directories
			$directories = glob($directory . '/' . $filter_name . '*', GLOB_ONLYDIR);

			if (!$directories) {
				$directories = array();
			}

			// Get files
			$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

			if (!$files) {
				$files = array();
			}
		}

		// Merge directories and files
		$images = array_merge($directories, $files);

		// Get total number of files and directories
		$image_total = count($images);

		// Split the array based on current page number and max number of items per page of 10
		$images = array_splice($images, ($page - 1) * 16, 16);

		foreach ($images as $image) {
			$name = str_split(basename($image), 14);

			if (is_dir($image)) {
				$url = '';

				if ($this->input->get('target')) {
					$url .= '&target=' . $this->input->get('target');
				}

				if ($this->input->get('thumb')) {
					$url .= '&thumb=' . $this->input->get('thumb');
				}

				$data['images'][] = array(
					'thumb' => '',
					'name'  => implode(' ', $name),
					'type'  => 'directory',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					'href'  => $this->url->link('common/filemanager', 'user_token=' . $this->session->userdata('user_token') . '&directory=' . urlencode(utf8_substr($image, utf8_strlen(DIR_IMAGE . 'catalog/'))) . $url, true)
				);
			} elseif (is_file($image)) {
				$data['images'][] = array(
					'thumb' => $this->model_tool_image->resize(utf8_substr($image, utf8_strlen(DIR_IMAGE)), 100, 100),
					'name'  => implode(' ', $name),
					'type'  => 'image',
					'path'  => utf8_substr($image, utf8_strlen(DIR_IMAGE)),
					'href'  => $server . 'image/' . utf8_substr($image, utf8_strlen(DIR_IMAGE))
				);
			}
		}

		$data['user_token'] = $this->session->userdata('user_token');

		if ($this->input->get('directory')) {
			$data['directory'] = urlencode($this->input->get('directory'));
		} else {
			$data['directory'] = '';
		}

		if ($this->input->get('filter_name')) {
			$data['filter_name'] = $this->input->get('filter_name');
		} else {
			$data['filter_name'] = '';
		}

		// Return the target ID for the file manager to set the value
		if ($this->input->get('target')) {
			$data['target'] = $this->input->get('target');
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if ($this->input->get('thumb')) {
			$data['thumb'] = $this->input->get('thumb');
		} else {
			$data['thumb'] = '';
		}

		// Parent
		$url = '';

		if ($this->input->get('directory')) {
			$pos = strrpos($this->input->get('directory'), '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->input->get('directory'), 0, $pos));
			}
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}

		$data['parent'] = $this->url->link('common/filemanager', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		// Refresh
		$url = '';

		if ($this->input->get('directory')) {
			$url .= '&directory=' . urlencode($this->input->get('directory'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}

		$data['refresh'] = $this->url->link('common/filemanager', 'user_token=' . $this->session->userdata('user_token') . $url, true);

		$url = '';

		if ($this->input->get('directory')) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->input->get('directory'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('filter_name')) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->input->get('filter_name'), ENT_QUOTES, 'UTF-8'));
		}

		if ($this->input->get('target')) {
			$url .= '&target=' . $this->input->get('target');
		}

		if ($this->input->get('thumb')) {
			$url .= '&thumb=' . $this->input->get('thumb');
		}

		$pagination = new Pagination();
		$pagination->total = $image_total;
		$pagination->page = $page;
		$pagination->limit = 16;
		$pagination->url = $this->url->link('common/filemanager', 'user_token=' . $this->session->userdata('user_token') . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$ignore_status = true;
		$referer = (isset($this->request->server['HTTP_REFERER']))?$this->request->server['HTTP_REFERER']:'';
		if (strpos($referer,'edit') || strpos($referer,'add') || strpos($referer,'html') ) {
			$ignore_status = false;
		}
		$data['ignore_image'] = false;
		if( $this->configs->get('image_manager_status') && $ignore_status == false ) { 
			if( $this->input->server('HTTPS') && ( 
			 	($this->input->server('HTTPS') == 'on') || ($this->input->server('HTTPS') == '1'))) 
			{
				$data['http_image'] = URL_IMAGE . 'image/';
			} else {
				$data['http_image'] = URL_IMAGE . 'image/';
			}
			$data['image_manager_command'] = json_decode($this->configs->get('image_manager_command'), true);	
			$data['image_manager_status'] = $this->configs->get('image_manager_status'); 
					
			$this->load->model('user/user_model','model_user_user');		
			$user_info = $this->model_user_user->getUser($this->user->getId());
			$data['user_group_id'] = FALSE;
			
			if( !empty($user_info) ){
				$data['user_group_id'] = $user_info['user_group_id'];
			}
			$this->response->setOutput($this->load->view('extension/feed/image_manager/popup', $data));
		} else{
			$data['ignore_image'] = true;
			$this->response->setOutput($this->load->view('common/filemanager', $data));
		}
	}

	public function upload() {
		$this->lang->load('common/filemanager');
		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->lang->line('error_permission');
		}

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . $this->input->get('directory'), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			$json['error'] = $this->lang->line('error_directory');
		}
		if (!$json) {
			$a = $json;
			// Check if 1 file are uploaded or just one
			$files = array();


			if (!empty($this->request->files['file']['name']) && !is_array($this->request->files['file']['name'])) {
				$file = array(
					'name'     => $this->request->files['file']['name'],
					'type'     => $this->request->files['file']['type'],
					'tmp_name' => $this->request->files['file']['tmp_name'],
					'error'    => $this->request->files['file']['error'],
					'size'     => $this->request->files['file']['size']
				);
			}
			// $json['dataa'] = $file;

			// foreach ($files as $file) {
				if (is_file($file['tmp_name'])) {
					// Sanitize the filename
					$filename = basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8'));

					// Validate the filename length
					if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
						$json['error'] = $this->lang->line('error_filename');
					}

					// Allowed file extension types
					$allowed = array(
						'jpg',
						'jpeg',
						'gif',
						'png'
					);

					if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
						$json['error'] = $this->lang->line('error_filetype');
					}

					// Allowed file mime types
					$allowed = array(
						'image/jpeg',
						'image/pjpeg',
						'image/png',
						'image/x-png',
						'image/gif'
					);

					if (!in_array($file['type'], $allowed)) {
						$json['error'] = $this->lang->line('error_filetype');
					}

					// Return any upload error
					if ($file['error'] != UPLOAD_ERR_OK) {
						$json['error'] = $this->lang->line('error_upload_' . $file['error']);
					}
				} else {
					$json['error'] = $this->lang->line('error_upload');
				}

				if (!$json) {
					move_uploaded_file($file['tmp_name'], $directory . '/' . $filename);
				}
			// }
		}

		if (!$json) {
			$json['success'] = $this->lang->line('text_uploaded');
		}
		send_json($json);
		// $this->response->addHeader('Content-Type: application/json');
		// $this->response->setOutput(json_encode($json));
	}

	public function folder() {
		$this->lang->load('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->lang->line('error_permission');
		}

		// Make sure we have the correct directory
		if ($this->input->get('directory')) {
			$directory = rtrim(DIR_IMAGE . 'catalog/' . $this->input->get('directory'), '/');
		} else {
			$directory = DIR_IMAGE . 'catalog';
		}

		// Check its a directory
		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
			$json['error'] = $this->lang->line('error_directory');
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			// Sanitize the folder name
			$folder = basename(html_entity_decode($this->request->post['folder'], ENT_QUOTES, 'UTF-8'));

			// Validate the filename length
			if ((utf8_strlen($folder) < 3) || (utf8_strlen($folder) > 128)) {
				$json['error'] = $this->lang->line('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . '/' . $folder)) {
				$json['error'] = $this->lang->line('error_exists');
			}
		}

		if (!isset($json['error'])) {
			mkdir($directory . '/' . $folder, 0777);
			chmod($directory . '/' . $folder, 0777);

			@touch($directory . '/' . $folder . '/' . 'index.html');

			$json['success'] = $this->lang->line('text_directory');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->lang->load('common/filemanager');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->lang->line('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = array();
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			// Check path exsists
			if ($path == DIR_IMAGE . 'catalog' || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $path)), 0, strlen(DIR_IMAGE . 'catalog')) != str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
				$json['error'] = $this->lang->line('error_delete');

				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim(DIR_IMAGE . $path, '/');

				// If path is just a file delete it
				if (is_file($path)) {
					unlink($path);

				// If path is a directory beging deleting each file and sub folder
				} elseif (is_dir($path)) {
					$files = array();

					// Make path into an array
					$path = array($path);

					// While the path array is still populated keep looping through
					while (count($path) != 0) {
						$next = array_shift($path);

						foreach (glob($next) as $file) {
							// If directory add to path array
							if (is_dir($file)) {
								$path[] = $file . '/*';
							}

							// Add the file to the files to be deleted array
							$files[] = $file;
						}
					}

					// Reverse sort the file array
					rsort($files);

					foreach ($files as $file) {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}
			}

			$json['success'] = $this->lang->line('text_delete');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}