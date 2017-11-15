<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use api\Model\AdminPanelModel;
$adminPanel = new AdminPanelModel($app['db']);
$adminController = $app['controllers_factory'];


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
$adminController->get('/{id}/page/{l_id}', function ($id, $l_id) use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getLanding($main));
});
$adminController->get('/{id}/page/{l_id}/scenarios/{sc_id}', function ($id, $l_id, $sc_id) use ($app, $adminPanel) {
	$sql = $adminPanel->smartQueryBuilderSelect($id, $l_id, $sc_id);
	$main = $app['db']->fetchAll($sql, array());
	return $app->json($adminPanel->getScenario($main));
});

// Add Admin Panel
$adminController->post('/', function (Request $request) use ($app, $adminPanel){
	$arr = json_decode($request->getContent(), true);
	$name = $arr['host'];
	$is_set_host = $adminPanel->isSetAdminPanel($name);
	$result['id'] = NULL;
	$result['result'] = 'Admin Panel Name is registered';

	if(!$is_set_host){// insert
		$result['id'] = $adminPanel->addAdminPanel($name);
		$result['result'] = 'New Admin Panel added to DB';
	}
	return $app->json($result);
});

// Add Landing Page to Admin Panel
$adminController->post('/{id}/page', function ($id, Request $request) use ($app, $adminPanel){
	$arr = json_decode($request->getContent(), true);
	$url = $arr['url'];
	$is_set_host = $adminPanel->isSetLandingPage($id, $url);
	$result['id'] = NULL;
	$result['result'] = 'Landing Page is not added';

	/*if($is_set_host){// update

		$result['result'] = 'Landing page updated successfully';
	}
	else{// insert
		$result['id'] = $adminPanel->addLandingPage($id, $url);
		$result['result'] = 'New Landing Page added to yours Admin Panel';
	}*/
	if($is_set_host){// insert
		$result['id'] = $adminPanel->addLandingPage($id, $url);
		$result['result'] = 'New Landing Page added to yours Admin Panel';
	}

	return $app->json($result);
});

// Add Scenario to Landing Page
$adminController->post('/{id}/page/{l_id}/scenario', function ($id, $l_id, Request $request) use ($app, $adminPanel){
	$arr = json_decode($request->getContent(), true);
	$popup_id = $arr['popup_id'];
	$steps = $arr['steps'];
	$filters = $arr['filters'];

	$result['id'] = NULL;
	$result['result'] = 'Scenario is not added';

	if(!empty($lp_id) && !empty($steps) && !empty($filters)){// insert
		$result['id'] = $adminPanel->addScenario($lp_id, $popup_id, $steps, $filters);
		$result['result'] = 'New Scenario added to yours Landing Page';
	}

	return $app->json($result);
});

// Update Scenario
/*$adminController->post('/{id}/page/{l_id}/scenarios/{sc_id}', function (Request $request){

});*/

// Delete Admin Panel
$adminController->delete('/{id}', function ($id, Request $request) use ($app, $adminPanel){
	$is_set_adm = $adminPanel->isSetAdminPanel($id);
	$result['result'] = 'Admin Panel with this ID do not exist';
	if($is_set_adm){// delete
		$result['result'] = 'Admin Panel successfully deleted';
		$adminPanel->deleteAdminPanel($id);
	}
	return $app->json($result);
});

// Delete Landing Page
$adminController->delete('/{id}/page/{l_id}', function ($id, $l_id, Request $request) use ($app, $adminPanel){
	$is_set_lp = $adminPanel->isSetLandingPage($id, $l_id);
	$result['result'] = 'Landing Page with this ID do not exist';
	if($is_set_lp){// delete
		$result['result'] = 'Landing Page successfully deleted';
		$adminPanel->deleteLandingPage($id, $l_id);
	}
	return $app->json($result);
});

return $adminController;