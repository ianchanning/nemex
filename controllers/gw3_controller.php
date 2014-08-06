<?php
class Gw3Controller extends Controller {	
	function index() {	
		$players = $this->Gw3->getPlayers();
		$headers = $this->Gw3->getPlayerHeaders();
		$this->set(compact('players', 'headers'));
	}
}
