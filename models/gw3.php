<?php
class Gw3 extends Model {
	function getPlayers() {
		$data = $this->get();
		$players = $data['elInfo'];
		unset($players[0]);
		return $players;
	}
	
	function getPlayerHeaders() {
		$data = $this->get();
		$player_headers = $data['elStat'];
		asort($player_headers);
		return $player_headers;
	}
}
