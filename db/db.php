<?php 

if(!isset($_SESSION)) {
    session_start(); 
} 

$servername = "localhost";
$user = "root";
$pass = "";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: ";
}

?>