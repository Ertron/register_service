<?php
$api = $app['controllers_factory'];
$api->get('/', function () { return 'Admin home page'; });
$api->mount('/adminp', include 'AdminPanelController.php' );

return $api;