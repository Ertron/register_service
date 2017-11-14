<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use api\Model\AdminPanelModel;
$adminPanel = new AdminPanelModel($app['db']);
$adminController = $app['controllers_factory'];

/*$adminController->post('/xxx', function () use ($app, $adminPanel){
	return 'hui';
});*/
$adminController->get('/', function () use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect();
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getFullInfo($main));
});
$adminController->get('/{id}', function ($id) use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect($id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getFullInfo($main));
});
$adminController->get('/{id}/landing/{l_id}', function ($id, $l_id) use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getLanding($main));
});
$adminController->get('/{id}/landing/{l_id}/scenarios/{sc_id}', function ($id, $l_id, $sc_id) use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id, $sc_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getScenario($main));
});


$adminController->post('/', function (Request $request) use ($adminPanel){
	$arr = json_decode($request->getContent(), true);
	$name = $arr['host'];
	$is_set_host = $adminPanel->isSetHost($name);
	$result = 'hui';
	if($is_set_host){// update
		$result = 'jopa';
	}
	return new Response($result);
});

return $adminController;