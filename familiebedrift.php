<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else {
    
    
$sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_member = mysqli_fetch_assoc($query);
    
$family_id = $row_member['family_id'];
    
    if($family_id == $_GET['id']){

$sql = "SELECT * FROM family WHERE ID='".$family_id."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_family = mysqli_fetch_assoc($query);

$family_name = $row_family['name'];

    $familiebedrift_price[0] = 100000000; // 100 000 000
    $familiebedrift_price[1] = 250000000; // 250 000 000
    $familiebedrift_price[2] = 500000000; // 500 000 000
        

?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » Familie » </span><span style="color: #afafaf;">Familiebedrift</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
        
        if(isset($_POST['upgrade_familiebedrift'])){
            if($row_family['fam_bedrift'] == 0){
                if($familiebedrift_price[0] > $row_family['fam_bank']){
                    echo '<div class="feedback feilmelding">
                        <span>Det er ikke nok penger i familiekassen til å aktivere dette nivået.</span>
                    </div>';
                } else {
                    $result = "UPDATE family SET fam_bedrift = 1, fam_bank = (fam_bank - $familiebedrift_price[0]) WHERE ID='".$family_id."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=familiebedrift&id=".$_GET['id']."&oppgrader");
                }
            } elseif($row_family['fam_bedrift'] == 1){
                if($familiebedrift_price[1] > $row_family['fam_bank']){
                    echo '<div class="feedback feilmelding">
                        <span>Det er ikke nok penger i familiekassen til å aktivere dette nivået.</span>
                    </div>';
                } else {
                    $result = "UPDATE family SET fam_bedrift = 2, fam_bank = (fam_bank - $familiebedrift_price[1]) WHERE ID='".$family_id."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=familiebedrift&id=".$_GET['id']."&oppgrader");
                }
            } elseif($row_family['fam_bedrift'] == 2){
                if($familiebedrift_price[2] > $row_family['fam_bank']){
                    echo '<div class="feedback feilmelding">
                        <span>Det er ikke nok penger i familiekassen til å aktivere dette nivået.</span>
                    </div>';
                } else {
                    $result = "UPDATE family SET fam_bedrift = 3, fam_bank = (fam_bank - $familiebedrift_price[2]) WHERE ID='".$family_id."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                    
                    header("Location: index.php?side=familiebedrift&id=".$_GET['id']."&oppgrader");
                }
            }
        }
        
        if(isset($_GET['oppgrader'])){
            echo '<div class="feedback velykket">
                <span>Familiebedriften ble aktivert!</span> 
            </div>';
        }

        
    ?>
    <div class="content">
        <img style="display: block; margin-left: auto; margin-right: auto;" src="img/action/familiebedrift.png">
        <div class="pad_10">
            <p>
                <center>Familiebedrift gir medlemmer av familien ekstra mye uttak på crypto farm.<br>
                    <span style="color: #4e4e4e;">NB! Familiebedriften går ut ved midnatt.</span></center>
            </p>
        </div>
        <form method="post">
            <div style="width: 33%; height: auto; float:left; border-right: 1px solid #2c2c2c;">
                <center>
                    <img src="img/action/familiebedrift_0.png" style="margin-bottom: 8px;">
                    <b>Nivå 1</b><br>
                    <span style="color: #4e4e4e;">10% ekstra ved uttak<br>
                        Pris: <?php echo number($familiebedrift_price[0]); ?></span><br>
                    <?php if($row_family['fam_bedrift'] == 0){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($row_family['fam_bedrift'] >= 1){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if(($row_member['role'] == 1 || $row_member['role'] == 2)  && $row_family['fam_bedrift'] == 0){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_familiebedrift" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
            <div style="width: 33%; height: auto; float:left; border-right: 1px solid #2c2c2c;">
                <center>
                    <img src="img/action/familiebedrift_1.png" style="margin-bottom: 8px;">
                    <b>Nivå 2</b><br>
                    <span style="color: #4e4e4e;">25% ekstra ved uttak<br>
                        Pris: <?php echo number($familiebedrift_price[1]); ?></span><br>
                    <?php if($row_family['fam_bedrift'] <= 1){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($row_family['fam_bedrift'] >= 2){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if(($row_member['role'] == 1 || $row_member['role'] == 2)  && $row_family['fam_bedrift'] == 1){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_familiebedrift" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
            <div style="width: 33%; height: auto; float:left;">
                <center>
                    <img src="img/action/familiebedrift_2.png" style="margin-bottom: 8px;">
                    <b>Nivå 3</b><br>
                    <span style="color: #4e4e4e;">50% ekstra ved uttak<br>
                        Pris: <?php echo number($familiebedrift_price[2]); ?></span><br>
                    <?php if($row_family['fam_bedrift'] <= 2){ ?>
                    <span style="color: orange;">Ikke aktivert</span>
                    <?php } elseif($row_family['fam_bedrift'] >= 3){ ?>
                    <span style="color: green;">Aktivert</span>
                    <?php } ?>
                    <?php if(($row_member['role'] == 1 || $row_member['role'] == 2)  && $row_family['fam_bedrift'] == 2){ ?>
                    <input type="submit" style="width: auto;" name="upgrade_familiebedrift" value="Aktiver">
                    <?php } ?>
                </center>
            </div>
        </form>
    </div>
    <?php 
    
    if(isset($_POST['activate_giro'])){
        if(isset($_POST['avtalegiro'])){
            
            $result = "UPDATE family SET fam_avtalegiro = '".$_POST['avtalegiro']."' WHERE ID='".$family_id."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=familiebedrift&id=".$family_id."");

        } else {
            echo '<div class="feedback mislykket">
                <span>Vennligst velg et alternativ.</span> 
            </div>';
        }
    }
        
        if(isset($_POST['deactivate_giro'])){
            $result = "UPDATE family SET fam_avtalegiro = 0 WHERE ID='".$family_id."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=familiebedrift&id=".$family_id."");
        }
    
    
    ?>
        <div class="content" style="margin-top: 4px;">
            <div class="header">
                <span>Avtalegiro</span>
            </div>
            <div class="pad_10">Med avtalegiro vil bedriftene automatisk kjøpes kl 00:00 om det er nok penger i familiekassen. Dette kan når som helst aktiveres og deaktiveres av gudfar eller økonomen i familien.<br>
                <?php if($row_member['role'] == 1 || $row_member['role'] == 2){ ?>
                
                <?php if($row_family['fam_avtalegiro'] < 1){ ?>
            <form method="post" action=""><br>
                <b>Velg nivå<br></b>
              <select style="width: auto;" name="avtalegiro">
                <option value="1">Nivå 1 - 100 000 000kr pr døgn</option>
                <option value="2">Nivå 2 - 350 000 000kr pr døgn</option>
                <option value="3">Nivå 3 - 850 000 000kr pr døgn</option>
              </select>
              <input style="width: auto;" type="submit" name="activate_giro" value="Aktiver avtalegiro">
            </form>
                <?php } else { ?><br>
            <div class="feedback velykket" style="width: 98%">
                <span>Avtalegiro er aktivert for nivå <?php echo $row_family['fam_avtalegiro'] ?>.</span> 
            </div>
                <form method="post">
                
              <input class="no" style="width: auto;" type="submit" name="deactivate_giro" value="Deaktiver avtalegiro">
            </form>
                <?php } } ?>
            </div>
    </div>
</body>

</html>
<?php 
    } else {
        echo '<div class="feedback feilmelding">
            <span>Dette er vel ikke din familie?</span>
            </div>';
    }
}

?>