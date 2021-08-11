<?php
session_start();

$central = $_SESSION["central"];

$_SESSION = array();
session_destroy();

//$central = (isset($_GET['central']) && $_GET['central'] == 1) ? '?central=1' : '';
//Header("Location: index.php$central");
Header("Location: index.php?central=".$central);
die;
?>
