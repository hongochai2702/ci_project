<?php
/**
 * @package		HiTech
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, HiTech, Ltd. (https://www.hitech.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.hitech.com
*/

/**
* Loader class
*/
final class Loader {
	protected $registry;

	/**
	 * Constructor
	 *
	 * @param	object	$registry
 	*/
	public function __construct($registry) {
		$this->registry = $registry;
	}

	/**
	 * 
	 *
	 * @param	string	$routing
	 * @param	array	$data
	 *
	 * @return	mixed
 	*/	
	public function controller($routing, $data = array()) {
		// Sanitize the call
		$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);
		
		// Keep the original trigger
		$trigger = $routing;
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/before', array(&$routing, &$data));
		
		// Make sure its only the last event that returns an output if required.
		if ($result != null && !$result instanceof Exception) {
			$output = $result;
		} else {
			$action = new Action($routing);
			$output = $action->execute($this->registry, array(&$data));
		}
		
		// Trigger the post events
		$result = $this->registry->get('event')->trigger('controller/' . $trigger . '/after', array(&$routing, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}

		if (!$output instanceof Exception) {
			return $output;
		}
	}

	/**
	 * 
	 *
	 * @param	string	$routing
 	*/	
	public function model($routing) {
		// Sanitize the call
		$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);
		
		if (!$this->registry->has('model_' . str_replace('/', '_', $routing))) {
			$file  = DIR_APPLICATION . 'model/' . $routing . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $routing);
			
			if (is_file($file)) {
				include_once($file);
	
				$proxy = new Proxy();
				
				// Overriding models is a little harder so we have to use PHP's magic methods
				// In future version we can use runkit
				foreach (get_class_methods($class) as $method) {
					$proxy->{$method} = $this->callback($this->registry, $routing . '/' . $method);
				}
				
				$this->registry->set('model_' . str_replace('/', '_', (string)$routing), $proxy);
			} else {
				throw new \Exception('Error: Could not load model ' . $routing . '!');
			}
		}
	}

	/**
	 * 
	 *
	 * @param	string	$routing
	 * @param	array	$data
	 *
	 * @return	string
 	*/
	public function view($routing, $data = array()) {
		// Sanitize the call
		$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);
		
		// Keep the original trigger
		$trigger = $routing;
		
		// Template contents. Not the output!
		$template = '';
		
		// Trigger the pre events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/before', array(&$routing, &$data, &$template));

		
		// Make sure its only the last event that returns an output if required.
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$template = new Template($this->registry->get('config')->get('template_engine'));
				
			foreach ($data as $key => $value) {
				$template->set($key, $value);
			}

			$output = $template->render($this->registry->get('config')->get('template_directory') . $routing, $this->registry->get('config')->get('template_cache'));		
		}

		// Trigger the post events
		$result = $this->registry->get('event')->trigger('view/' . $trigger . '/after', array(&$routing, &$data, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
		

		return $output;
	}

	/**
	 * 
	 *
	 * @param	string	$routing
 	*/
	public function library($routing) {
		// Sanitize the call
		$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);
			
		$file = DIR_SYSTEM . 'library/' . $routing . '.php';
		$class = str_replace('/', '\\', $routing);

		if (is_file($file)) {
			include_once($file);

			$this->registry->set(basename($routing), new $class($this->registry));
		} else {
			throw new \Exception('Error: Could not load library ' . $routing . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$routing
 	*/	
	public function helper($routing) {
		$file = DIR_SYSTEM . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing) . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $routing . '!');
		}
	}

	/**
	 * 
	 *
	 * @param	string	$routing
 	*/	
	public function config($routing) {
		$this->registry->get('event')->trigger('config/' . $routing . '/before', array(&$routing));
		
		$this->registry->get('config')->load($routing);
		
		$this->registry->get('event')->trigger('config/' . $routing . '/after', array(&$routing));
	}

	/**
	 * 
	 *
	 * @param	string	$routing
	 * @param	string	$key
	 *
	 * @return	array
 	*/
	public function language($routing, $key = '') {
		// Sanitize the call
		$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);
		
		// Keep the original trigger
		$trigger = $routing;
				
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/before', array(&$routing, &$key));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		} else {
			$output = $this->registry->get('language')->load($routing, $key);
		}
		
		$result = $this->registry->get('event')->trigger('language/' . $trigger . '/after', array(&$routing, &$key, &$output));
		
		if ($result && !$result instanceof Exception) {
			$output = $result;
		}
				
		return $output;
	}
	
	protected function callback($registry, $routing) {
		return function($args) use($registry, $routing) {
			static $model;
			
			$routing = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing);

			// Keep the original trigger
			$trigger = $routing;
					
			// Trigger the pre events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/before', array(&$routing, &$args));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			} else {
				$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', substr($routing, 0, strrpos($routing, '/')));
				
				// Store the model object
				$key = substr($routing, 0, strrpos($routing, '/'));
				
				if (!isset($model[$key])) {
					$model[$key] = new $class($registry);
				}
				
				$method = substr($routing, strrpos($routing, '/') + 1);
				
				$callable = array($model[$key], $method);
	
				if (is_callable($callable)) {
					$output = call_user_func_array($callable, $args);
				} else {
					throw new \Exception('Error: Could not call model/' . $routing . '!');
				}					
			}
			
			// Trigger the post events
			$result = $registry->get('event')->trigger('model/' . $trigger . '/after', array(&$routing, &$args, &$output));
			
			if ($result && !$result instanceof Exception) {
				$output = $result;
			}
						
			return $output;
		};
	}	
}