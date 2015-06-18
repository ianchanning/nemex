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

require_once 'bootstrap.php';

use Vanda\Router;

$router = new Router();
$router->dispatch();

/**
 * Nemex index.php code
 */
define( 'NX_PATH', realpath('./').'/' );

use \Config\config;
use utils_vanda;

echo json_encode($controllerObj->response);
