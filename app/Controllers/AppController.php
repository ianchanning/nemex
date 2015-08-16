<?php

namespace Controllers;

use Views\AppView;
use Vanda\Controller;
use Config\Config;

class AppController extends Controller
{

	public function __construct($modelName = null) {
		parent::__construct($modelName);
		/**
		 * @todo loading in AppView can be done better
		 * At the moment the parent method sets view to new View and then this method just overwrites that
		 */
		$this->view = new AppView();
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
