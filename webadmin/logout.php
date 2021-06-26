<?php
  require_once("inc.config.php");

  Log_Action($_SESSION["PESCA_ADMIN_ID"],"logout");

  $_SESSION = array();
  session_destroy();

  Header("Location: login.php");
  exit;
?>