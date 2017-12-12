<?php
namespace api\Model;
use Silex\Application;
use stdClass;
use Symfony\Component\Config\Definition\Exception\Exception;

class AdminPanelModel {
	public $db;
	public function __construct($database) {
		$this->db = $database;
	}

	public function smartQueryBuilderSelect(int $admin_id = null, int $landing_id = null, int $scenarios = null){
		$adm_id = '';
		$l_id = '';
		$sc_ids = '';
		if($admin_id) $adm_id = " WHERE adm.id = ".$admin_id;
		if($landing_id) $l_id = " AND lp.id = ".$landing_id;
		if($scenarios) $sc_ids = " AND sc.id = ".$scenarios;
		$sql = "SELECT adm.id AS adminp_id,
				   lp.id AS lp_id,
				   lp.url,
				   sc.id AS scenario_id,
				   sc.landing_page_id AS sc_lp_id,
				   sc.popup_id,
				   sc.steps,
				   sc.filters
			FROM admin_panel AS adm
			  LEFT JOIN landing_page AS lp ON lp.admin_panel_id = adm.id".$l_id."
			  LEFT JOIN scenario AS sc ON sc.landing_page_id = lp.id".$sc_ids." ".$adm_id;
		return $sql;
	}

	private function convertToPattern(array $input){
		$adminp_arr = array();
		$result_arr = array();

		foreach ($input as $item){
			$steps = json_decode($item['steps'], true);
			$steps_arr = array();
			if(!empty($steps)){
				foreach ($steps as $step){
					$obj = new stdClass();
					$obj->step_id = (string)$step['step_id'];
					$obj->parameter = (string)$step['parameter'];
					$steps_arr[] = $obj;
				}
			}

			$adminp_arr[$item['adminp_id']][$item['lp_id']]['id'] = $item['lp_id'];
			$adminp_arr[$item['adminp_id']][$item['lp_id']]['url'] = $item['url'];
			$scenario = array('scenario_id' => $item['scenario_id'], 'popup_id' => $item['popup_id'],
			                  'steps' => $steps_arr, 'filters' => json_decode($item['filters'], true));
			$adminp_arr[$item['adminp_id']][$item['lp_id']]['scenarios'][$item['scenario_id']] = (object)$scenario;
		}

		foreach ($adminp_arr as $key => $value){
			$adm_obj = new stdClass();
			$lands = array();

			$adm_obj->admin_id = (string)$key;

			foreach ($value as $key_lp => $value_lp){
				$scenarios = array();
				$land_obj = new stdClass();
				$land_obj->lp_id = $value_lp['id'];
				$land_obj->url = $value_lp['url'];

				foreach ($value_lp['scenarios'] as $key_sc => $value_sc){
					if($value_sc->scenario_id != NULL){
						$scenarios[] = $value_sc;
					}
					else{
						$scenarios[] = new stdClass();
					}
				}

				$land_obj->scenarios = $scenarios;

				if($land_obj->url != NULL){
					$lands[] = $land_obj;
				}
				else{
					$lands[] = new stdClass();
				}
			}

			$adm_obj->landings = $lands;

			$result_arr[] = $adm_obj;
		}

		return $result_arr;
	}
	public function getFullInfo(array $input){
		return $this->convertToPattern($input);
	}
	public function getLanding(array $input){
		$array = $this->convertToPattern($input);
		$result = NULL;
		foreach ($array as $item){
			$result = $item->landings;
		}
		return $result;
	}
	public function getScenario(array $input){
		$array = $this->convertToPattern($input);
		$result = NULL;
		foreach ($array as $item){
			foreach ( $item->landings as $item_sc ) {
				$result = $item_sc->scenarios;
			}
		}
		return $result;
	}
	public function getAdminPanelIdByHostname(string $name){
		$sql = "SELECT id FROM admin_panel WHERE host = ?";
		return $this->db->fetchColumn($sql, array($name), 0);
	}

	public function isSetAdminPanel(string $host = NULL, int $id = NULL): bool {
		$q_part = NULL;
		$param = NULL;
		if($host != NULL){
			$q_part = 'host';
			$param = $host;
		}
		elseif ($id){
			$q_part = 'id';
			$param = $id;
		}
		if($host != NULL || $id){
			$sql = "SELECT *
				FROM admin_panel 
				WHERE ".$q_part." = ?";
			$query_result = $this->db->fetchAll($sql, array($param));
			if(!empty($query_result))return true;
		}
		return false;
	}
	public function isSetLandingPage(int $adm_id, string $url = NULL, int $lp_id = NULL): bool {
		$q_part = NULL;
		$param = NULL;
		if($url != NULL){
			$q_part = 'url';
			$param = $url;
		}
		elseif ($lp_id){
			$q_part = 'id';
			$param = $lp_id;
		}
		if($url != NULL || $lp_id){
			$sql = "SELECT *
				FROM landing_page
				WHERE admin_panel_id = ? AND ".$q_part." = ?";
			$query_result = $this->db->fetchAll($sql, array($adm_id, $param));
			if(!empty($query_result))return true;
		}
		return false;
	}
	public function isSetScenario(int $lp_id, int $sc_id): bool {
		if(!$lp_id || !$sc_id){
			return false;
		}
		$sql = "SELECT *
				FROM scenario
				WHERE landing_page_id = ? AND id = ?";
		$query_result = $this->db->fetchAll($sql, array($lp_id, $sc_id));
		if(!empty($query_result))return true;
		return false;
	}

	private function keyGenarator(string $hostName): string {
		$result = md5($hostName);
		return $result;
	}

	public function addAdminPanel(string $hostName): int{
		$key = $this->keyGenarator($hostName);
		$this->db->insert('admin_panel', array('`host`' => $hostName, '`secure_key`' => $key));
		$host_id = $this->db->lastInsertId();
		return $host_id;
	}
	public function addLandingPage(int $adm_id, string $url): int{
		$this->db->insert('landing_page', array('`admin_panel_id`' => $adm_id, '`url`' => $url));
		$lp_id = $this->db->lastInsertId();
		return $lp_id;
	}
	public function addScenario(int $lp_id, int $popup_id, string $steps, string $filters): int{
			$this->db->insert( 'scenario', array(
				'`landing_page_id`' => $lp_id,
				'`popup_id`'        => $popup_id,
				'`steps`'           => $steps,
				'`filters`'         => $filters
			) );
		$sc_id = $this->db->lastInsertId();
		return $sc_id;
	}

	public function deleteAdminPanel(int $id){
		$this->db->delete('admin_panel', array('id' => $id));
	}
	public function deleteLandingPage(int $adm_id, int $lp_id){
		$this->db->delete('landing_page', array('id' => $lp_id, 'admin_panel_id' => $adm_id));
	}
	public function deleteScenario(int $id, int $lp_id){
		$this->db->delete('scenario', array('id' => $id, 'landing_page_id' => $lp_id));
	}
}