<?php

namespace tests\Service;

use Service\ScenarioValidator;
use PHPUnit\Framework\TestCase;

class ScenarioValidatorTest extends TestCase {

	protected $validatorObject;

	protected $scenarios  = array(
		Array(
			'scenario_id' => 1,
			'popup_id' => 1,
			'steps' => Array(
				Array(
					'step_id' => 1
				)
			),
			'filters' => Array(
				'geo' => Array(),
				'device' => Array(),
				'time_table' => Array(),
				'user_access' => Array(
					'new' => 0,
					'old' => 1
				)
			)
		),
		Array(
			'scenario_id' => 2,
			'popup_id' => 2,
			'steps' => Array(
				Array(
					'step_id' => 1,
					'parameter' => 50
				),
				Array(
					'step_id' => 2,
					'parameter' => 100
				)
			),
			'filters' => Array(
				'geo' => Array(
					'UA' => Array(
						'Kiev' => Array()
					)
				),
				'device' => Array(
					'Tablet' => Array(
						'Android' => Array()
					)
				),
				'time_table' => Array(
					'Monday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Tuesday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Wednesday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Thursday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Friday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Saturday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					),
					'Sunday' => Array(
						'h0' => 'on',
						'h1' => 'on',
						'h2' => 'on',
						'h3' => 'on',
						'h4' => 'on',
						'h5' => 'on',
						'h6' => 'on',
						'h7' => 'on',
						'h8' => 'on',
						'h9' => 'on',
						'h10' => 'on',
						'h11' => 'on',
						'h12' => 'on',
						'h13' => 'on',
						'h14' => 'on',
						'h15' => 'on',
						'h16' => 'on',
						'h17' => 'on',
						'h18' => 'on',
						'h19' => 'on',
						'h20' => 'on',
						'h21' => 'on',
						'h22' => 'on',
						'h23' => 'on'
					)
				),
				'user_access' => Array(
					'new' => 0,
					'old' => 1
				)
			)
		)
	);

	protected $scenariosIsValidChecked;

	protected function setUp() {
		$this->validatorObject = new ScenarioValidator();
	}

	protected function tearDown() {
		$this->validatorObject = null;
		$this->scenarios = null;
		$this->scenariosIsValidChecked = null;
	}

	public function scenarioProvider(){
		$mapValues['row 0'] = [false, $this->scenarios[0]];
		$mapValues['row 1'] = [true, $this->scenarios[1]];
		return $mapValues;
	}

	/**
	 * @dataProvider scenarioProvider
	 *
	 * @param bool $expected
	 * @param array $array
	 */
	public function testIsValidScenario(bool $expected, array $array) {

		$actual = $this->validatorObject->isValidScenario($array);

		$this->assertEquals($expected, $actual);
	}

}
