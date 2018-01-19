<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

$autoload = require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app['autoload'] = $autoload;

$app['debug'] = true;

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/view',
));

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

$logger = new Logger('Logger');
$logger->pushHandler(new StreamHandler(__DIR__.'/logs/api_fails.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());
$app['file_log'] = $logger;

return $app;