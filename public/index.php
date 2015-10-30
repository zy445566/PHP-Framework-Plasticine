<?php
//Just run in linux,can't run in windows,will error
$mydir=dirname($_SERVER['DOCUMENT_ROOT']);

include_once($mydir.'/vendor/Bootstrap.php'); 

$bootstrap = new Bootstrap($mydir);

$bootstrap->run();

// echo  $_SERVER['DOCUMENT_ROOT'].'<br />';
// echo  $_SERVER['REQUEST_URI'].'<br />';
// preg_match_all( '/\w+/i', $_SERVER['REQUEST_URI'] , $myrouter);
// echo $myrouter[0][0].'---'.$myrouter[0][1];

// $classname="MidWare";
// $funname="hello";
// $mw=new $classname();
// $mw->$funname();
// $mq=new MongoQuery();
// $res=$mq->collect('users')->find();
// var_dump($res);