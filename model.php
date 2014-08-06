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
class Model {
/**
 * @var string Model name  
 */
	public $name;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
/**
 * Get the model data
 *
 * @return array json decoded assoc array  
 */
	public function get() {
		$json = file_get_contents('data'.DIRECTORY_SEPARATOR.$this->name.'.js');
		return json_decode($json, true);
	}
}
