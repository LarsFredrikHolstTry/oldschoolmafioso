<?php

$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

$result = "UPDATE accounts SET bank_money = (bank_money * 1.1) WHERE bank_money < 500000001";
mysqli_query($con, $result) or die("Bad query: $result");

$result = "UPDATE daily_exp SET exp = 0";
mysqli_query($con, $result) or die("Bad query: $result");

?>
