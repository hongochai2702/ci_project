<?php
/**
 * @package		HiTech
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, HiTech, Ltd. (https://www.hitech.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.hitech.com
*/

/**
* Controller class
*/
abstract class Controller {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}