<?php

session_start();

if(!isset($_SESSION['uid'])){
  header('Location: ../index.php');
  exit;
}

require_once '../../vendor/autoload.php';

use Violin\Violin;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$v = new Violin;

$v->validate([
    'title|Title'  => [$_POST['title'], 'required'],
    'brand|Brand'   => [$_POST['brand'], 'required'],
    'description|Description'   => [$_POST['desc'], 'required'],
    'keywords|Keywords'   => [$_POST['keyw'], 'required'],
    'path|Path url'   => [$_POST['path'], 'required|url'],
    'app_id|App ID'   => [$_POST['app_id'], 'required'],
    'app_secret|App Secret'   => [$_POST['app_secret'], 'required'],
    'app_version|App Version'   => [$_POST['app_version'], 'required'],
]);

if(!$v->passes()) {
    $_SESSION['flash'] = $v->errors()->first();
    header('Location: ../configs.php');
    exit;
}

Capsule::table('configs')->where('id','1')->update([
	'title' => $_POST['title'],
	'brand' => $_POST['brand'],
    'description' => $_POST['desc'],
    'keywords' => $_POST['keyw'],
	'path' => $_POST['path'],
	'app_id' => $_POST['app_id'],
	'app_secret' => $_POST['app_secret'],
	'app_version' => $_POST['app_version'],
	]);

$_SESSION['success'] = 'Website configs updated.';
header('Location: ../configs.php');
exit;