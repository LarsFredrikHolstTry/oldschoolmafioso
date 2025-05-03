<?php 

if(!isset($_SESSION)) {
    session_start(); 
} 

$username = "cpanel86.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso";

$con = mysqli_connect($username, $user, $pass, $db);

if (mysqli_connect_errno()){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>