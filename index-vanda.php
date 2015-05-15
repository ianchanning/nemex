<?php

/**
 * Vanda PHP (https://github.com/ianchanning/vandaphp/)
 * Copyright 2011-2014, Ian Channing
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2011-2014, Ian Channing (http://ianchanning.com)
 * @link          https://github.com/ianchanning/vandaphp/ Vanda PHP
 * @package       vanda
 * @since         VandaPHP v 0.1.1
 * @modifiedby    $LastChangedBy: ianchanning $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

require_once 'bootstrap.php';

use Vanda\Router;

$router = new Router();
$router->dispatch();
