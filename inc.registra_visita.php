<?php

  // // registramos la visita
  // $this_url = $_SERVER["PHP_SELF"];
  // if ( $_SERVER["QUERY_STRING"] != "" ) $this_url .= "?".$_SERVER["QUERY_STRING"];
  //
  // $my_pantalla = ( isset($pantalla) ? $pantalla : ( $_GET["pantalla"] != "" ? $_GET["pantalla"] :""));
  // $my_interactiu = ( isset($interactiu) ? $interactiu : ( $_GET["interactiu"] != "" ? $_GET["interactiu"] :""));
  // $my_lang =  ( isset($_SESSION["lang"]) ? $_SESSION["lang"] : ( $_GET["lang"] != "" ? $_GET["lang"] :""));
  // $elemento = $_GET["elemento"];
  //
  // $query = "INSERT INTO pesca_visitas (
  //     vis_idioma,
  //     vis_interactivo,
  //     vis_pantalla,
  //     vis_momento,
  //     vis_elemento
  //   ) VALUES (
  //     '".mysqli_real_escape_string($conn, $my_lang)."',
  //     '".mysqli_real_escape_string($conn, $my_interactiu)."',
  //     '".mysqli_real_escape_string($conn, $my_pantalla)."',
  //     CURRENT_TIMESTAMP(),
  //     '".mysqli_real_escape_string($conn, $elemento)."'
  //   )";
  // $res = @mysqli_query($conn, $query);

?>
