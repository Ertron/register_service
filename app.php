<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$autoload = require_once __DIR__.'/vendor/autoload.php';
$autoload->add('api\\', __DIR__);
$autoload->register();

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/view',
));

/*$app->mount('/adminpanel', new api\Controller\AdminPanelControllerProvider());*/

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => array(
		'driver'    => 'pdo_mysql',
		'host'      => 'localhost',
		'dbname'    => 'register_service',
		'user'      => 'root',
		'password'  => '',
		'charset'   => 'utf8',
	)
));

$app->mount('/api', include 'api/Controller/ApiController.php' );

$app->get('/', function() use ($app) {
	return $app['twig']->render('index.twig', array());
})->bind('index');

$app->run();