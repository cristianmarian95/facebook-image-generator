<?php 

session_start();

if(!isset($_SESSION['uid'])){
	header('Location: ../index.php');
	exit;
}

if(!isset($_GET['action'])){
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

//Get the action
$action = htmlentities($_GET['action']);

//Create ADS
if($action == 'create') {
	$v = new Violin;
	$v->validate(['code|HTML Code' => [$_POST['code'], 'required']]);
	if(!$v->passes()){
		$_SESSION['flash'] = $v->errors()->first();
		header('Location: ../ads.php');
		exit;
	}

	function isHtml($string){
     	preg_match("/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/",$string, $matches);
     	if(count($matches)==0){
        	return FALSE;
      	}else{
        	return TRUE;
      	}
	}

	if(!isHTML($_POST['code'])){
		$_SESSION['flash'] = 'Please enter a HTML code.';
		header('Location: ../ads.php');
		exit;
	}


	Capsule::table('ads')->insert(['code' => $_POST['code']]);
	$_SESSION['success'] = 'Advertisement was successfully added.';
	header('Location: ../ads.php');
	exit;
}

//Edit ADS
if($action == 'edit') {
	if(!isset($_GET['id'])){
		header('Location: ../index.php');
		exit;
	}
	
	$a = Capsule::table('ads')->where('id',$_GET['id'])->first();

	if(!$a){
		header('Location: ../index.php');
		exit;
	}

	$v = new Violin;
	$v->validate(['code|HTML Code' => [$_POST['code'], 'required']]);
	if(!$v->passes()){
		$_SESSION['flash'] = $v->errors()->first();
		header('Location: ../editads.php');
		exit;
	}

	function isHtml($string){
     	preg_match("/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/",$string, $matches);
     	if(count($matches)==0){
        	return FALSE;
      	}else{
        	return TRUE;
      	}
	}

	if(!isHTML($_POST['code'])){
		$_SESSION['flash'] = 'Please enter a HTML code.';
		header('Location: ../ads.php');
		exit;
	}

	Capsule::table('ads')->where('id',$_GET['id'])->update(['code' => $_POST['code']]);
	$_SESSION['success'] = 'Advertisement was successfully updated.';
	header('Location: ../adslist.php');
	exit;
}

//Remove ADS
if($action == 'remove') {
	if(!isset($_GET['id'])){
		header('Location: ../index.php');
		exit;
	}
	$a = Capsule::table('ads')->where('id',$_GET['id'])->first();
	if(!$a){
		header('Location: index.php');
		exit;
	}
	
	Capsule::table('ads')->where('id',$_GET['id'])->delete();
	$_SESSION['success'] = 'Advertisement was successfully deleted.';
	header('Location: ../adslist.php');
	exit;
}

//If the action don't exists
header('Location: ../index.php');
exit;