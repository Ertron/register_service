<?php
namespace api\Model;
use Silex\Application;
use stdClass;
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
				   sc.id AS sc_id,
				   sc.landing_page_id AS sc_lp_id,
				   sc.scenario_id,
				   sc.popup_id,
				   sc.steps,
				   sc.filters
			FROM admin_panel AS adm
			  LEFT JOIN landing_page AS lp ON lp.admin_panel_id = adm.id".$l_id."
			  LEFT JOIN scenario AS sc ON sc.landing_page_id = lp.id".$sc_ids." ".$adm_id;
		return $sql;
	}
	/*public function convertToPattern(array $array){

		$admin_id = 0;
		$admins = array();
		$scenarios = array();
		$landings = array();

		foreach ($array as $key => $value){
			$admins[$value['admin_id']];

			$admin_id = $value['adminp_id'];
			$scenario_id = $value['scenario_id'];
			$landing_page_id = $value['lp_id'];
			$landing_page_url = $value['url'];
			$popup_id = $value['popup_id'];
			$steps = $value['steps'];
			$filters = $value['filters'];
			$lp['url'] = $landing_page_url;
			if($landing_page_id){
				$landings[$landing_page_id] = $lp;
			}

			if($scenario_id == NULL){
				$scenarios[$landing_page_id][] = new \stdClass();
			}
			else{
				$obj = new \stdClass();
				$obj->id = $scenario_id;
				$obj->popup_id = $popup_id;
				$obj->steps = json_decode($steps, true);
				$obj->filters = json_decode($filters, true);
				$scenarios[$landing_page_id][] = $obj;
			}
		}

		$lands = array();
		foreach ( $landings as $key => $item ) {
			$obj = new stdClass();
			$obj->url = $item['url'];
			$sc_arr = array();
			$obj->scenarios = $scenarios[$key];
			$lands[] = $obj;
		}
		if(count($landings) == 0) $lands[] = new stdClass();

		$result_object = new stdClass();
		$result_object-> id_admin = $admin_id;
		$result_object-> landings = $lands;

		return array($result_object);
	}*/
	private function convertToPattern(array $input){
		$adminp_arr = array();
		$result_arr = array();

		foreach ($input as $item){

			$adminp_arr[$item['adminp_id']][$item['lp_id']]['url'] = $item['url'];
			$scenario = array('id' => $item['scenario_id'], 'popup_id' => $item['popup_id'],
			                  'steps' => json_decode($item['steps'], true), 'filters' => json_decode($item['filters'], true));
			$adminp_arr[$item['adminp_id']][$item['lp_id']]['scenarios'][$item['scenario_id']] = (object)$scenario;
		}

		foreach ($adminp_arr as $key => $value){
			$adm_obj = new stdClass();
			$lands = array();

			$adm_obj->id_admin = $key;

			foreach ($value as $key_lp => $value_lp){
				$scenarios = array();
				$land_obj = new stdClass();
				$land_obj->url = $value_lp['url'];

				foreach ($value_lp['scenarios'] as $key_sc => $value_sc){
					if($value_sc->id != NULL){
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

	public function isSetHost(string $host): bool {
		$sql = "SELECT *
				FROM admin_panel 
				WHERE host = ?";
		$query_result = $this->db->fetchAll($sql, array($host));
		if(!empty($query_result))return true;
		return false;
	}
}