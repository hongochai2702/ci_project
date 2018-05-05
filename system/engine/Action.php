<?php
/**
 * @package		HiTech
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, HiTech, Ltd. (https://www.hitech.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.hitech.com
*/

/**
* Action class
*/
class Action {
	private $id;
	private $routing;
	private $method = 'index';
	
	/**
	 * Constructor
	 *
	 * @param	string	$routing
 	*/
	public function __construct($routing) {
		$this->id = $routing;
		
		$parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$routing));

		// Break apart the routing
		while ($parts) {
			$file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';

			if (is_file($file)) {
				$this->routing = implode('/', $parts);		
				
				break;
			} else {
				$this->method = array_pop($parts);
			}
		}
	}

	/**
	 * 
	 *
	 * @return	string
	 *
 	*/	
	public function getId() {
		return $this->id;
	}
	
	/**
	 * 
	 *
	 * @param	object	$registry
	 * @param	array	$args
 	*/	
	public function execute($registry, array $args = array()) {
		// Stop any magical methods being called
		if (substr($this->method, 0, 2) == '__') {
			return new \Exception('Error: Calls to magic methods are not allowed!');
		}

		$file  = DIR_APPLICATION . 'controller/' . $this->routing . '.php';	
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->routing);
		
		// Initialize the class
		if (is_file($file)) {
			include_once($file);
		
			$controller = new $class($registry);
		} else {
			return new \Exception('Error: Could not call ' . $this->routing . '/' . $this->method . '!');
		}
		
		$reflection = new ReflectionClass($class);
		
		if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
			return call_user_func_array(array($controller, $this->method), $args);
		} else {
			return new \Exception('Error: Could not call ' . $this->routing . '/' . $this->method . '!');
		}
	}
}
