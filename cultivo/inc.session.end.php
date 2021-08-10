<?php
session_start();

$_SESSION = array();
session_destroy();

Header("Location: index.php");
die;
?>
