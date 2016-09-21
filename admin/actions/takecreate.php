<?php

session_start();

if(!isset($_SESSION['uid'])){
  header('Location: ../index.php');
  exit;
}

require_once '../../vendor/autoload.php';

use Violin\Violin;
use Violin\Upload;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$configs = require_once __DIR__ . '/../../configs/database.php';
$capsule->setAsGlobal();
$capsule->bootEloquent();
$capsule->addConnection($configs['mysql']);

$v = new Violin;

$v->validate([
    'title|Title'   => [$_POST['title'], 'required|max(50)'],
    'question|Question'   => [$_POST['question'], 'required|max(50)'],
    'answer|Answers'   => [$_POST['answer'], 'required'],
]);

if(!$v->passes()) {
    $_SESSION['flash'] = $v->errors()->first();
    header('Location: ../create.php');
    exit;
}

$answers = explode(',', $_POST['answer']);

foreach ($answers as $answer) {
    $v->validate(['answer|Answer' => [$answer, 'max(40)']]);
    if(!$v->passes()) {
        $_SESSION['flash'] = $v->errors()->first();
        header('Location: ../create.php');
        exit;
    }
}

if(!isset($_FILES['upload'])){
	header('Location: ../create.php');
	exit;
}

$upload = new Upload;
$file = $_FILES['upload'];

$name = generate();
$upload->setFile($file);
$upload->setFileName($name);
$upload->setAllowedExtensions(['jpeg','jpg']);
$upload->setMaximumFileSize(5000000);
$upload->setUploadDir(__DIR__ . '/../../storage/backgrounds/');

function generate($length = 5) {
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($char);
        $rString = '';
        for ($i = 0; $i < $length; $i++) {
            $rString .= $char[rand(0, $charLength - 1)];
        }
        return $rString;
    }


//Check if image is uploaded
if (!$upload->isUploaded()) {
    $_SESSION['flash'] = $upload->getFirstError();
    header('Location: ../create.php');
    exit;
}

Capsule::table('questions')->insert([
    'url' => $name . '.' . $upload->getExtension(),
    'title' => $_POST['title'],
    'question' => $_POST['question'],
    'answers' => $_POST['answer']
    ]);
$_SESSION['success'] = 'Your quize was add.!';
header('Location: ../create.php');
exit;