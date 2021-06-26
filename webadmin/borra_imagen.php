<?
  require_once ("inc.config.php");
  require_once("inc.checklogin.php");

  $id = trim($_GET["id"]);
  $foto = trim($_GET["foto"]);
  $sec = trim($_GET["sec"]);

  if ( !isset($id) || !isset($sec) ) {
    Header("Location: index.php");
    die();
  }

  if ( $sec == "admin" ) {
    $pare = "adminusers.php";
    $ret = "adminusers_edit.php";
    $taula = "PESCA_adminusers";
    $prefix = "adm_";
    $primary = "id";
  } else if ( $sec == "langs" ) {
    $pare = "langs.php";
    $ret = "langs_edit.php";
    $taula = "PESCA_langs";
    $prefix = "lng_";
    $primary = "code";
  } else if ( $sec == "escenas" ) {
    $pare = "escenas.php";
    $ret = "escenas_edit.php";
    $taula = "PESCA_escenas";
    $prefix = "esc_";
    $primary = "id";
  } else {
    Header("Location: index.php");
    die();
  }

  $camp = $prefix.$foto;

  $q = "SELECT $camp as foto FROM ".$taula." WHERE ".$prefix.$primary." = '".mysqli_real_escape_string($conn, $id)."'";
  $r = mysqli_query($conn, $q);
  if ( !$r || mysqli_num_rows($r) != 1 ) {
    Header("Location: ".$pare);
    die();
  } else {
    $row = mysqli_fetch_assoc($r);
    if ( $row["foto"] != "" && file_exists($DIR_IMG.$row["foto"]) ) @unlink($DIR_IMG.$row["foto"]);

    mysqli_query($conn, "UPDATE ".$taula." SET $camp = '' WHERE ".$prefix.$primary." = '".mysqli_real_escape_string($conn, $id)."'");
  }

  Header("Location: ".$ret."?".$primary."=".$id);
  die();

?>