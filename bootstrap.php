<?php
date_default_timezone_set('UTC');

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

require_once __DIR__ . '/vendor/autoload.php';

/**
 * @todo This shouldn't just be a hard coded require
 */
require_once __DIR__ . '/vendor/ianchanning/vandaphp-core/src/bootstrap.php';

// This is started in Models/Sessions.php
// session_start();

/**
 * Nemex index.php code
 */
define('DS', DIRECTORY_SEPARATOR);

define('NX_PATH', dirname(__FILE__).DS);