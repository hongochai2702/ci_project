<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function initialize_elfinder($value=''){
		$CI =& get_instance();
		$CI->load->helper('path');
		$opts = array(
		    //'debug' => true, 
		    'roots' => array(
		      array( 
		        'driver' => 'LocalFileSystem', 
		        'path'   => './image/catalog/', 
		        'URL'    => site_url('image/catalog').'/'
		        // more elFinder options here
		      ) 
		    )
		);

		return $opts;
	}

	function token($length = 32) {
		// Create random token
		$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		$max = strlen($string) - 1;
		
		$token = '';
		
		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, $max)];
		}	
		
		return $token;
	}

	/**
	 * Backwards support for timing safe hash string comparisons
	 * 
	 * http://php.net/manual/en/function.hash-equals.php
	 */

	if(!function_exists('hash_equals')) {
		function hash_equals($known_string, $user_string) {
			$known_string = (string)$known_string;
			$user_string = (string)$user_string;

			if(strlen($known_string) != strlen($user_string)) {
				return false;
			} else {
				$res = $known_string ^ $user_string;
				$ret = 0;

				for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

				return !$ret;
			}
		}
	}
	if(!function_exists('is_serialized')) {
		function is_serialized( $data, $strict = true ) {
		    // if it isn't a string, it isn't serialized.
		    if ( ! is_string( $data ) ) {
		        return false;
		    }
		    $data = trim( $data );
		    if ( 'N;' == $data ) {
		        return true;
		    }
		    if ( strlen( $data ) < 4 ) {
		        return false;
		    }
		    if ( ':' !== $data[1] ) {
		        return false;
		    }
		    if ( $strict ) {
		        $lastc = substr( $data, -1 );
		        if ( ';' !== $lastc && '}' !== $lastc ) {
		            return false;
		        }
		    } else {
		        $semicolon = strpos( $data, ';' );
		        $brace     = strpos( $data, '}' );
		        // Either ; or } must exist.
		        if ( false === $semicolon && false === $brace )
		            return false;
		        // But neither must be in the first X characters.
		        if ( false !== $semicolon && $semicolon < 3 )
		            return false;
		        if ( false !== $brace && $brace < 4 )
		            return false;
		    }
		    $token = $data[0];
		    switch ( $token ) {
		        case 's' :
		            if ( $strict ) {
		                if ( '"' !== substr( $data, -2, 1 ) ) {
		                    return false;
		                }
		            } elseif ( false === strpos( $data, '"' ) ) {
		                return false;
		            }
		            // or else fall through
		        case 'a' :
		        case 'O' :
		            return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		        case 'b' :
		        case 'i' :
		        case 'd' :
		            $end = $strict ? '$' : '';
		            return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		    }
		    return false;
		}
	}