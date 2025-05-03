<?php

$servername = "cpanel80.proisp.no";
$user = "mafiovrx";
$pass = "82vH84K24g9m+8";
$db = "mafiovrx_mafioso2";

$con = mysqli_connect($servername, $user, $pass, $db);

$price[1] = 100000000;
$price[2] = 350000000;
$price[3] = 850000000;

$result_avtalegiro = mysqli_query($con, "SELECT * FROM family WHERE NOT fam_avtalegiro = 0");
while($row_giro = mysqli_fetch_assoc($result_avtalegiro)) {
    $sql = "SELECT * FROM family WHERE ID='".$row_giro['ID']."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_fam = mysqli_fetch_assoc($query);
    
    $fam_bank = $row_fam['fam_bank'];
    $fam_avtalegiro = $row_fam['fam_avtalegiro'];
    $fam_bedrift = $row_fam['fam_bedrift'];

    $sql_leader = "SELECT * FROM family_member WHERE role = 1 AND family_id = '".$row_giro['ID']."'";
    $query_leader = mysqli_query($con, $sql_leader) or die (mysqli_error());
    $row_leader = mysqli_fetch_assoc($query_leader);
    
    $fam_leader = $row_leader['acc_id'];

    if($fam_bedrift > 0){
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('".$fam_leader."', 'Bedrift er allerede aktivert for familien og avtalegiroen blir utstatt til i morgen 00:10.', '".time()."')";
        $result = mysqli_query($con, $query);
    } elseif($fam_bank >= $price[$fam_avtalegiro]){
        $result = "UPDATE family SET fam_bedrift = $fam_avtalegiro, fam_bank = (fam_bank - '".$price[$fam_avtalegiro]."') WHERE ID = ".$row_giro['ID']."";
        mysqli_query($con, $result) or die("Bad query: $result");
    } else {
        $query = "INSERT into `varsel` (acc_id, text, date)
        VALUES ('".$fam_leader."', 'På grunn av manglede penger i familiebanken ble ikke avtalegiro aktivert.', '".time()."')";
        $result = mysqli_query($con, $query);
    }
}


?>
