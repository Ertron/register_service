<?php

namespace Service;

class LoggerService {

	/**
	 * API logger with DB
	**/

	/**
	 * @var int $adminPanelId
	**/
	private $adminPanelId;

	/**
	 * @var object $db
	 **/
	private $db;

	/**
	 * @var array $entityType
	 **/
	private $entityType = array('admin_panel', 'landing_page', 'scenario');

	/**
	 * @var array $actionType
	 **/
	private $actionType = array('create', 'delete');

	/**
	 * LoggerService constructor.
	 *
	 * @param int $adm_panel
	 * @param $database
	 */
	public function __construct(int $adm_panel, $database) {
		$this->adminPanelId = $adm_panel;
		$this->db = $database;
	}

	/**
	 * @param string $entity_type
	 * @param int $entity_id
	 * @param string $action_type
	 */
	public function addLog(string $entity_type, int $entity_id, string $action_type){
		if(in_array($entity_type, $this->entityType) && in_array($action_type, $this->actionType)){
			$this->db->insert('api_action_log', array('`id_admin_panel`' => $this->adminPanelId,
			                                          '`entity_type`' => $entity_type,
			                                          '`entity_id`' => $entity_id,
			                                          '`action_type`' => $action_type));
		}
	}
}