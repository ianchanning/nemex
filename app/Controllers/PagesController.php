<?php

namespace Controllers;

class PagesController extends AppController
{

    public function index()
    {
        $welcome = __('Welcome to Nemex');
        $this->set(compact('welcome'));
        if ($this->Sessions->isAuthed()) {
        	$this->redirect('projects','index');
        } else {
        	$this->redirect('pages','login');
        }
    }

	public function logout() {
		$this->layout = 'blank';
		$this->Sessions->logout();
		// $this->redirect('projects','index');
	}

	public function login() {

		// Attempting to login?
		if ( !empty($_POST['username']) && !empty($_POST['password']) ) {
			if ( $this->Sessions->login($_POST['username'], $_POST['password']) ) {
				$this->redirect('projects','index');
			}
		}

		// Not authed for this nemex? Maybe we have a sharekey for the project?
		// If not, just show the login form
		/*if ( !$this->Sessions->isAuthed() ) {
			if ( count($_GET) == 2 ) {
				$this->redirect('projects','readonly');
			}
		}*/
	}

}
