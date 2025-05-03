<?php
       
if($oppdrag == 3){
    $result = mysqli_query($con, "UPDATE oppdrag SET value='$bank_money' WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 4 && $vapen > 0){
    $result = mysqli_query($con, "UPDATE oppdrag SET value=1 WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 5 && $beskyttelse > 0){
    $result = mysqli_query($con, "UPDATE oppdrag SET value=1 WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 6){
$sql="SELECT * FROM cars WHERE (car_id = 5 AND city = 1) AND (km <= 40000) AND acc_id='$ID'";

    if($result=mysqli_query($con,$sql)){
        $rowcount=mysqli_num_rows($result);
        $result = mysqli_query($con, "UPDATE oppdrag SET value ='$rowcount' WHERE acc_id='$ID'") or die (mysqli_error($con));
    }

}

if($oppdrag == 13){
    $result = mysqli_query($con, "UPDATE oppdrag SET value='$bank_money' WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 14 && $vapen == 5){
    $result = mysqli_query($con, "UPDATE oppdrag SET value= 1 WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 15 && $beskyttelse == 3){
    $result = mysqli_query($con, "UPDATE oppdrag SET value= 1 WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 18 && $rank >= 3){
    $result = mysqli_query($con, "UPDATE oppdrag SET value= 1 WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 23){
    $result = mysqli_query($con, "UPDATE oppdrag SET value='$bank_money' WHERE acc_id='$ID'") or die (mysqli_error($con));
}

if($oppdrag == 34){
    $sql = "SELECT * FROM crypto_farm WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_cf = mysqli_fetch_assoc($query);
    
    $result = mysqli_query($con, "UPDATE oppdrag SET value='".$row_cf['rigg']."' WHERE acc_id='$ID'") or die (mysqli_error($con));
}

?>