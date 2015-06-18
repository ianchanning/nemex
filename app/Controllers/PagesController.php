<?php

namespace Controllers;

use Vanda\Controller;

class PagesController extends Controller
{

	public function __construct($modelName = null) {
        parent::__construct($modelName);
        $this->loadModel('Sessions');
		$this->Sessions->initialise('nemex', NX_PATH, CONFIG::USER, CONFIG::PASSWORD);
	}

    public function index()
    {
        $welcome = __('Welcome to Nemex');
        $this->set(compact('welcome'));
    }

	public function logout() {
		$this->Sessions->logout();
	}

	public function login() {

		// Attempting to login?
		if( !empty($_POST['username']) && !empty($_POST['password']) ) {
			if ( $this->Sessions->login($_POST['username'], $_POST['password']) ) {
				$this->redirect('projects','index');
			}
		}

		// Not authed for this nemex? Maybe we have a sharekey for the project?
		// If not, just show the login form
		if ( !$session->isAuthed() ) {
			if ( count($_GET) == 2 ) {
				$this->redirect('projects','readonly');
			}
		}
	}

}
