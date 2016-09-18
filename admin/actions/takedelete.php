<?php

session_start();

require_once '../../vendor/autoload.php';

if(!isset($_SESSION['uid'])){
	header('Location: ../index.php');
	exit;
}

if(!isset($_GET['id'])){
	header('Location: ../index.php');
	exit;
}

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$q = Capsule::table('questions')->where('id',$_GET['id'])->first();

if(count($q) == 0){
	header('Location: ../index.php');
	exit;
}
unlink('../../storage/backgrounds/' . $q->url);
Capsule::table('questions')->where('id',$_GET['id'])->delete();

header('Location: ../index.php');
exit;