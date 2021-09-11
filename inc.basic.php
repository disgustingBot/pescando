<?php
  session_name("PESCA_WEBSESSION");
  session_start();

  require_once("webadmin/inc.dbconnect.php");
  $conn = Connectar();

  $LANGS = array();
  $LANG_MENU = array();
  $q0 = "SELECT lng_code, lng_title FROM pesca_langs WHERE lng_status = 'A' ORDER BY lng_orden, lng_code";
  if ( $r0 = mysqli_query($conn,$q0) ) {
    while ( $rw0 = mysqli_fetch_assoc($r0) ) {
      $LANGS[] = $rw0["lng_code"];
      $LANG_MENU[$rw0["lng_code"]] = $rw0["lng_title"];
    }
    mysqli_free_result($r0);
  }

  $lang = "esp";
  if ( isset($_SESSION["lang"]) && $_SESSION["lang"] != "" ) $lang = $_SESSION["lang"];
  if ( isset($_GET["lang"]) && $_GET["lang"] != "" ) {
    $_GET["lang"] = trim($_GET["lang"]);
    if ( in_array( $_GET["lang"], $LANGS )  ) {
      $lang = $_GET["lang"];
    }
  }
  $_SESSION["lang"] = $lang;

  require_once("webadmin/inc.funcs.php");

  $website_title = "PESCANOVA BIOMARINE CENTER";

  $MAIN_URL = "https://www.mansilladisseny.com/pescanova/";
  $SERVER_URL = $MAIN_URL;

  $DIR_DOCS = "../uploads/";
  $DIR_ICONS = "../icons/";
  $DIR_IMG = "../images/";
  $DIR_SONIDOS = "../mp3/";
  $DIR_MEDIA = "../media/";
  $DIR_IMG = "https://mansilladisseny.com/pescanova/images/";
  $DIR_VIDEOS = "https://mansilladisseny.com/pescanova/media/";
  $DIR_MEDIA = "https://mansilladisseny.com/pescanova/media/";

  $ERR = "";
  $MSG = "";

  $ipPantalla = $_SERVER["REMOTE_ADDR"];

  $q0 = "SELECT scr_url FROM pesca_screens WHERE scr_ip = '".$ipPantalla."' ";
  $r0 = @mysqli_query($conn, $q0);
  if ( $r0 && mysqli_num_rows($r0) == 1 ) {
    $row = mysqli_fetch_assoc($r0);
    $redirectUrl = $row["scr_url"];
    @mysqli_free_result($r0);
  }

?>
