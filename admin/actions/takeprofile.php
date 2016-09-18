<?php

session_start();

if(!isset($_SESSION['uid'])){
  header('Location: ../index.php');
  exit;
}

require_once '../../vendor/autoload.php';

use Violin\Violin;
use Violin\Upload;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$v = new Violin;

$v->validate([
    'email|Email'   => [$_POST['email'], 'required|email'],
    'password|New Password'   => [$_POST['passw'], 'required'],
    'passw2|Confirm password'   => [$_POST['passw2'], 'required|matches(password)'],
    'passw3|Old Password' => [$_POST['passw3'], 'required'],
]);

if(!$v->passes()) {
    $_SESSION['flash'] = $v->errors()->first();
    header('Location: ../account.php');
    exit;
}

$u = Capsule::table('users')->where('id', $_SESSION['uid'])->first();

if(!password_verify($_POST['passw3'], $u->password)){
	$_SESSION['flash'] = 'The old password is incorect';
    header('Location: ../account.php');
    exit;
}

Capsule::table('users')->where('id',$_SESSION['uid'])->update([
	'email' => $_POST['email'],
	'password' => password_hash($_POST['passw'], PASSWORD_DEFAULT),
	]);

$_SESSION['success'] = 'Account updated';
header('Location: ../account.php');
exit;