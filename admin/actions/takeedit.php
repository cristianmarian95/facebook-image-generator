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
    'title|Title'   => [$_POST['title'], 'required'],
    'question|Question'   => [$_POST['question'], 'required|max(50)'],
    'answer|Answers'   => [$_POST['answer'], 'required'],
]);

if(!$v->passes()) {
    $_SESSION['flash'] = $v->errors()->first();
    header('Location: ../edit.php?id=' . $_GET['id']);
    exit;
}

if(isset($_POST['update'])){

    if(!isset($_FILES['upload'])){
        header('Location: ../edit.php?id=' . $_GET['id']);
        exit;
    }

    $upload = new Upload;
    $file = $_FILES['upload'];

    function generate($length = 5) {
            $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charLength = strlen($char);
            $rString = '';
            for ($i = 0; $i < $length; $i++) {
                $rString .= $char[rand(0, $charLength - 1)];
            }
            return $rString;
    }

    $name = generate();
    $upload->setFile($file);
    $upload->setFileName($name);
    $upload->setAllowedExtensions(['jpeg','jpg']);
    $upload->setMaximumFileSize(5000000);
    $upload->setUploadDir(__DIR__ . '/../../storage/backgrounds/');

    //Check if image is uploaded
    if (!$upload->isUploaded()) {
        $_SESSION['flash'] = $upload->getFirstError();
        header('Location: ../edit.php?id=' . $_GET['id']);
        exit;
    }

    $url = $name . '.' . $upload->getExtension();
    unlink('../../storage/backgrounds/' . $_POST['img']);

}else{

    $url = $_POST['img'];

}

Capsule::table('questions')->where('id',$_GET['id'])->update([
    'url' => $url,
    'title' => $_POST['title'],
    'question' => $_POST['question'],
    'answers' => $_POST['answer']
    ]);
$_SESSION['success'] = 'Your quize was add.';
header('Location: ../edit.php?id=' . $_GET['id']);
exit;