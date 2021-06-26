<?php

  if ( basename($_SERVER["PHP_SELF"]) == "inc.checklogin.php" ) {
    echo "CALLING THIS FILE DIRECTLY IS NOT ALLOWED!";
    die();
  }

  #// Check if the user is logged in (as admin)

  if ( !is_array($_SESSION["PESCA_ADMIN"]) ) {
    Header("Location: logout.php");
    die;
  } else {
    #//

    $query = "SELECT adm_id, adm_type, adm_status FROM pesca_adminusers WHERE adm_id = ".mysqli_real_escape_string($conn, $_SESSION["PESCA_ADMIN_ID"])." AND adm_username = '".mysqli_real_escape_string($conn, $_SESSION["PESCA_ADMIN_USER"])."'";
    $res = @mysqli_query($conn, $query);
    if(!$res) {
      print "CANNOT CONNECT TO DATABASE!";
      exit;
    } else if ( @mysqli_num_rows($res) == 0 ) {
      Header("Location: logout.php");
      exit;
    } else {
      $usr = @mysqli_fetch_assoc($res);

      if ( $usr["adm_status"] != "A" ) {
        Header("Location: logout.php");
        exit;
      }
      $_SESSION["PESCA_ADMIN_TYPE"] = $usr["adm_type"];
    }
  }

?>
