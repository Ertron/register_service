<?php
namespace apiModel;
use stdClass;

class AdminPanelModel {

	/**
	 * Model of Admin Panel
	**/

	/**
	 * @var object $db
	**/
	public $db;

	/**
	 * AdminPanelModel constructor.
	 *
	 * @param $database
	 */
	public function __construct($database) {
		$this->db = $database;
	}

	/**
	 * @param int|null $admin_id
	 * @param int|null $landing_id
	 * @param int|null $scenarios
	 *
	 * @return string
	 */
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

	/**
	 * @param array $input
	 *
	 * @return array
	 */
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

	/**
	 * @param array $input
	 *
	 * @return array
	 */
	public function getFullInfo(array $input){
		return $this->convertToPattern($input);
	}

	/**
	 * @param array $input
	 *
	 * @return mixed
	 */
	public function getLanding(array $input){
		$array = $this->convertToPattern($input);
		$result = NULL;
		foreach ($array as $item){
			$result = $item->landings;
		}
		return $result;
	}

	/**
	 * @param array $input
	 *
	 * @return mixed
	 */
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

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getAdminPanelIdByHostname(string $name){
		$sql = "SELECT id FROM admin_panel WHERE host = ?";
		return $this->db->fetchColumn($sql, array($name), 0);
	}

	/**
	 * @param string|null $host
	 * @param int|null $id
	 *
	 * @return bool
	 */
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

	/**
	 * @param int $adm_id
	 * @param string|null $url
	 * @param int|null $lp_id
	 *
	 * @return bool
	 */
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

	/**
	 * @param int $lp_id
	 * @param int $sc_id
	 *
	 * @return bool
	 */
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

	/**
	 * @param string $hostName
	 *
	 * @return string
	 */
	private function keyGenerator(string $hostName): string {
		$result = md5($hostName);
		return $result;
	}

	/**
	 * @param string $url_str
	 *
	 * @return string
	 */
	public function lpLinkGenerator(string $url_str) :string{
		$url = trim($url_str);

		if (!preg_match('#^http(s)?://#', $url)) {
			$url = 'http://' . $url;
		}

		$urlParts = parse_url($url);

		$domain = preg_replace('/^www\./', '', $urlParts['host']);
		$uri='';
		if(isset($urlParts['path']) && !empty($urlParts['path'])){
			$uri = explode('#', $urlParts['path']);
			$uri = $uri[0];
			$uri = explode('?', $urlParts['path']);
			$uri = $uri[0];
		}
		$link = $domain.$uri;
		$link = strtolower($link);
		return $link;
	}

	/**
	 * @param string $hostName
	 *
	 * @return int
	 */
	public function addAdminPanel(string $hostName): int{
		$key = $this->keyGenerator($hostName);
		$this->db->insert('admin_panel', array('`host`' => $hostName, '`secure_key`' => $key));
		$host_id = $this->db->lastInsertId();
		return $host_id;
	}

	/**
	 * @param int $adm_id
	 * @param string $url
	 *
	 * @return int
	 */
	public function addLandingPage(int $adm_id, string $url): int{
		$this->db->insert('landing_page', array('`admin_panel_id`' => $adm_id, '`url`' => $url));
		$lp_id = $this->db->lastInsertId();
		return $lp_id;
	}

	/**
	 * @param int $lp_id
	 * @param int $popup_id
	 * @param string $steps
	 * @param string $filters
	 *
	 * @return int
	 */
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

	/**
	 * @param int $id
	 */
	public function deleteAdminPanel(int $id){
		$this->db->delete('admin_panel', array('id' => $id));
	}

	/**
	 * @param int $adm_id
	 * @param int $lp_id
	 */
	public function deleteLandingPage(int $adm_id, int $lp_id){
		$this->db->delete('landing_page', array('id' => $lp_id, 'admin_panel_id' => $adm_id));
	}

	/**
	 * @param int $id
	 * @param int $lp_id
	 */
	public function deleteScenario(int $id, int $lp_id){
		$this->db->delete('scenario', array('id' => $id, 'landing_page_id' => $lp_id));
	}
}