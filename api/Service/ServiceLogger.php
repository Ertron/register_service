<?php
namespace api\Service;

class ServiceLogger {
	private $adminPanelId;
	private $db;
	private $entityType = array('admin_panel', 'landing_page', 'scenario');
	private $actionType = array('create', 'delete');
	public function __construct(int $adm_panel, $database) {
		$this->adminPanelId = $adm_panel;
		$this->db = $database;
	}

	public function addLog(string $entity_type, int $entity_id, string $action_type){
		if(in_array($entity_type, $this->entityType) && in_array($action_type, $this->actionType)){
			$this->db->insert('api_action_log', array('`id_admin_panel`' => $this->adminPanelId,
			                                          '`entity_type`' => $entity_type,
			                                          '`entity_id`' => $entity_id,
			                                          '`action_type`' => $action_type));
		}
	}
}