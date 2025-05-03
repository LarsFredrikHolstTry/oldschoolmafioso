<?php 

if(!isset($_SESSION)) {
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
    ini_set('session.gc_maxlifetime',  60 * 60 * 24 * 100);
    session_start(); 
} 

$username = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($username, $user, $pass, $db);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: "; //. mysqli_connect_error();
}

?>