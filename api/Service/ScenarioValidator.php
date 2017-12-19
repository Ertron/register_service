<?php

namespace api\Service;


class ScenarioValidator {

	private $week_days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	private $user_status = array(0,1);
	private $result_info = array('is_valid', 'error_messages');

	public function __construct() {

	}

	private function isValidSteps($array) :bool {
		foreach ($array as $item){
			if(!is_integer((int)$item['step_id']) || (int)$item['step_id'] == 0 || !isset($item['parameter'])){
				return false;
			}
			if(!empty($item['parameter']) && (!is_integer((int)$item['parameter']) || (int)$item['parameter'] == 0)){
				return false;
			}
		}
		return true;
	}
	private function validateSteps(array $array) {
		foreach ($array as $item){
			if(!isset($item['step_id'])){
				$this->result_info['error_messages'][] = 'Step ID is not set';
			}
			elseif(!is_integer((int)$item['step_id']) || (int)$item['step_id'] == 0){
				$this->result_info['error_messages'][] = 'Not valid Step ID '.$item['step_id'];
			}
			if(!isset($item['parameter'])){
				$this->result_info['error_messages'][] = 'Step parameter is not set';
				return false;
			}
			if(!empty($item['parameter']) && (!is_integer((int)$item['parameter']) || (int)$item['parameter'] == 0)){
				$this->result_info['error_messages'][] = 'Step parameter is not valid';
			}
		}
	}
	private function isValidFilter(array $array) :bool {
		$geo = $array['geo'];
		$device = $array['device'];
		$time_table = $array['time_table'];
		$user = $array['user_access'];
		if(!empty($geo) && !$this->isValidGeo($geo)){
			return false;
		}
		if(!empty($device) && !$this->isValidDevice($device)){
			return false;
		}
		if(!empty($time_table) && !$this->isValidTimeTable($time_table)){
			return false;
		}
		if(!empty($user) && !$this->isValidUserAccess($user)){
			return false;
		}


		return true;
	}
	private function validateFilter(array $array){
		$geo = null;
		$device = null;
		$user = null;
		if(isset($array['geo'])){
			$geo = $array['geo'];
		}
		else{
			$this->result_info['error_messages'][] = 'geo is not set';
		}
		if(isset($array['device'])){
			$device = $array['device'];
		}
		else{
			$this->result_info['error_messages'][] = 'device is not set';
		}
		if(isset($array['time_table'])){
			$time_table = $array['time_table'];
		}
		else{
			$this->result_info['error_messages'][] = 'time_table is not set';
		}
		if(isset($array['user_access'])){
			$user = $array['user_access'];
		}
		else{
			$this->result_info['error_messages'][] = 'user_access is not set';
		}
		if(!empty($geo) && !$this->isValidGeo($geo)){
			$this->result_info['error_messages'][] = 'Not valid Geo info : '.json_encode($geo);
		}
		if(!empty($device) && !$this->isValidDevice($device)){
			$this->result_info['error_messages'][] = 'Not valid Device info : '.json_encode($device);
		}
		if(!empty($time_table) && !$this->isValidTimeTable($time_table)){
			$this->result_info['error_messages'][] = 'Not valid TimeTable info : '.$time_table;
		}
		if(!empty($user) && !$this->isValidUserAccess($user)){
			$this->result_info['error_messages'][] = 'Not valid UserAccess info : '.$user;
		}
	}
	private function isValidGeo(array $array) :bool {
		foreach ($array as $key => $value){
			if(!preg_match('^[a-zA-Z]{2}$', $key)){
				return false;
			}
			if(!empty($key)){
				foreach ($key as $key_city => $value_city){
					if(!preg_match('^[a-zA-Z]*$', $key_city)){
						return false;
					}
				}
			}
		}
		return true;
	}
	private function isValidDevice(array $array) :bool {
		foreach ($array as $key => $value){
			if(!preg_match('^[a-zA-Z]*$', $key)){
				return false;
			}
			if(!empty($value)){
				foreach ($value as $key_os => $value_os){
					if(!preg_match('^[a-zA-Z]*$', $key_os)){
						return false;
					}
				}
			}
		}
		return true;
	}
	private function isValidTimeTable(array $array) :bool {
		foreach ($array as $key_d => $value_d){
			if (!in_array($key_d, $this->week_days)){
				return false;
			}
			foreach ($value_d as $key_h => $value_h){
				if(!preg_match('/^[h][0-9]{1,2}$/', $key_h)){
					return false;
				}
				if(!is_string($value_h)){
					return false;
				}
			}
		}
		return true;
	}
	private function isValidUserAccess(array $array) : bool {
		if(!isset($array['new']) || !in_array($array['new'], $this->user_status)){
			return false;
		}
		if(!isset($array['old']) || !in_array($array['old'], $this->user_status)){
			return false;
		}
		if($array['new'] == $array['old']){
			return false;
		}
		return true;
	}
	public function isValidScenario($array) :bool {
		if(!isset($array['scenario_id']) || !isset($array['popup_id']) || !isset($array['steps']) || !isset($array['filters'])){
			return false;
		}
		if(!is_integer((int)$array['scenario_id']) || (int)$array['scenario_id'] == 0){
			return false;
		}
		if(!is_integer((int)$array['popup_id']) || (int)$array['popup_id'] == 0){
			return false;
		}
		if(!$this->isValidSteps($array['steps'])){
			return false;
		}
		if(!$this->isValidFilter($array['filters'])){
			return false;
		}
		return true;
	}
	public function validateScenarioWithStat($array) :array {
		$this->result_info['is_valid'] = true;
		$this->result_info['error_messages'] = null;
		if(!isset($array['scenario_id'])){
			$this->result_info['error_messages'][] = 'scenario_id is not set';
		}
		if(!isset($array['popup_id'])){
			$this->result_info['error_messages'][] = 'popup_id is not set';
		}
		if(!isset($array['steps'])){
			$this->result_info['error_messages'][] = 'steps is not set';
		}
		elseif(empty($array['steps'])){
			$this->result_info['error_messages'][] = 'steps is empty';
		}
		else{
			$this->validateSteps($array['steps']);
		}
		if(!isset($array['filters'])){
			$this->result_info['error_messages'][] = 'filters is not set';
		}
		elseif(empty($array['filters'])){
			$this->result_info['error_messages'][] = 'filters is empty';
		}
		else{
			$this->validateFilter($array['filters']);
		}
		if(count($this->result_info['error_messages']) > 0){
			$this->result_info['is_valid'] = false;
		}
		return $this->result_info;
	}
}