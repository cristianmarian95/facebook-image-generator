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

$fb = new Facebook\Facebook([
	'app_id' => $c->app_id,
	'app_secret' => $c->app_secret,
	'default_graph_version' => 'v' . $c->app_version,
]);

$helper = $fb->getRedirectLoginHelper();

//Permissions
$permissions = ['email'];

//Redirect url from facebook
$loginUrl = $helper->getLoginUrl($c->path .'/remote.php', $permissions);

//Check if the id is set
if(!isset($_GET['id'])){
	header('Location: index.php');
}

$q = Capsule::table('questions')->where('id', $_GET['id'])->first();

if(isset($_COOKIE['_quize'])){
    $_COOKIE['_quize'] = null;
}elseif(isset($_COOKIE['token'])){
	$_COOKIE['token'] = null;
}

setcookie('_quize', $q->id, time() + (86400 * 30));
setcookie('token', name(), time() + (86400 * 30));

function name($length = 10) {
    $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($char);
    $rString = '';
    for ($i = 0; $i < $length; $i++) {
        $rString .= $char[rand(0, $charLength - 1)];
    }
   	return $rString;
}

?>

<?php require_once 'templates/auth.php'; ?>