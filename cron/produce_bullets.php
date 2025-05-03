<?php
/*
$servername = "localhost";
$user = "root";
$pass = "";
$db = "mafioso";
*/
$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

$price_pr_bullet = 1500000;
$chances = 6;

$result_bullets = mysqli_query($con, "SELECT * FROM kf WHERE bullets < 100");
while($row_bullets = mysqli_fetch_assoc($result_bullets)) {
    if($row_bullets['bullets'] < 100){
        $resterende = 100 - $row_bullets['bullets'];
        $total_produce_price = $resterende * $price_pr_bullet;
        
        if($resterende > 0){
            if($total_produce_price <= $row_bullets['kf_bank']){
                $result = "UPDATE kf SET bullets = (bullets + $resterende), kf_bank = (kf_bank - $total_produce_price), strike = 0 WHERE owner = '".$row_bullets['owner']."'";
                mysqli_query($con, $result) or die("Bad query: $result");

                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$row_bullets['owner']."', 'Det ble produsert kuler til din kulefabrikk.', '".time()."')";
                $result = mysqli_query($con, $query);
            } else {
                if($row_bullets['strike'] == $chances){
                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('".$row_bullets['owner']."', 'Kulefabrikken ble lagt ned på grunn av for lite kuler og for lite penger i KF banken for å produsere kuler.', '".time()."')";
                    $result = mysqli_query($con, $query);
                    
                    $del = mysqli_query($con, "DELETE FROM kf WHERE owner = '".$row_bullets['owner']."'") or die(mysqli_error()); 
                } else {
                    $result = "UPDATE kf SET strike = (strike + 1) WHERE owner = '".$row_bullets['owner']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $query = "INSERT into `varsel` (acc_id, text, date)
                    VALUES ('".$row_bullets['owner']."', 'Det ble forsøkt å produsere kuler i din kulefabrikk, på grunn av for lite penger i kf banken ble det ikke produsert kuler og du har dermed ".($chances - $row_bullets['strike'])." forsøk igjen før kulefabrikken blir lagt ned.', '".time()."')";
                    $result = mysqli_query($con, $query);
                }
            }
        }
    }
}

?>