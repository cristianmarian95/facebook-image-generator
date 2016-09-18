<?php
session_start();

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

if(!Capsule::schema()->hasTable('users','images','configs')){

	Capsule::schema()->create('users', function($table)
	{
	    $table->increments('id');
	    $table->string('email');
	    $table->string('password');
	    $table->timestamps();
	});
	Capsule::schema()->create('questions', function($table)
	{
	    $table->increments('id');
	    $table->string('url');
	    $table->string('title');
	    $table->string('question');
	    $table->longtext('answers');
	    $table->timestamps();
	});
	Capsule::schema()->create('images', function($table){
		$table->increments('id');
		$table->string('key');
		$table->string('image');
		$table->string('qid');
		$table->timestamps();
	});
	Capsule::schema()->create('configs', function($table)
	{
	    $table->increments('id');
	    $table->string('title');
	    $table->string('brand');
	    $table->string('path');
	    $table->string('app_id');
	    $table->string('app_secret');
	    $table->string('app_version');
	    $table->timestamps();
	});

	//Insert the default values
	Capsule::table('configs')->insert([
		'title' => 'Quizes', 
		'brand' => 'Quizes',
		'path' => '',
		'app_id' => '1660146810869707',
		'app_secret' => '86526e14069bc0f6f27352a643350123',
		'app_version' => '2.5'
		]);
	Capsule::table('users')->insert([
		'email' => 'admin@demo.com', 
		'password' => password_hash('admin', PASSWORD_DEFAULT)
		]);

	echo '<center>';
	echo 'Website Installed</br >';
	echo '<font color="red">Please login to Admin CP and update the website path</font><br />';
	echo 'Admin Page: <a href="login.php">Admin ACP</a></br >';
	echo 'Admin User: admin@demo.com</br >';
	echo 'Admin Page: admin</br >';
	echo '</center>';

}else{
	echo '<center><font color="red">Please delete the install.php file!</font></center>';
}