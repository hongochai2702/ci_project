<?php
// Error Reporting
error_reporting(E_ALL);

// Check Version
if (version_compare(phpversion(), '5.4.0', '<') == true) {
	exit('PHP5.4+ Required');
}

if (!ini_get('date.timezone')) {
	date_default_timezone_set('UTC');
}

// Windows IIS Compatibility
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['SCRIPT_FILENAME'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

	if (isset($_SERVER['QUERY_STRING'])) {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}

if (!isset($_SERVER['HTTP_HOST'])) {
	$_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
}

// Check if SSL
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || (isset($_SERVER['HTTPS']) && (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443))) {
	$_SERVER['HTTPS'] = true;
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$_SERVER['HTTPS'] = true;
} else {
	$_SERVER['HTTPS'] = false;
}

// Modification Override
function modification($filename) {
	if (defined('DIR_CATALOG')) {
		$file = BASEPATH . 'system/modification/admin/' .  substr($filename, strlen(BASEPATH.'system/modification/'));
	} elseif (defined('DIR_OPENCART')) {
		$file = BASEPATH . 'system/modification/install/' .  substr($filename, strlen(BASEPATH.'system/modification/'));
	} else {
		$file = BASEPATH . 'system/modification/catalog/' . substr($filename, strlen(BASEPATH.'system/modification/'));
	}

	if (substr($filename, 0, strlen(BASEPATH.'system/')) == BASEPATH.'system/') {
		$file = BASEPATH . 'system/modification/system/' . substr($filename, strlen(BASEPATH.'system/'));
	}

	if (is_file($file)) {
		return $file;
	}

	return $filename;
}

// Autoloader
if (is_file(BASEPATH . 'system/vendor/autoload.php')) {
	require_once(BASEPATH . 'system/vendor/autoload.php');
}

function library($class) {
	$file = DIR_SYSTEM . 'library/' . str_replace('\\', '/', strtolower($class)) . '.php';

	if (is_file($file)) {
		include_once(modification($file));

		return true;
	} else {
		return false;
	}
}

spl_autoload_register('library');
spl_autoload_extensions('.php');

// Engine
require_once(modification(BASEPATH . 'engine/action.php'));
require_once(modification(BASEPATH . 'engine/controller.php'));
require_once(modification(BASEPATH . 'engine/event.php'));
require_once(modification(BASEPATH . 'engine/routing.php'));
require_once(modification(BASEPATH . 'engine/loader.php'));
require_once(modification(BASEPATH . 'engine/model.php'));
require_once(modification(BASEPATH . 'engine/registry.php'));
require_once(modification(BASEPATH . 'engine/proxy.php'));

// Helper
require_once(BASEPATH . 'helper/general.php');
require_once(BASEPATH . 'helper/utf8.php');

function start($application_config) {
	require_once(BASEPATH . 'framework.php');	
}