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

if(!isset($_SESSION['fb_access_token'])){
	header('Location: index.php');
  exit;
}

$accessToken = $_SESSION['fb_access_token'];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,picture', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

?>

<?php require_once 'templates/create.php'; ?>