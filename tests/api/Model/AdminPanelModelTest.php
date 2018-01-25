<?php

namespace tests\api\Model;

use apiModel\AdminPanelModel;
use PHPUnit\Framework\TestCase;

class AdminPanelModelTest extends TestCase {

	protected static $adminPanel;

	protected $host_name = 'test1.com';

	protected $host_id = 4;

	protected static $dbh;

	public static function setUpBeforeClass()
	{
		$app = require_once __DIR__.'/../Model/../../../bootstrap.php';
		self::$adminPanel = new AdminPanelModel($app['db']);
	}

	/**
	 * @test method isSetAdminPanel
	 */
	public function testIsSetAdminPanel(){

		$this->assertTrue(self::$adminPanel->isSetAdminPanel(null, $this->host_id));
		$this->assertTrue(self::$adminPanel->isSetAdminPanel($this->host_name, null));
	}

	/**
	 * @test method getAdminPanelIdByHostname
	 */
	public function testGetAdminPanelIdByHostname(){
		$this->assertEquals($this->host_id, self::$adminPanel->getAdminPanelIdByHostname($this->host_name));
	}

}
