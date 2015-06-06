<?php
/**
 * PHP version 5
 *
 * Vanda PHP (http://sourceforge.net/p/vandaphp/)
 * Copyright 2011-2012, Ian Channing
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2011-2012, Ian Channing (http://ianchanning.com)
 * @link          http://sourceforge.net/p/vandaphp/ Vanda PHP
 * @package       vanda
 * @since         Vanda v 0.1.1
 * @version       $Revision: 8 $
 * @modifiedby    $LastChangedBy: icc97 $
 * @lastmodified  $Date: 2012-03-02 16:40:01 +0100 (Fri, 02 Mar 2012) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
define('NEMEX_PATH', '');
require_once('functions.php');
session_start();

include(NEMEX_PATH.'auth.php');

include_once(NEMEX_PATH.'php/functions.php');
include_once('php/project.php');
include_once('php/user.php');

$u = new user('1');

$view = (isset($_GET['v'])) ? strtolower($_GET['v']) : 'pages';
$action = (isset($_GET['a'])) ? strtolower($_GET['a']) : 'index';
$model = view_to_model($view);
$controller = $model.'Controller';

require_once('model.php');
require_once('view.php');
require_once('controller.php');
require_once('controllers'.DIRECTORY_SEPARATOR.$view.'_controller.php');

$controller_obj = new $controller($model);
$controller_obj->{$action}();
$controller_obj->renderView($view, $action);
