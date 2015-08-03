<?php

/**
 * Nemex (https://github.com/ianchanning/nemex/)
 * Copyright 2015, Ian Channing
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2015, Ian Channing (http://ianchanning.com)
 * @link          https://github.com/ianchanning/nemex/ Nemex
 * @package       nemex
 * @since         Nemex v 0.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

use Config\Config;

use Vanda\Router;

require_once 'bootstrap.php';

/**
 * Same as `use \Config\config as config`
 * @link http://php.net/manual/en/language.namespaces.importing.php
 *
 */
// not required as it does nothing - file gets autoloaded
// use utils_vanda;

$router = new Router();
$router->dispatch();

// echo json_encode($controllerObj->response);
