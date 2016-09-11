<?php
namespace App;

class App
{
	public function __construct()
	{

	}

	public function render($files = []){
		foreach ($files as $file) {
			if (!file_exists(__DIR__ . '/../../templates/' . $file . '.view.php')){
				throw new \Exception('The template ' . $file . ' was not found!');
			}
			require __DIR__ . '/../../templates/' . $file . '.view.php';
		}
	}
}