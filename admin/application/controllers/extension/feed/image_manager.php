<?php 
class Image_Manager extends MX_Controller { 
	private $error = array();		
    private $file = 'image_log.txt';
	
	public function thumb(){	
		$this->load->model('tool/image_model','model_tool_image');

		if ($this->input->get('image')) {
			$this->output->set_output($this->model_tool_image->resize(str_replace(URL_HOME . 'image/', '', html_entity_decode($this->input->get('image'), ENT_QUOTES, 'UTF-8')), 100, 100));
		}
	
	}
	public function index() {	
		$this->document->addScript( 'public/javascript/plugins/elFinder/jquery/jquery-migrate-1.2.1.min.js');
		$this->document->addScript( 'public/javascript/plugins/elFinder/jquery-ui/jquery-ui.js');   
		$this->document->addStyle( 'public/javascript/plugins/elFinder/jquery-ui/jquery-ui.css');
		$this->document->addStyle( 'public/javascript/plugins/elFinder/css/elfinder.min.css');   
		$this->document->addScript( 'public/javascript/plugins/elFinder/js/elFinder.js');	
		$this->document->addScript( 'public/javascript/plugins/elFinder/js/ui/elfinder-ui.js');	
		$this->document->addScript( 'public/javascript/plugins/elFinder/js/commands/commands.js');
		$this->document->addScript( 'public/javascript/plugins/elFinder/js/i18n/elfinder.'.$this->lang->line('code').'.js');	
		$this->document->addScript( 'public/javascript/plugins/elFinder/js/proxy/elFinderSupportVer1.js');
   		
   		// Nhúng ngôn ngữ của Image Manager.
   		$data = array();
		$this->lang->load('feed/image_manager');
		$data = array_merge($data, $this->lang->loadAll());

		$this->document->setTitle($this->lang->line('heading_title'));
		$data['image_manager_command']  = json_decode($this->configs->get('image_manager_command'), true);

		$data['image_manager_status']  = $this->configs->get('image_manager_status'); 
		
		if( $this->input->server('HTTPS') && ( 
			 	($this->input->server('HTTPS') == 'on') || ($this->input->server('HTTPS') == '1'))) 
		{
			$data['http_image'] = URL_IMAGE . 'image/';
		} else {
			$data['http_image'] = URL_IMAGE . 'image/';
		}

		$this->load->model('user/user_model','model_user_user');		
       	$user_info = $this->model_user_user->getUser($this->user->getId());
	   
	    if(!empty($user_info)){
       		$data['user_group_id'] = $user_info['user_group_id'];
       	} else {
	       	$data['user_group_id'] = FALSE;
        }
	   
		if ($this->session->userdata('error')) {
    		$data['error_warning'] = $this->session->userdata('error');
    
			$this->session->unset_userdata('error');
 		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
		
			$this->session->unset_userdata('success');
		} else {
			$data['success'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->lang->line('text_home'),
			'href'      => $this->url->link('common/home', 'user_token=' . $this->session->userdata('user_token'), true),     		
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->lang->line('text_feed'),
			'href'      => $this->url->link('extension/feed', 'user_token=' . $this->session->userdata('user_token'), true),
      		'separator' => ' :: '
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->lang->line('heading_title'),
			'href'      => $this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true),
      		'separator' => ' :: '
   		);
		$data['user_token'] = $this->session->userdata('user_token');
   		$data['filemanager'] = $this->url->link('extension/feed/image_manager/popup', 'user_token=' . $this->session->userdata('user_token'), true);
   		$data['action'] = $this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['clear'] = $this->url->link('feed/image_manager/clear', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['log_url'] = $this->url->link('feed/image_manager/log_file', 'user_token=' . $this->session->userdata('user_token'), true);
		$data['clear_cache'] = $this->url->link('feed/image_manager/clear_cache', 'user_token=' . $this->session->userdata('user_token'), true);

		if (($this->input->server('REQUEST_METHOD') == 'POST') && $this->validate()) {
			$this->load->model('setting/setting_model','model_setting_setting');

			$this->model_setting_setting->editSetting('image_manager', $this->input->post());		
					
			$this->session->set_userdata('success', $this->lang->line('text_success'));
			$this->response->redirect($this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true));		
		}
		/*User_group*/ 
		$user_group_data = array();
		$this->load->model('user/user_group_model','model_user_user_group');
		$data['user_groups'] = array();
		$user_group_results = $this->model_user_user_group->getUserGroups($user_group_data);
		foreach ($user_group_results as $result) {		
			$data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name']
			);
		}
		
