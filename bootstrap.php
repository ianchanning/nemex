<?php

use Config\Config;

/**
 * Autoload the app classes
 *
 * This means:
 *     `use \Models\Pages` will load `app\Models\Pages.php`
 *     `use \Controllers\PagesController` will load `app\Controllers\PagesController.php`
 *
 * @link http://php.net/manual/en/function.spl-autoload.php#92767
 */
set_include_path(get_include_path() . PATH_SEPARATOR . 'app/');
spl_autoload_register();

define('DS', DIRECTORY_SEPARATOR);

// Config\Config isn't recognised as a class until after the autoloading
date_default_timezone_set(Config::TIMEZONE);

require_once dirname(__FILE__) . DS.'vendor'.DS.'autoload.php';

/**
 * @todo This shouldn't just be a hard coded require
 */
require_once dirname(__FILE__) . DS.'vendor'.DS.'ianchanning'.DS.'vandaphp-core'.DS.'src'.DS.'bootstrap.php';

require_once 'utils_vanda.php';

/**
 * Nemex index.php code
 */
define('NX_PATH', dirname(__FILE__).DS);
