<?php
//Just run in linux,can't run in windows,will error
$mydir=dirname($_SERVER['DOCUMENT_ROOT']);

include_once($mydir.'/vendor/Bootstrap.php'); 

$bootstrap = new Bootstrap($mydir);

$bootstrap->run();

$router=new Router();

$router->torouter();