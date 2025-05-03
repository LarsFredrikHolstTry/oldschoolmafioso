<?php

include("db/db.php");

if(isset($_SESSION["ID"])) {
    $sql = "UPDATE accounts SET last_active=NOW() WHERE ID='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    mysqli_query($con, $sql);
} else {
    header("Location: logginn.php");
    exit(); 
}

?>