<?php

$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

$result = "UPDATE bank_accounts SET amount = (amount * 0.99) WHERE amount > 1";
mysqli_query($con, $result) or die("Bad query: $result");

?>
