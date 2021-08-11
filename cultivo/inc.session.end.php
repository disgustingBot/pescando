<?php
session_start();

$_SESSION = array();
session_destroy();

$central = (isset($_GET['central']) && $_GET['central'] == 1) ? '?central=1' : '';
Header("Location: index.php$central");
die;
?>
