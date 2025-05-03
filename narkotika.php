<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 

    $sql = "SELECT * FROM narkotika WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_narko = mysqli_fetch_assoc($query);
    
    $mdma_user =        $row_narko['mdma'];
    $cannabis_user =    $row_narko['cannabis'];
    $kokain_user =      $row_narko['kokain'];

    $mdma[0] = 450;
    $mdma[1] = 390;
    $mdma[2] = 320;
    $mdma[3] = 380;
    $mdma[4] = 590;
    
    $cannabis[0] = 320;
    $cannabis[1] = 300;
    $cannabis[2] = 290;
    $cannabis[3] = 310;
    $cannabis[4] = 520;
    
    $kokain[0] = 620;
    $kokain[1] = 600;
    $kokain[2] = 690;
    $kokain[3] = 610;
    $kokain[4] = 720;
    
    if(isset($_POST['sell'])){
        $mdma_value = $_POST['mdma_value'];
        $cannabis_value = $_POST['cannabis_value'];
        $kokain_value = $_POST['kokain_value'];

        $total_price = 0;
        
        if($mdma_value > $mdma_user){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke selge mer narkotika enn du har selv.</span> 
            </div>';
        } elseif($cannabis_value > $cannabis_user){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke selge mer narkotika enn du har selv.</span> 
            </div>';        
        } elseif($kokain_value > $kokain_user){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke selge mer narkotika enn du har selv.</span> 
            </div>';        
        } else {


        if($mdma_value != null){
            $total_price = $total_price + ($mdma_value * $mdma[$city]);
        }
        
        if($cannabis_value != null){
            $total_price = $total_price + ($cannabis_value * $cannabis[$city]);
        }
        
        if($kokain_value != null){
            $total_price = $total_price + ($kokain_value * $kokain[$city]);
        }
        
            if($mdma_value != null){
                $result = "UPDATE narkotika SET mdma = ($mdma_user - $mdma_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            if($cannabis_value != null){
                $result = "UPDATE narkotika SET cannabis = ($cannabis_user - $cannabis_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            if($kokain_value != null){
                $result = "UPDATE narkotika SET kokain = ($kokain_user - $kokain_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            $result = "UPDATE accounts SET money = ($money + $total_price) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            header("Location: index.php?side=narkotika&sell");
        
        }
    }
    
    if(isset($_POST['buy'])){
        $mdma_value = $_POST['mdma_value'];
        $cannabis_value = $_POST['cannabis_value'];
        $kokain_value = $_POST['kokain_value'];
        
        $total_price = 0;

        if($mdma_value != null){
            $total_price = $total_price + ($mdma_value * $mdma[$city]);
        }
        
        if($cannabis_value != null){
            $total_price = $total_price + ($cannabis_value * $cannabis[$city]);
        }
        
        if($kokain_value != null){
            $total_price = $total_price + ($kokain_value * $kokain[$city]);
        }
        
        if($total_price > $money){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke råd til å kjøpe så mye.</span> 
            </div>';        
        } elseif(($mdma_user + $mdma_value) >= 10001 || ($cannabis_user + $cannabis_value) >= 10001 || ($kokain_user + $kokain_value) >= 10001){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke ha mer enn 10kg av hver.</span> 
            </div>';
        } else {
            if($mdma_value != null){
                $result = "UPDATE narkotika SET mdma = ($mdma_user + $mdma_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            if($cannabis_value != null){
                $result = "UPDATE narkotika SET cannabis = ($cannabis_user + $cannabis_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            if($kokain_value != null){
                $result = "UPDATE narkotika SET kokain = ($kokain_user + $kokain_value) WHERE acc_id='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
            }

            $result = "UPDATE accounts SET money = ($money - $total_price) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            header("Location: index.php?side=narkotika&buy");
        }
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Narkotika</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="feedback mislykket">
            <span>Denne funksjonen blir fjernet innen søndag formiddag. Har du noe narkotika da så selg disse før de fjernes.</span> 
        </div>
        <div class="content">
            <?php
    
    if(isset($_GET['buy'])){
        echo '<div class="feedback velykket">
            <span>Narkotika ble kjøpt!</span> 
        </div>';   
    }
    
    if(isset($_GET['sell'])){
        echo '<div class="feedback velykket">
            <span>Narkotika ble solgt!</span> 
        </div>';   
    }
    
    ?>
        <div class="header">
            <span>Narkotika</span>
        </div>
        <img src="img/action/narkotika.png">
            <form method="POST">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr style="height: 30px;">
                        <th style="padding-left: 15px; width: 40%;">Narkotika</th>
                        <th style="width: 30%">Pris</th>
                        <th style="width: 30%">Antall</th>
                    </tr>
                    <tr style="height: 30px;">
                        <td style="padding-left: 15px;">Mdma</td>
                        <td><?php echo $mdma[$city] ?>kr</td>
                        <td><input type="number" name="mdma_value" min="0" max="10000" placeholder="<?php echo $mdma_user ?>"></td>
                    </tr>
                    <tr style="height: 30px;">
                        <td style="padding-left: 15px;">Cannabis</td>
                        <td><?php echo $cannabis[$city] ?>kr</td>
                        <td><input type="number" name="cannabis_value" min="0" max="10000" placeholder="<?php echo $cannabis_user ?>"></td>
                    </tr>
                    <tr style="height: 30px;">
                        <td style="padding-left: 15px;">Kokain</td>
                        <td><?php echo $kokain[$city] ?>kr</td>
                        <td><input type="number" name="kokain_value" min="0" max="10000" placeholder="<?php echo $kokain_user ?>"></td>
                    </tr>
                </table>
            <input type="submit" name="buy" value="Kjøp" style="width: 47%">
            <input type="submit" name="sell" value="Selg" style="width: 47%">
            </form>
        </div>
    </body>
</html>
<?php 

}

?>