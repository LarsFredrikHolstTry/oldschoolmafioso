<?php

$username = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($username, $user, $pass, $db);

$result = "UPDATE page_views SET value = 0 WHERE value > 1";
mysqli_query($con, $result) or die("Bad query: $result");

?>
