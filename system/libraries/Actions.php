<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/cart.html
 * @deprecated	3.0.0	This class is too specific for CI.
 */
class CI_Actions {
	private $file;
	private $class;
	private $method;
	private $args = array();

	public function __construct($route, $args = array()) {

		$path = '';

		// Break apart the route
		$parts = explode('/', str_replace('../', '', (string)$route));



		foreach ($parts as $part) {
			// $path .= $part;  // in opencart
			
			$path .= $part;

			if(!isset($parts[2])) {
				if (is_dir(DIR_APPLICATION . 'controllers/' . $parts[0].'/'.$parts[1])) {
					array_shift($parts);
					continue;
				}
			} 
			if(isset($parts[2])) {
				$file = DIR_APPLICATION . 'controllers/' . str_replace(array('../', '..\\', '..'), '', $parts[0].'/'.$parts[1].'/'.$parts[2]) . '.php';
			}  else {
				$file = DIR_APPLICATION . 'controllers/' . str_replace(array('../', '..\\', '..'), '', $parts[0].'/'.$parts[1]) . '.php';
			}
			
			



			

			if (is_file($file)) {



				$this->file = $file;





				// $this->class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $path);
				if(isset($parts[2])) {
					$this->class = $parts[2];
				} else {
					$this->class = $parts[1];
				}
				

				

				

				array_shift($parts);

				break;
			}
		}

		if ($args) {
			$this->args = $args;
		}

		$method = array_shift($parts);

		if ($args) {
			$this->method = 'index';
		} else {
			$this->method = 'index';
		}

			
		
	}

	public function execute($registry) {
	
		// Stop any magical methods being called

	

		if (substr($this->method, 0, 2) == '__') {
			return false;
		}	



		if (is_file($this->file)) {

			include_once($this->file);

			$class = $this->class;




			$controller = new $class($registry);
			
			if (is_callable(array($controller, $this->method))) {
		
				return call_user_func(array($controller, $this->method), $this->args);


			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}