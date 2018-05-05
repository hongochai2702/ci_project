<?php
/**
 * @package		HiTech
 * @author		Daniel Kerr
 * @copyright	Copyright (c) 2005 - 2017, HiTech, Ltd. (https://www.hitech.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.hitech.com
*/

/**
* URL class
*/
class CI_Url {
	private $url;
	private $ssl;
	private $rewrite = array();
	
	/**
	 * Constructor
	 *
	 * @param	string	$url
	 * @param	string	$ssl
	 *
 	*/
	public function __construct($url = '', $ssl = '') {



		$this->url = HTTP_SERVER;
		$this->ssl = $ssl;
	}

	/**
	 *
	 *
	 * @param	object	$rewrite
 	*/	
	public function addRewrite($rewrite) {
		$this->rewrite[] = $rewrite;
	}

	/**
	 * 
	 *
	 * @param	string		$routing
	 * @param	mixed		$args
	 * @param	bool		$secure
	 *
	 * @return	string
 	*/
	public function link($routing, $args = '', $secure = false) {

		if($args) {
			$routing = $routing;
		} else {
			$routing = $routing;
		}


		if ($this->ssl && $secure) {
			$url = $this->ssl . '' . $routing;
		} else {
			$url = $this->url . '' . $routing;
		}

		
		if ($args) {
			if (is_array($args)) {
				$url .= '&amp;' . http_build_query($args);
			} else {
				$url .= str_replace('&', '&amp;', '?' . ltrim($args, '&'));
			}
		}

		
		foreach ($this->rewrite as $rewrite) {
			$url = $rewrite->rewrite($url);
		}
		
		return $url; 
	}
}