<?php
$adm = $app['controllers_factory'];
$adm->get('/', function () { return 'Admin home page'; });
$adm->mount('/api', include 'blog.php' );

return $adm;