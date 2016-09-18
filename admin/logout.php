<?php
session_start();
session_unset($_SESSION['uid']);
session_destroy($_SESSION['uid']);

header('Location: ../index.php');
exit;
?>
