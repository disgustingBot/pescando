<?php
  session_name("PESCA_WEBADMINSESSION");
  session_start();

  require_once("inc.dbconnect.php");
  $conn = Connectar();

  require_once("inc.funcs.php");

  $website_title = "PESCANOVA";

  $MAIN_URL = "http://www.mansilladisseny.com/pescanova/";
  $SERVER_URL = $MAIN_URL;

  $DIR_DOCS = "../uploads/";
  $DIR_IMG = "../images/";
  $DIR_SONIDOS = "../mp3/";
  $DIR_VIDEOS = "../media/";

  $LANGS = array();
  $q0 = "SELECT lng_code FROM pesca_langs ORDER BY lng_orden, lng_code";
  if ( $r0 = mysqli_query($conn,$q0) ) {
    while ( $rw0 = mysqli_fetch_assoc($r0) ) {
      $LANGS[] = $rw0["lng_code"];
    }

    mysqli_free_result($r0);
  }

  $ERR = "";
  $MSG = "";

?>
