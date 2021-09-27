<!DOCTYPE html>
<!--[if IE 9]> <html lang="es" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ca">
<!--<![endif]-->

	<head>

		<meta charset="utf-8">
		<title>Pepus.net</title>
		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

	</head>

	<body style="background-color:#333;">

<?php

  $DIR_IMG = "http://www.pepus.net/img/";

  function Minus($variable) {
    return strtr( strtolower(trim($variable)),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü");
  }

  function GetIcon($fitxer) {
    global $DIR_IMG;

    $suf = substr(Minus($fitxer),-3);
    if ( $suf == "xls" ) $ico = "excel.gif";
    else if ( $suf == "gif" ) $ico = "gif.gif";
    else if ( $suf == "jpg" ) $ico = "jpg.gif";
    else if ( $suf == "doc" || $suf == "rtf" ) $ico = "word.gif";
    else if ( $suf == "pps" || $suf == "ppt" ) $ico = "ppt.gif";
    else if ( $suf == "pdf" ) $ico = "pdf.gif";
    else if ( $suf == "zip" || $suf == "rar" || $suf == "ace" ) $ico = "zip.gif";
    else if ( $suf == "htm" || $suf == "tml" || $suf == "php" ) $ico = "www.gif";
    else $ico = "doc.gif";
    return $ico;
  }

  $ruta = "./";
  $handle = dir($ruta);
  $filelist = array();
  while ($file = $handle->read()) {
    if ( $file != ".." && $file != "." && $file != "index.php" ) {
      if ( is_dir ($ruta.$file)) {
        $file .= "/";
      }
      $filelist[] = $file;
    }
  }

  if ( count($filelist) > 0 ) asort($filelist);

  $mida = 240;

  foreach($filelist as $a=>$b ) {
    $suf = Minus(substr($b,-3));
    echo "<div style=\"float: left; max-width: ".$mida."px; max-height: ".$mida."px; text-align: center; margin: 10px;\">";
    echo "<a href=\"".$ruta.$b."\" style=\"font-family: Verdana; size: 10px; text-decoration: none; color: #000000; \" target=\"_blank\">";
    if ( $suf == "jpg" || $suf == "gif" || $suf == "png" || $suf == "svg" ) {
      echo "<img src=\"".$ruta.$b."\" border=\"0\" alt=\"".$b."\" title=\"".$b."\" width=\"".$mida."\" height=\"".$mida."\">";
    } else {
      echo "<img src=\"".$DIR_IMG.GetIcon($b)."\" border=0 align=absmiddle> ".$b;
    }
    echo "<br /><span style=\"color: white;\">".substr($b,0,-4)."</span>";
    echo "</a>";
    echo "</div>\n";
  }
?>

  </body>
</html>