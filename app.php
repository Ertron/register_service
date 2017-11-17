<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

use Symfony\Component\HttpFoundation\Request;

use api\Service\LoggerService;

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

$app->before(function(Request $request) use($app){
	$adm = new api\Model\AdminPanelModel($app['db']);
	$app['host_info.hostname'] = $request->getHost();
	$app['host_info.is_registered'] = $adm->isSetAdminPanel($app['host_info.hostname']);
	if($app['host_info.is_registered']){
		$app['log'] = new LoggerService($adm->getAdminPanelIdByHostname($app['host_info.hostname']), $app['db']);
	}
	else{
		//Access Denied
		/*$app->json();*/
	}
});

$app->run();