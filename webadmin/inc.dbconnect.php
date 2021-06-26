<?php
  // Dades per a la connexio a la BBDD
  $DDBB_HOST = "mansilladisseny.com";
  $DDBB_USER = "mymansilla";          // Usat nomes pel MySQL
  $DDBB_PWD = "UApYHMnB";    // Usat nomes pel MySQL
  $DDBB_NAME = "pescanova";

  // Funcio per connectar a la BBDD
  function Connectar() {
    global $DDBB_HOST, $DDBB_USER, $DDBB_PWD, $DDBB_NAME;

    $connector = mysqli_connect( $DDBB_HOST, $DDBB_USER, $DDBB_PWD, $DDBB_NAME) or die("No DB connect. Error (".mysqli_connect_errno().") ".mysqli_connect_error());
    @mysqli_query($connector, "SET NAMES 'utf8'");


    return $connector;
  }

?>