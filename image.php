<?php
	//Start Session
	session_start();
	
	//Register autoload
	require_once 'vendor/autoload.php';

	//Check the Coockie
	if(!isset($_COOKIE['_quize'])){
		header('Location: index.php');
		exit;
	}

	$id = $_COOKIE['_quize'];

	//Register database
	use Illuminate\Database\Capsule\Manager as Capsule;
	$capsule = new Capsule;
	$configs = require_once __DIR__ . '/configs/database.php';
	$capsule->setAsGlobal();
	$capsule->bootEloquent();
	$capsule->addConnection($configs['mysql']);

	// Get the configs from db
	$c = Capsule::table('configs')->where('id','1')->first();

	// Get Quize
	$q = Capsule::table('questions')->where('id',$id)->first();

	//Get Answers
	$answers = $q->answers;

	//Select a random answers
	$answers = explode(',', $answers);
	$count = count($answers);
	$answer = rand(0, $count - 1);


	// Register facebook SDK's
	$fb = new Facebook\Facebook([
	  'app_id' => $c->app_id,
	  'app_secret' => $c->app_secret,
	  'default_graph_version' => 'v' . $c->app_version,
	]);

	//Check if the token exists
	if(!isset($_SESSION['fb_access_token'])){
		header('Location: index.php');
		exit;
	}

	// Access token 
	$accessToken = $_SESSION['fb_access_token'];

	try {
  	// Returns a `Facebook\FacebookResponse` object
 	 $response = $fb->get('/me?fields=id,name,picture.width(150).height(150)', $accessToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

	$user = $response->getGraphUser();

	//Get Backgound image
	$background = imagecreatefromjpeg($c->path . '/storage/backgrounds/' . $q->url);
	$background = imagescale($background, 600, 300);

	//Get Border image
	$border = imagecreatefrompng('storage/backgrounds/border.png');

	//Avatar 100px X 100px
	$avatar = imagecreatefromjpeg($user['picture']['url']);
	$avatar = imagescale($avatar, 100, 100);
	
	//Create the image 
	$image = imagecreate(600, 300);
	$image = imagecreatetruecolor(600, 300);

	//Font Color
	$color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
	
	//Font
	$font = 'assets/fonts/font.ttf';

	//Add the images
	imagecopy($image, $background, 0, 0, 0, 0, 600, 300);
	imagecopy($image, $border, 25, 105, 0, 0, 110, 110);
	imagecopy($image, $avatar, 30, 110, 0, 0, 100, 100);

	//Add the text max 50 char
	if(strlen($q->question) <= 20){
		imagefttext($image, 25, 0, 30, 80, $color, $font, $q->question);
	}elseif(strlen($q->question) <= 30){
		imagefttext($image, 20, 0, 30, 80, $color, $font, $q->question);
	}elseif(strlen($q->question) <= 40){
		imagefttext($image, 16, 0, 30, 80, $color, $font, $q->question);
	}elseif(strlen($q->question) > 40){
		imagefttext($image, 13, 0, 30, 80, $color, $font, $q->question);
	}

	//Add the text answer max 40 char per answer	
	if(strlen($answers[$answer]) <= 20){
		imagefttext($image, 18, 0, 150, 180, $color, $font, $answers[$answer]);
	}elseif(strlen($answers[$answer]) <= 30){
		imagefttext($image, 16, 0, 150, 180, $color, $font, $answers[$answer]);
	}elseif(strlen($answers[$answer]) <= 40){
		imagefttext($image, 14, 0, 150, 180, $color, $font, $answers[$answer]);
	}
	
	//Add the Facebook name
	imagefttext($image, 20, 0, 150, 140, $color, $font, $user['name']);

	//Set the new name & the path to save 
	$name = name(10);
	$img = 'storage/created/'. $name .'.png';
	$link = $c->path . '/' .$img;

	//Set the Token for the created image
	$token = $_COOKIE['token'];

	Capsule::table('images')->insert([
			'key' => $token,
			'image' => $link,
			'qid' => $q->id
		]);


	//Create the PNG image
	header('Content-Type: image/png');
	imagepng($image, $img);
	imagepng($image);
	
	//Destroy the fb token
	session_unset();
	session_destroy();

	//Fonction for new name
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