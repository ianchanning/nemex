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

use Vanda\Router;

require_once 'bootstrap.php';

$router = new Router();
$router->dispatch();
