<?php

namespace tests\api\Model;

use apiModel\AdminPanelModel;
use PHPUnit\Framework\TestCase;

class AdminPanelModelTest extends TestCase {

	protected $adminPanel;

	protected function setUp() {
		$app = require_once __DIR__.'/../Model/../../../bootstrap.php';
		$this->adminPanel = new AdminPanelModel($app['db']);
	}

	protected function tearDown() {
		$this->adminPanel = null;
	}

	/**
	 * @test method isSetAdminPanel
	 */
	public function testIsSetAdminPanel(){
		$host_name = 'test1.com';
		$host_id = 4;

		$this->assertTrue($this->adminPanel->isSetAdminPanel(null, $host_id));
		$this->assertTrue($this->adminPanel->isSetAdminPanel($host_name, null));
	}

}
