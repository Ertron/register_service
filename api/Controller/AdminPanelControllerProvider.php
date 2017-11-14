<?php

namespace api\controller;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class AdminPanelControllerProvider  implements ControllerProviderInterface{
	public function connect(Application $app) {
		$controllers = $app['controllers_factory'];

		$controllers->match('/', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
			return 'api';
		});


		return $controllers;
	}
}