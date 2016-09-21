<?php 

session_start();

if(!isset($_SESSION['uid'])){
	header('Location: ../index.php');
	exit;
}

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$c = Capsule::table('configs')->where('id','1')->first();
$a = Capsule::table('ads')->get();

$error = null;
$success = null;

if(isset($_SESSION['flash'])){
  $error = $_SESSION['flash'];
  $_SESSION['flash'] = null;
}

if(isset($_SESSION['success'])){
  $success = $_SESSION['success'];
  $_SESSION['success'] = null;
}

?>
<?php require_once 'templates/adslist.php'; ?>