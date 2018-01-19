<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Service\LoggerService;

$app = require_once __DIR__.'/bootstrap.php';

$app->mount('/api', include 'src/api/Controller/ApiController.php' );

$app->get('/', function() use ($app) {
	return $app['twig']->render('index.twig', array());
})->bind('index');

$app->get('/inter', function() use ($app) {
	return $app['twig']->render('interpreter.twig', array());
})->bind('inter');

$app->before(function(Request $request) use($app){

	$adm = new apiModel\AdminPanelModel($app['db']);
	$app['host_info.hostname'] = $request->getHost();
	$app['host_info.is_registered'] = $adm->isSetAdminPanel($app['host_info.hostname']);
	$app['host_info.is_registered'] = true; // for tests
	$app['host_info.adminp_id'] = 4; // for tests
	if($app['host_info.is_registered']){
		$app['log'] = new LoggerService($app['host_info.adminp_id'], $app['db']); // for tests
		/*$app['log'] = new LoggerService($adm->getAdminPanelIdByHostname($app['host_info.hostname']), $app['db']);*/
	}
	/*else{
		$app['log'] = new LoggerService($adm->getAdminPanelIdByHostname($app['host_info.hostname']), $app['db']);
		//Access Denied
		$app->json();
	}*/
});
$app->after(function(Request $request, Response $response) use ($app){
	$response->headers->set('Access-Control-Allow-Origin', '*');
});

$app->run();