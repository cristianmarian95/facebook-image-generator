<?php
//Register Vendor
require __DIR__ . '/vendor/autoload.php';

//Website Settings
$title = 'Home';
$url = 'http://localhost/';

//Require the template
require __DIR__ . '/templates/header.view.php';
require __DIR__ . '/templates/home.view.php';
require __DIR__ . '/templates/footer.view.php';

?>