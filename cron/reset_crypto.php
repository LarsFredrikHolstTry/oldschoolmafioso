<?php

$username = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($username, $user, $pass, $db);

$result = "UPDATE crypto_farm SET status = 1 WHERE status = 0";
mysqli_query($con, $result) or die("Bad query: $result");

?>
