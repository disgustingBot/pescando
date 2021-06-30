<?php
  /* Definiciones */
  $MESES["01"] = "Enero";
  $MESES["02"] = "Febrero";
  $MESES["03"] = "Marzo";
  $MESES["04"] = "Abril";
  $MESES["05"] = "Mayo";
  $MESES["06"] = "Junio";
  $MESES["07"] = "Julio";
  $MESES["08"] = "Agosto";
  $MESES["09"] = "Septiembre";
  $MESES["10"] = "Octubre";
  $MESES["11"] = "Noviembre";
  $MESES["12"] = "Diciembre";


  function Mayus($variable) {
    return strtr( strtoupper(trim($variable)),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
  }

  function Minus($variable) {
    return strtr( strtolower(trim($variable)),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü");
  }

  function Blank2Underline($variable) {
    return strtr( $variable, " ", "_" );
  }

  function Blank2None($variable) {
    return strtr( $variable, " ", "" );
  }

  function Blank2Dash($variable) {
    return strtr( $variable, " ", "-" );
  }

  function Quote2Accent($variable) {
    return strtr( $variable, "\"'", "´´");
  }

  function Quote2Underline($variable) {
    return strtr( $variable, "\"'", "__" );
  }

  function LimpiaNombre($variable) {
    $var = str_replace("´","", Quote2Accent($variable));
    $var = Minus($var);
    $var = remove_accents($var);
    $var = Blank2Dash($var);
    return $var;
  }

  function Limpia($variable) {
    $allowed = "/[^a-z0-9.-]/i";
    $var = Quote2Accent($variable);
    $var = preg_replace( $allowed, " ", $var);
    $var = Blank2None($var);
    return $var;
  }

  function ShowVar($var, $nom="") {
    if ( is_array($var) ) {
      echo "<pre>";
      print_r($var);
      echo "</pre><br />";
    } else {
      if ( $nom != "" ) echo $nom.": ";
      echo $var."<br />";
    }
  }

  function CalcPes($valor) {
    if ( $valor < 1024 ) {
      $pes = number_format($valor, 2, ",", ".")." b";
    } else {
      $val = $valor / 1024;
      if ( $val > 1024 ) {
        $val = $val / 1024;
        $pes = number_format( $val, 2, ",",".")." Mb";
      } else {
        $pes = number_format( $val, 2, ",", ".")." Kb";
      }
    }
    return $pes;
  }

  function GeneraData($data,$num,$lang="cat") {
    if ( strlen($data) < $num ) return "ERROR";
    if ( $lang == "eng" ) {
      if ( $num == 8 ) return substr($data,4,2)."/".substr($data,6,2)."/".substr($data,0,4);
      if ( $num == 12 ) return substr($data,4,2)."/".substr($data,6,2)."/".substr($data,0,4)." ".substr($data,8,2).":".substr($data,10,2);
      if ( $num == 14 ) return substr($data,4,2)."/".substr($data,6,2)."/".substr($data,0,4)." ".substr($data,8,2).":".substr($data,10,2).":".substr($data,12,2);
    } else {
      if ( $num == 8 ) return substr($data,6,2)."/".substr($data,4,2)."/".substr($data,0,4);
      if ( $num == 12 ) return substr($data,6,2)."/".substr($data,4,2)."/".substr($data,0,4)." ".substr($data,8,2).":".substr($data,10,2);
      if ( $num == 14 ) return substr($data,6,2)."/".substr($data,4,2)."/".substr($data,0,4)." ".substr($data,8,2).":".substr($data,10,2).":".substr($data,12,2);
    }
  }

  function GeneraDataTimestamp($data,$gen=1) {
    $dt = substr($data,0,4).substr($data,5,2).substr($data,8,2).substr($data,11,2).substr($data,14,2).substr($data,17,2);
    if ( $gen ) return GeneraData($dt, 14);
    return $dt;
  }

  function ValidExt($filename, $group="nophp") {
    $ext = Minus(substr( $filename, strrpos( $filename, "." ) ));
    if ( $group == "nophp" ) {
      if ( $ext == ".php" || $ext == ".phtml" || $ext == ".php3" || $ext == ".php4" ) return 1;
    } else if ( $group == "image" ) {
      if ( $ext == ".jpg" || $ext == ".gif" || $ext == ".png" || $ext == ".jpeg" || $ext == ".bmp" ) return 1;
    } else if ( $group == "flash" ) {
      if ( $ext == ".flv" || $ext == ".swf" ) return 1;
    } else if ( $group == "doc-pdf" ) {
      if ( $ext == ".pdf" || $ext == ".rtf" || $ext == ".docx" || $ext == ".doc" ) return 1;
    } else if ( $group == "doc" ) {
      if ( $ext == ".pdf" || $ext == ".rtf" || $ext == ".docx" || $ext == ".doc" || $ext == ".xlsx" || $ext == ".xls" || $ext == ".ppt" || $ext == ".pps" ) return 1;
    } else if ( $group == "gif-jpg" ) {
      if ( $ext == ".jpg" || $ext == ".gif" || $ext == ".jpeg" ) return 1;
    } else if ( $group == "any" ) {
      return 1;
    }

    return 0;
  }

  function GeneraClauAleatoria($length=8) {

    # first character is capitalize
    $pass = chr(mt_rand(65,90));    // A-Z;

    # rest are either 0-9 or a-z
    for($k=0; $k < $length - 1; $k++) {
      $probab = mt_rand(1,10);

      if ( $probab <= 7 )   // a-z probability is 70%
        $pass .= chr(mt_rand(97,122));
      else if ( $probab <= 9 )             // 0-9 probability is 20%
        $pass .= chr(mt_rand(48, 57));
      else
        $pass .= chr(mt_rand(65,90));    // A-Z
    }
    return $pass;
  }

  function EnviaEmail($from,$from_name,$dest,$dest_name,$subj,$body,$bodyHtml,$attachments="",$cc="") {
    global $GENERAL;

    $enviat = 0;

    $ara = new PHPMailer();
    $ara->IsSMTP();
    $ara->IsHTML(true);
    $ara->Hostname = "localhost";
    $ara->SMTPAuth = true;

    $ara->CharSet = 'UTF-8';
    
    $ara->Host = "authsmtp.pescanova.com";
    $ara->Username = "noreply@pescanova.com";
    $ara->Password = "yM73nRoe22P!";
    
    if ( $from == "" ) $ara->From = "noreply@pescanova.com";
    else $ara->From = $from;
    if ( $from_name == "" ) $ara->FromName = "Pescanova";
    else $ara->FromName = $from_name;
    $ara->Subject = $subj;
    $ara->Body = $bodyHtml;
    $ara->AltBody = $body;

    $ara->AddBCC("pepus@pepus.net","Pepus");

    if ( is_array($cc) ) {
      foreach ( $cc as $m => $n ) {
        $ara->AddCC($n["email"],$n["nom"]);
      }
    }
    if ( is_array($attachments) ) {
      foreach ( $attachments as $k => $v ) {
        if ( $v["size"] > 0 ) $ara->AddAttachment($v["tmp_name"], $v["name"]);
      }
    }
    $ara->AddAddress(trim($dest), $dest_name);
    $enviat = $ara->Send();

    return $enviat;
  }


  function Log_Action($userid,$action) {
    global $conn;

    $result = @mysqli_query($conn, "INSERT INTO pesca_adminusers_logs VALUES ('', '".mysqli_real_escape_string($conn, $userid)."', '".date("YmdHis")."', '".$_SERVER["REMOTE_ADDR"]."','".mysqli_real_escape_string($conn, $action)."')");
  }

  function EsAdmin() {
    if ( $_SESSION["PESCA_ADMIN_TYPE"] == "admin" ) return 1;
    return 0;
  }
  function EsBasico() {
    if ( $_SESSION["PESCA_ADMIN_TYPE"] == "basico" ) return 1;
    return 0;
  }

  function ExisteTextoLang( $referred, $referred_id, $field, $lang ) {
    global $conn;

    $q = "SELECT value FROM pesca_textos WHERE referred = '".mysqli_real_escape_string($conn, $referred)."' AND referred_id = '".mysqli_real_escape_string($conn, $referred_id)."' AND field = '".mysqli_real_escape_string($conn, $field)."' AND lang = '".mysqli_real_escape_string($conn, $lang)."' ";
    return @mysqli_num_rows(@mysqli_query($conn, $q));
  }

  function GetTextoLang( $referred, $referred_id, $field, $lang ) {
    global $conn;

    $q = "SELECT value FROM pesca_textos WHERE referred = '".mysqli_real_escape_string($conn, $referred)."' AND referred_id = '".mysqli_real_escape_string($conn, $referred_id)."' AND field = '".mysqli_real_escape_string($conn, $field)."' AND lang = '".mysqli_real_escape_string($conn, $lang)."' ";
    $r = @mysqli_query($conn, $q);
    if ( $r ) {
      $v = @mysqli_fetch_assoc($r);
      @mysqli_free_result($r);
      return $v["value"];
    }
    return "";
  }

  function ExisteTraduccionLang( $interactiu, $pantalla, $field, $lang ) {
    global $conn;

    $q = "SELECT value FROM pesca_translates WHERE interactiu = '".mysqli_real_escape_string($conn, $interactiu)."' AND pantalla = '".mysqli_real_escape_string($conn, $pantalla)."' AND field = '".mysqli_real_escape_string($conn, $field)."' AND lang = '".mysqli_real_escape_string($conn, $lang)."' ";
    return @mysqli_num_rows(@mysqli_query($conn, $q));
  }

  function GetTraduccionLang( $interactiu, $pantalla, $field, $lang ) {
    global $conn;

    $q = "SELECT value FROM pesca_translates WHERE interactiu = '".mysqli_real_escape_string($conn, $interactiu)."' AND pantalla = '".mysqli_real_escape_string($conn, $pantalla)."' AND field = '".mysqli_real_escape_string($conn, $field)."' AND lang = '".mysqli_real_escape_string($conn, $lang)."' ";
    $r = @mysqli_query($conn, $q);
    if ( $r ) {
      $v = @mysqli_fetch_assoc($r);
      @mysqli_free_result($r);
      return $v["value"];
    }
    return "";
  }


  function Percent($total, $num ) {
    if ( $total == 0 ) return 0;
    
    $calc = ($num * 100 ) / $total;
    
    return $calc;
  }

  function remove_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    $chars = array(
    // Decompositions for Latin-1 Supplement
    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
    chr(195).chr(191) => 'y',
    // Decompositions for Latin Extended-A
    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
  }

  // Functiones interactivos
  function get_strings() {
    global $interactiu, $conn;

    // Elementos de la pantalla
    $query = "SELECT field, value FROM pesca_translates WHERE interactiu = '".$interactiu."' AND lang = '".$_SESSION["lang"]."'";
    $res = mysqli_query($conn, $query);
    $strings = array();
    while ( $res && $row = mysqli_fetch_assoc($res) ) {
      $strings[$row["field"]] = $row["value"];
    }
    mysqli_free_result($res);
    return $strings;
  }

  function get_sounds(){
    global $conn;
    
    $sounds = array();
    $qry = "SELECT *, ( select value FROM pesca_textos WHERE referred = 'sonidos' AND referred_id = son_id AND lang='".$_SESSION["lang"]."' and field = 'nombre') as tra_nombre_son
                    FROM pesca_sonidos WHERE son_status = 'A' ORDER BY son_orden";
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $sounds[] = $row;
      }
    }
    $sounds = array_map(function($sound){
      $sound['slug'] = LimpiaNombre($sound['son_nombre']);
      return $sound;
    }, $sounds);
    return $sounds;
  }

  function get_ship_types() {
    global $conn;
    
    $ship_types = array();
    $qry = "SELECT *, ( select value FROM pesca_textos WHERE referred = 'tipos-barcos' AND referred_id = tba_id AND lang='".$_SESSION["lang"]."' and field = 'nombre') as tra_nombre_tba
                    , ( select value FROM pesca_textos WHERE referred = 'tipos-barcos' AND referred_id = tba_id AND lang='".$_SESSION["lang"]."' and field = 'descr') as tra_descr_tba
                    , ( select value FROM pesca_textos WHERE referred = 'tipos-barcos' AND referred_id = tba_id AND lang='".$_SESSION["lang"]."' and field = 'pesca') as tra_pesca_tba
                    , ( select value FROM pesca_textos WHERE referred = 'tipos-barcos' AND referred_id = tba_id AND lang='".$_SESSION["lang"]."' and field = 'barcos') as tra_barcos_tba
                    FROM pesca_tipos_barcos WHERE tba_status = 'A'";
    // $qry2 = "SELECT * FROM pesca_animales a, pesca_especies b WHERE a.ani_especie = b.esp_id";
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $ship_types[] = $row;
      }
    }
    $ship_types = array_map(function($specie){
      $specie['slug']     = LimpiaNombre($specie['tra_nombre_tba']);
      return $specie;
    }, $ship_types);
    return $ship_types;
  }

  function get_ships() {
    global $conn;
    
    $ships = array();
    $qry = "SELECT * FROM pesca_barcos LEFT JOIN pesca_caladeros ON cal_id = bar_caladero WHERE cal_status = 'A' AND bar_status = 'A'";
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $ships[] = $row;
      }
    }
    $ships = array_map(function($ship){
      $ship['cal_posy'] = $ship['cal_posy'] * 100 / 1080;
      $ship['cal_posx'] = $ship['cal_posx'] * 100 / 1920;
      return $ship;
    }, $ships);
    return $ships;
  }


  function get_lineas(){
    global $conn;
    
    $lineas = array();
    $qry = "SELECT *, ( select value FROM pesca_textos WHERE referred = 'areas' AND referred_id = are_id AND lang='".$_SESSION["lang"]."' and field = 'nombre') as tra_nombre_area
                    FROM pesca_areas WHERE are_status = 'A' ORDER BY are_orden";
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $lineas[] = $row;
      }
    }
    $lineas = array_map(function($linea){
      $linea['slug'] = LimpiaNombre($linea['tra_nombre_area']);
      return $linea;
    }, $lineas);
    return $lineas;
  }

  function get_detalles() {
    global $conn;

    $barcos = array();
    $qry = "SELECT *, ( SELECT value FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = bde_id AND lang = '".$_SESSION["lang"]."' AND field = 'imagen' ) as svg
                    , ( SELECT value FROM pesca_textos WHERE referred = 'barcos-detalles' AND referred_id = bde_id AND lang = '".$_SESSION["lang"]."' AND field = 'bde_nombre' ) as nombre
                    FROM pesca_barcos_detalles WHERE bde_status = 'A' ORDER BY bde_orden";

    // aqui el vid_barco va es donde se elije el barco
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $barcos[] = $row;
      }
    }
    $barcos = array_map(function($barco){
      $barco['slug']     = LimpiaNombre($barco['bde_nombre']);
      return $barco;
    }, $barcos);
    return $barcos;
  }


  function get_clickables($id) {
    global $conn;

    $clickables = array();
    // aqui el vid_barco va es donde se elije el barco
    $qry = "SELECT vid_zona AS slug, bde_nombre AS barco, vid_tipo AS type, vid_fichero AS media FROM pesca_videos LEFT JOIN pesca_barcos_detalles ON vid_barco = bde_id WHERE vid_barco = $id;";
    if ( $result = mysqli_query($conn, $qry) ) {
      while ( $row = mysqli_fetch_assoc($result) ) {
        $clickables[] = $row;
      }
    }
    $clickables = array_map(function($object){
      $object['barco']     = LimpiaNombre($object['barco']);
      return $object;
    }, $clickables);
    return $clickables;
  }

?>