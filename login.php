<?php

session_start();

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$c = Capsule::table('configs')->where('id','1')->first();

$error = null;

if(isset($_SESSION['flash'])){
	$error = $_SESSION['flash'];
	session_unset($_SESSION['flash']);
}

?>

<?php require_once 'templates/login.php'; ?>