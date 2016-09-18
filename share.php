<?php
session_start();

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

if(!isset($_GET['token']) && !is_int($_GET['token'])) {
	header('Location: index.php');
}

$token = $_GET['token'];

$c = Capsule::table('configs')->where('id','1')->first();
$i = Capsule::table('images')->where('key',$token)->first();

if(!$i){
	header('Location: index.php');
	exit;
}

$q = Capsule::table('questions')->where('id',$i->qid)->first();

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

<?php require_once 'templates/share.php'; ?>