		$data['header'] = $this->load->controller('common/Header');
		$data['column_left'] = $this->load->controller('common/Column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->load->view('feed/image_manager/filemanager', $data);
	}
	public function clear() {
		$this->lang->load('feed/image_manager');
		
		$handle = fopen(DIR_LOGS.$this->file, 'w+'); 
						
		fclose($handle); 			
		
		$this->session->set_userdata('success', $this->lang->line('text_success'));
		
		$this->response->redirect($this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true));		
	}
	
	public function log_file() {
		/*Log*/
		if (file_exists(DIR_LOGS.$this->file)) {
			$data['log'] = file_get_contents(DIR_LOGS.$this->file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['log'] = '';
		}	

		$this->load->view('feed/image_manager/log', $data);
	}

    protected function log_write($log) {	
		$file = DIR_LOGS . $this->file;		
		$handle = fopen($file, 'a+'); 		
		fwrite($handle, $log . "\n");			
		fclose($handle); 
    }

    protected function write($log) {	
        if (($fp = @fopen(DIR_LOGS.$this->file, 'a'))) {
            fwrite($fp, $log."\n");
            fclose($fp);
        }
    }

	public function popup(){			
		$elfinder_path = PATH_BASE . 'public/javascript/plugins/elFinder/php/';
		error_reporting(0); 
		ini_set('max_file_uploads', 50);
		ini_set('upload_max_filesize','50M'); 
		require_once($elfinder_path . 'elFinderConnector.class.php');
		require_once($elfinder_path . 'elFinder.class.php');
		require_once($elfinder_path . 'elFinderSimpleLogger.class.php');
		require_once($elfinder_path . 'elFinderVolumeDriver.class.php');
		require_once($elfinder_path . 'elFinderVolumeLocalFileSystem.class.php');
		
		$myLogger = new elFinderSimpleLogger(DIR_LOGS.$this->file);
		$log = 'At time: ['.date('d.m H:s')."]\n";
		$log .= "\tUser Access: ".$this->user->getUserName()."\n";
		$log .= "\tIP Address: ".$this->input->server('REMOTE_ADDR')."\n";
		$this->log_write($log);
		
		$opts = array(
		'bind' => array(
			'mkdir mkfile rename duplicate upload rm paste' => array($myLogger, 'log'),
		),
		'roots' => array(
				array(
					'driver'     => 'LocalFileSystem',
					'path'       => DIR_IMAGE.'catalog', 
					'startPath'  => DIR_IMAGE.'catalog', 
					'URL'        => HTTP_CATALOG.'image/catalog', 
					// 'alias'      => 'File system',
					'uploadOrder'  => 'deny,allow',
					'mimeDetect' => 'internal',
					'tmbPath'    => DIR_IMAGE.'thumb',         // tmbPath to files (REQUIRED)
					'tmbURL'     => HTTP_CATALOG.'image/thumb',
					'utf8fix'    => true,
					//'uploadMaxSize'    => '0',
					'uploadMaxSize'    => '2M',
					'tmbCrop'    => false,
					'tmbBgColor' => 'transparent',
					'accessControl' => 'access',
					'copyOverwrite' => false,
					'uploadOverwrite' => false,
					// 'uploadDeny' => array('application', 'text/xml')
				)		
			)
		);
		// run elFinder
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();
	}

	public function clear_cache() {
		$this->lang->load('feed/image_manager');
		if ($this->user->hasPermission('modify', 'feed/image_manager')) {
			$imgfiles = glob(DIR_IMAGE . 'cache/*');
			foreach($imgfiles as $imgfile){
				$this->deldir($imgfile);
			}
			$this->session->set_userdata('success', $this->lang->line('text_success'));
    	}else{		
      		$this->session->set_userdata('error', $this->lang->line('error_permission'));
		}		
		$this->response->redirect($this->url->link('feed/image_manager', 'user_token=' . $this->session->userdata('user_token'), true));		
	}
    private function deldir($dirname){         
		if(file_exists($dirname)) {
			if(is_dir($dirname)){
                            $dir=opendir($dirname);
                            while($filename=readdir($dir)){
                                    if($filename!="." && $filename!=".."){
                                        $file=$dirname."/".$filename;
					$this->deldir($file); 
                                    }
                                }
                            closedir($dir);  
                            rmdir($dirname);
                        }
			else {@unlink($dirname);}			
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/image_manager')) {
			$this->error['warning'] = $this->lang->line('error_permission');
		}		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	public function install() {
		//image_manager_status
	// 	$this->load->model('setting/setting');
	// 	$this->model_setting_setting->editSetting('image_manager_installed', array('image_manager_installed' => 1));
	
	// 		$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager'");	
	// 		$this->db->query("INSERT INTO `". DB_PREFIX ."setting` (`store_id`,`code`, `key`, `value`, `serialized`) VALUES
	// (0,'image_manager', 'image_manager_command', 'a:1:{i:1;a:20:{s:5:\"mkdir\";s:1:\"1\";s:6:\"mkfile\";s:1:\"1\";s:6:\"upload\";s:1:\"1\";s:6:\"reload\";s:1:\"1\";s:7:\"getfile\";s:1:\"1\";s:2:\"up\";s:1:\"1\";s:8:\"download\";s:1:\"1\";s:2:\"rm\";s:1:\"1\";s:9:\"duplicate\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:3:\"cut\";s:1:\"1\";s:5:\"paste\";s:1:\"1\";s:4:\"edit\";s:1:\"1\";s:7:\"extract\";s:1:\"1\";s:7:\"archive\";s:1:\"1\";s:4:\"view\";s:1:\"1\";s:6:\"resize\";s:1:\"1\";s:4:\"sort\";s:1:\"1\";s:6:\"search\";s:1:\"1\";}}', 1);");
	// 		$this->db->query("INSERT INTO `". DB_PREFIX ."setting` (`store_id`,`code`, `key`, `value`, `serialized`) VALUES
	// (0,'image_manager', 'image_manager_status', '1', 0);");	

	// 	/*Import XML*/ 
	// 	$this->lang->load('extension/installer');
	// 	$json = array();

	// 	$file = DIR_APPLICATION .  'view/template/image_manager/filemanager.xml';

	// 	$this->load->model('extension/modification');
		
	// 	// If xml file just put it straight into the DB
	// 		$xml = file_get_contents($file);

	// 		if ($xml) {
	// 			try {
	// 				$dom = new DOMDocument('1.0', 'UTF-8');
	// 				$dom->loadXml($xml);
					
	// 				$name = $dom->getElementsByTagName('name')->item(0);

	// 				if ($name) {
	// 					$name = $name->nodeValue;
	// 				} else {
	// 					$name = '';
	// 				}
	// 				$code = $dom->getElementsByTagName('code')->item(0);	
	// 				if ($code) {
	// 						$code = $code->nodeValue;
	// 						// Check to see if the modification is already installed or not.
	// 						$modification_info = $this->model_extension_modification->getModificationByCode($code);
							
	// 						if ($modification_info) {	
	// 							$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager'");	
	// 							$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%image_manager%'");
	// 						}
	// 				} else {
	// 					$json['error'] = $this->lang->line('error_code');
	// 				}

	// 				$author = $dom->getElementsByTagName('author')->item(0);

	// 				if ($author) {
	// 					$author = $author->nodeValue;
	// 				} else {
	// 					$author = '';
	// 				}

	// 				$version = $dom->getElementsByTagName('version')->item(0);

	// 				if ($version) {
	// 					$version = $version->nodeValue;
	// 				} else {
	// 					$version = '';
	// 				}

	// 				$link = $dom->getElementsByTagName('link')->item(0);

	// 				if ($link) {
	// 					$link = $link->nodeValue;
	// 				} else {
	// 					$link = '';
	// 				}

	// 				$modification_data = array(
	// 					'name'    => $name,
	// 					'code'    => $code,
	// 					'author'  => $author,
	// 					'version' => $version,
	// 					'link'    => $link,
	// 					'xml'     => $xml,
	// 					'status'  => 1
	// 				);
					
	// 				if (!$json) {
	// 					$this->model_extension_modification->addModification($modification_data);
	// 				}
	// 			} catch(Exception $exception) {
	// 				$json['error'] = sprintf($this->lang->line('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
	// 			}
	// 		}
	}
	public function uninstall() {			
		$this->db->query("DELETE FROM `" . DB_PREFIX. "setting` WHERE `key` = 'image_manager_installed'");			
		$this->db->query("DELETE FROM `". DB_PREFIX ."setting` WHERE `code` = 'image_manager'");	
		$this->db->query("DELETE FROM `" . DB_PREFIX. "modification` WHERE `code` LIKE '%image_manager%'");
		
	}
	private function checkverion(){		
		$return = '2000';
		if (defined('VERSION')) {
			$return = str_replace('.','',VERSION);
		}
		return $return;
	}
}