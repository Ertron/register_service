<?php

class ServiceLogger {
	private $adminPanelId;
	private $actionType;

	public function __construct(int $adm_panel) {
		$adminPanelId = $adm_panel;
	}

	public function addLog(string $message){

	}
}