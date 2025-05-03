<?php

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 

$sql = "SELECT * FROM filmproduction WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_mp = mysqli_fetch_assoc($query);

$ID =                        $row_mp['ID'];
$sertificate =               $row_mp['sertificate'];
$level =                     $row_mp['level'];
$filmproduction_status =     $row_mp['filmproduction_status'];
$filmproduction_seconds =    $row_mp['filmproduction_seconds'];

// Objekter
$object_name[0] =   "Sony A7 III";
$object_image[0] =  'background-image: url("img/objects/sony.png")';
$object_text[0] =   "Supert kamera for filming.";
if($role == 1){
    $object_price[0] =  230000 * 0.9;
} else {
    $object_price[0] =  230000;
}
    
$object_name[1] =   "Røde VideoMic Go";
$object_image[1] =  'background-image: url("img/objects/rode.png")';
$object_text[1] =   "Super mikrofon for filming.";
if($role == 1){
    $object_price[1] =  23000 * 0.9;
} else {
    $object_price[1] =  23000;
}

$object_name[2] =   "Mac Pro (2020)";
$object_image[2] =  'background-image: url("img/objects/macbook.png")';
$object_text[2] =   "Super PC for redigering.";
if($role == 1){
    $object_price[2] =  555190 * 0.9;
} else {
    $object_price[2] =  555190;
}

/* KOMMER SENERE
$object_name[3] =   "Norsk pass";
$object_image[3] =  'background-image: url("img/objects/pass.png")';
$object_text[3] =   "For menneskesmugling.";
$object_price[3] =  4000;
*/


?>


<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Sorte marked</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            
<?php

if(isset($_POST['0'])){
    if($money < $object_price[0]){
        echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du har ikke nok penger til å kjøpe '.$object_name[0].'.</span> 
        </div>';
    } else {
        if($sertificate == 1){
            $result = "UPDATE filmproduction SET sertificate = ($sertificate + 1) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = ($money - $object_price[0]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            echo '<div class="feedback velykket">
                <span><b>Velykket!</b> Du kjøpte '.$object_name[0].' for '.number($object_price[0]).' kr.</span> 
            </div>';
        } elseif($sertificate == 0) {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du må ha sertifikat før du kan kjøpe dette!</span> 
            </div>';
        } else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har allerede '.$object_name[0].'.</span> 
            </div>';
        }
    }
} elseif(isset($_POST['1'])){
    if($money < $object_price[1]){
        echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du har ikke nok penger til å kjøpe '.$object_name[1].'.</span> 
        </div>';
    } else {
        if($sertificate == 2){
            $result = "UPDATE filmproduction SET sertificate = ($sertificate + 1) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = ($money - $object_price[1]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            echo '<div class="feedback velykket">
                <span><b>Velykket!</b> Du kjøpte '.$object_name[1].' for '.number($object_price[1]).' kr.</span> 
            </div>';
        } elseif($sertificate == 0) {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du må ha sertifikat før du kan kjøpe dette!</span> 
            </div>';
        }  else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har allerede '.$object_name[1].' eller så mangler du kamera.</span> 
            </div>';
        }
    }
} elseif(isset($_POST['2'])){
    if($money < $object_price[2]){
        echo '<div class="feedback mislykket">
            <span><b>Mislykket!</b> Du har ikke nok penger til å kjøpe '.$object_name[2].'.</span> 
        </div>';
    } else {
        if($sertificate == 3){
            $result = "UPDATE filmproduction SET sertificate = ($sertificate + 1) WHERE acc_id='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $result = "UPDATE accounts SET money = ($money - $object_price[2]) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            echo '<div class="feedback velykket">
                <span><b>Velykket!</b> Du kjøpte '.$object_name[2].' for '.number($object_price[2]).' kr.</span> 
            </div>';
        } elseif($sertificate == 0) {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du må ha sertifikat før du kan kjøpe dette!</span> 
            </div>';
        }  else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Du har allerede '.$object_name[2].'  eller så mangler du kamera og mikrofon.</span> 
            </div>';
        }
    }
}
            
            ?>
            <div class="header">
                <span>Sorte marked</span>
            </div>
            <img src="img/action/sortemarked.png" style="width: 100%; height: auto;">
            <p style="padding: 0 10px; text-align: center;">Trykk på bildet til det du ønsker å kjøpe</p>
            <div class="role_container">
                <form method="POST" action="">
                <?php for($i = 0; $i < 3; $i++){ ?>
                <button name="<?php echo $i ?>" type="submit"> 
                    <div class="role_<?php echo $i ?>">
                        <style>
                            
                        .role_<?php echo $i ?> {
                            position: relative;
                            width: 160px;
                            height: 208px;
                            margin: 5px;
                            float: left;
                            display: inline-block;
                             transition: 0.3s;
                            border: 1px solid #2c2c2c;
                        }
                            
                        .role_<?php echo $i ?> {
                            <?php echo $object_image[$i] ?>
                        }

                        .role_<?php echo $i ?>:hover {
                            <?php echo $object_image[$i] ?>
                        }
                        </style>
                        <div class="header">
                            <span><?php echo $object_name[$i] ?></span>
                        </div>
                        <div class="role_footer">
                            <p style="margin: 0; padding: 5px">
                                <?php echo $object_text[$i] ?><br>
                                <b>Pris: </b><?php echo number($object_price[$i]); ?> kr
                            </p>
                        </div>
                    </div>
                </button>
                <?php } ?>
                </form>
            </div>
        </div>
    </body>
</html>
<?php } ?>
