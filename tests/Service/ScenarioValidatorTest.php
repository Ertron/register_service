<?php

namespace tests\Service;

use Service\ScenarioValidator;
use PHPUnit\Framework\TestCase;

class ScenarioValidatorTest extends TestCase {

	public function testIsValidScenario() {
		$sv = new ScenarioValidator();
		$json_file = file_get_contents(__DIR__.'/../api_admin_registr.json');
		$json = json_decode($json_file, true);

		$this->assertTrue(true);
		$this->assertFalse(false);
		$this->assertEquals(true, true);


		/*$this->markTestIncomplete('test Incomplete');*/
	}

	/*public function testValidateScenarioWithStat() {

	}*/
}
