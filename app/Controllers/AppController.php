<?php

namespace Controllers;

use Vanda\Controller;
use Config\Config;

class AppController extends Controller
{

	public function __construct($modelName = null) {
        parent::__construct($modelName);
        $this->loadModel('Sessions');
		$this->Sessions->initialise('nemex', NX_PATH, Config::USER, Config::PASSWORD);
		if (!$this->auth($modelName) && !$this->Sessions->isAuthed()) {
			$this->redirect('pages','login');
		}
	}

	protected function auth($modelName) {
		switch ($modelName) {
			case 'Pages':
				return true;
			default:
				return false;
		}
	}

}
