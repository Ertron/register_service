<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use api\Model\AdminPanelModel;
use api\Service\ScenarioValidator;

$adminPanel = new AdminPanelModel($app['db']);
$adminController = $app['controllers_factory'];


$adminController->get('/', function (Request $request) use ($app, $adminPanel) {
	/*echo '<pre>';
	var_dump($request->getPathInfo());
	var_dump($request->getHost());
	exit();*/
	$sql = $adminPanel->smartQueryBuilderSelect();
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getFullInfo($main));
});
$adminController->get('/{id}', function ($id) use ($app, $adminPanel) {
	if((int)$id == 0){
		return new Response(json_encode("Bad request"), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$sql = $adminPanel->smartQueryBuilderSelect($id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getFullInfo($main));
});
$adminController->get('/{id}/page/{l_id}', function ($id, $l_id) use ($app, $adminPanel) {
	if((int)$id == 0 || (int)$l_id){
		return new Response(json_encode("Bad request"), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getLanding($main));
});
$adminController->get('/{id}/page/{l_id}/scenarios/{sc_id}', function ($id, $l_id, $sc_id) use ($app, $adminPanel) {
	if((int)$id == 0 || (int)$l_id || (int)$sc_id) {
		return new Response(json_encode("Bad request"), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	if(!$adminPanel->isSetScenario($l_id, $sc_id)){
		return new Response('', 404);
	}
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id, $sc_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getScenario($main));
});


// Add Admin Panel
$adminController->post('/', function (Request $request) use ($app, $adminPanel){
	$arr = json_decode($request->getContent(), true);
	if(empty($arr['host'])){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), 400);
	}
	$name = $arr['host'];
	$is_set_host = $adminPanel->isSetAdminPanel($name);
	$result['id'] = NULL;
	$result['result'] = 'Admin Panel Name is registered';

	if(!$is_set_host){// insert
		$result['id'] = $adminPanel->addAdminPanel($name);
		$app['log']->addLog('admin_panel', $result['id'], 'create');
		$result['result'] = 'New Admin Panel added to DB';
	}
	else{
		$result['result'] = 'Admin panel with this name is already registered';
	}
	$result = json_encode($result);
	$response = new Response($result, 201);
	$response->headers->set('Content-Type', 'application/json');
	return $response;
});

// Add Landing Page to Admin Panel
$adminController->post('/{id}/page', function ($id, Request $request) use ($app, $adminPanel){
	$arr = json_decode($request->getContent(), true);
	$result['result'] = 'Landing Page is not added';
	if((int)$id == 0){
		return new Response(json_encode($result), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	if(empty($arr['url']) || strlen($arr['url']) < 3 ||
	   !$adminPanel->isSetAdminPanel(NULL, $id) ||
	   !preg_match('#((https?://|www\.|[^\s:=]+@www\.).*?[a-z_\/0-9\-\#=&])(?=(\.|,|;|\?|\!)?("|\'|«|»|\[|\s|\r|\n|$))#iS', $arr['url'])){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), 400);
	}
	if(strlen($arr['url']) > 2048){
		return new Response(json_encode($result), 414);
	}

	$link = $adminPanel->lpLinkGenerator($arr['url']);

	$is_set_host = $adminPanel->isSetLandingPage($id, $link);
	$result['id'] = NULL;

	if(!$is_set_host){// insert
		$result['id'] = $adminPanel->addLandingPage($id, $link);
		$app['log']->addLog('landing_page', $result['id'], 'create');
		$result['result'] = 'New Landing Page added to yours Admin Panel';
	}
	else{
		$result['result'] = 'Landing Page with this name is already registered';
	}
	$result = json_encode($result);
	$response = new Response($result, 201);
	$response->headers->set('Content-Type', 'application/json');
	return $response;
});

// Add Scenario to Landing Page
$adminController->post('/{id}/page/{lp_id}/scenario', function ($id, $lp_id, Request $request) use ($app, $adminPanel){
	$status_code = 400;
	if((int)$id == 0 || (int)$lp_id == 0){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), $status_code);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$arr = json_decode($request->getContent(), true);
	$validator = new ScenarioValidator();

	$result['id'] = NULL;
	$result['result'] = 'Scenario is not added';
	if($validator->isValidScenario($arr)){
		$steps = json_encode($arr['steps']);
		$filters = json_encode($arr['filters']);
	}
	else{
		$result['result'] = "Wrong Parameters";
	}
	if(!empty($lp_id) && !empty($steps) && !empty($filters) &&
	   $adminPanel->isSetAdminPanel(NULL, $id) && $adminPanel->isSetLandingPage($id, NULL, $lp_id)){// insert
		$result['id'] = $adminPanel->addScenario($lp_id, $arr['popup_id'], $steps, $filters);
		$app['log']->addLog('scenario', $result['id'], 'create');
		$result['result'] = 'New Scenario added to yours Landing Page';
		$status_code = 201;
	}
	$result = json_encode($result);
	$response = new Response($result, $status_code);
	$response->headers->set('Content-Type', 'application/json');
	return $response;
});


// Delete Admin Panel
$adminController->delete('/{id}', function ($id) use ($app, $adminPanel){
	$result['result'] = 'Admin Panel with this ID do not exist';
	if((int)$id == 0){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$is_set_adm = $adminPanel->isSetAdminPanel(NULL, $id);
	if($is_set_adm){// delete
		$result['result'] = 'Admin Panel successfully deleted';
		$app['log']->addLog('admin_panel', $id, 'delete');
		$adminPanel->deleteAdminPanel($id);
	}
	return $app->json($result);
});

// Delete Landing Page
$adminController->delete('/{id}/page/{l_id}', function ($id, $l_id) use ($app, $adminPanel){
	$result['result'] = 'Landing Page with this ID do not exist';
	if((int)$id == 0 || (int)$l_id == 0){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$is_set_lp = $adminPanel->isSetLandingPage($id, NULL, $lp_id = $l_id);
	if($is_set_lp){// delete
		$result['result'] = 'Landing Page successfully deleted';
		$app['log']->addLog('landing_page', $l_id, 'delete');
		$adminPanel->deleteLandingPage($id, $l_id);
	}
	return $app->json($result);
});

// Delete Scenario
$adminController->delete('/{id}/page/{l_id}/scenario/{sc_id}', function ($id, $l_id, $sc_id) use ($app, $adminPanel){
	if((int)$id == 0 || (int)$l_id == 0 || (int)$sc_id == 0){
		$result['result'] = 'Wrong Parameters';
		return new Response(json_encode($result), 400);
	}
	if($app['host_info.adminp_id'] != $id){
		return new Response(json_encode("Access denied"), 403);
	}
	$is_set_lp = $adminPanel->isSetScenario($l_id, $sc_id);
	$result['result'] = 'Scenario with this ID do not exist';
	if($is_set_lp){// delete
		$result['result'] = 'Scenario successfully deleted';
		$app['log']->addLog('scenario', $sc_id, 'delete');
		$adminPanel->deleteScenario($sc_id, $l_id);
	}
	return $app->json($result);
});

return $adminController;