<?php

session_start();

if(!isset($_POST['submit'])){
	header('Location: index.php');
	exit;
}

require_once 'vendor/autoload.php';

use Violin\Violin;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$v = new Violin;

$v->validate([
    'email|Email'  => [$_POST['email'], 'required|email'],
    'password|Password'   => [$_POST['password'], 'required']
]);

if(!$v->passes()) {
    $_SESSION['flash'] = $v->errors()->first();
    header('Location: login.php');
    exit;
}

$user = Capsule::table('users')->where('email', $_POST['email'])->first();

if(!$user){
	$_SESSION['flash'] = 'Incorrect email or password. Please try again.';
    header('Location: login.php');
    exit;
}

if(!password_verify($_POST['password'], $user->password)){
	$_SESSION['flash'] = 'Incorrect email or password. Please try again.';
    header('Location: login.php');
    exit;
}else{

$_SESSION['uid'] = $user->id;
header('Location: admin/index.php');
exit;

}

?>