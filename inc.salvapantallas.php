<?php

$redirect_time = 50;

$query = "SELECT timeout_int0".$interactiu." as timeout FROM pesca_master LIMIT 0,1";
$res = mysqli_query($conn, $query);
if ( !$res ) $to = 200;
else {
  $val = mysqli_fetch_assoc($res);
  $to = $val["timeout"];
  mysqli_free_result($res);
}
$redirect_time = $to;


?>
