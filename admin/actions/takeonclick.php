<?php

session_start();

if(!isset($_SESSION['uid'])){
	header('Location: ../index.php');
	exit;
}

require_once '../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

Capsule::table('onclick')->where('id','1')->update(['code' => $_POST['code'], 'active' => $_POST['active']]);

$_SESSION['success'] = 'OnClick configs updated.';
header('Location: ../onclick.php');
exit;