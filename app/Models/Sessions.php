<?php

namespace Models;

class Sessions extends AppModel
{
	protected $sessionName, $instanceId;
	protected $userName, $userPass;

	public function initialise($sessionName, $instanceId, $userName, $userPass) {
		$this->sessionName = $sessionName;
		$this->instanceId = md5($instanceId);
		$this->userName = $userName;
		$this->userPass	= $userPass;

		session_name($this->sessionName);
		session_start();
	}

	public function logout() {
		session_destroy();
	}

	public function login($loginName, $loginPass) {
		if(
			$loginName === $this->userName &&
			$loginPass === $this->userPass
		) {
			$_SESSION[$this->sessionName] = $this->instanceId;
		}

		return $this->isAuthed();
	}

	public function isAuthed() {
		return (
			!empty($_SESSION[$this->sessionName]) &&
			$_SESSION[$this->sessionName] === $this->instanceId
		);
	}
}
