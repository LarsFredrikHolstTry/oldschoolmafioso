
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

    if(isset($_POST['donate'])){
        $money_donated = preg_replace('/\s+/', '', $_POST['money_donated']);
        
        if($money_donated > $money){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke donere mer enn du har på hånden.</span> 
            </div>';
        } elseif($money_donated < 0){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke donere minus.</span> 
            </div>';
        } else {
			$result = "UPDATE family SET fam_bank = (fam_bank + $money_donated) WHERE ID='".$family_id."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
			$result = "UPDATE accounts SET money = (money - $money_donated) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            $date = time();
            
            $query = "INSERT into `family_donation` (family_id, amount, acc_id, date)
            VALUES ('".$_GET['id']."', '$money_donated', '$ID', '$date')";
            $result = mysqli_query($con, $query);
            
            header("Location: index.php?side=familie_donasjon&id=".$_GET['id']."&donated=".$money_donated."");
        }
    }


?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » Familie » </span><span style="color: #afafaf;">Familie donasjon</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php 
        
    if(isset($_GET['donated'])){
        echo '<div class="feedback velykket"><span>Du donerte ';
        echo number($_GET['donated']);
        echo 'kr til din familie.</span></div>';
    }
        

    if(isset($_POST['money_out'])){
        $belop = preg_replace('/\s+/', '', $_POST['fam_bank_out']);

        if($happy_hour == 1){
            $belop_percentage = $belop;
        } else {
            $belop_percentage = $belop * 0.9;
        }

        if($belop > $row_family['fam_bank']){
            echo '<div class="feedback mislykket"><span>Du kan ikke ta ut mer enn det er i familiebanken</span></div>';
        } elseif($belop_percentage < 0){
            echo '<div class="feedback mislykket"><span>Du kan ikke ta ut i minus</span></div>';
        } else {
            $result = "UPDATE family SET fam_bank = (fam_bank - ".$belop.") WHERE ID='".$family_id."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            $result = "UPDATE accounts SET money = (money + ".$belop_percentage.") WHERE ID='".$ID."'";
            mysqli_query($con, $result) or die("Bad query: $result");
            
            header("Location: index.php?side=familie_donasjon&id=".$_GET['id']."&uttak=".$belop_percentage."");
        }
    }
        
        if(isset($_POST['send_money'])){
            $to =       $_POST['to'];
            $value =    preg_replace('/\s+/', '', $_POST['value']);

            $check_user = mysqli_query($con, "SELECT * FROM accounts WHERE username = '$to'");

            if(is_numeric($value)){
                if(mysqli_num_rows($check_user) > 0) {

                    $sql = "SELECT * FROM family WHERE ID='".$_GET['id']."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_from = mysqli_fetch_assoc($query);

                    $bank_money_from = $row_from['fam_bank'];
                    $name = $row_from['name'];

                    $sql = "SELECT * FROM accounts WHERE username='".$to."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_to = mysqli_fetch_assoc($query);

                    $ID_to = $row_to['ID'];
                    $username_to = $row_to['username'];
                    $bank_money_to = $row_to['bank_money'];
                    $money_to = $row_to['money'];

                    if($happy_hour == 1){
                        $value_after = $value;
                    } else {
                        $value_after = $value * 0.9;
                    }

                    if($bank_money_from < $value){
                        echo '<div class="feedback mislykket">
                            <span>Du kan ikke sende mer penger enn det er i familiebanken!</span> 
                        </div>';
                    } elseif($value < 0){
                        echo '<div class="feedback mislykket">
                            <span>Du kan ikke sende minus penger!</span> 
                        </div>';
                    } else {
                        $sql = "UPDATE accounts SET money = ($money_to + $value_after) WHERE username = '$username_to'";
                        mysqli_query($con, $sql);

                        $sql = "UPDATE family SET fam_bank = (fam_bank - $value) WHERE ID = '".$_GET['id']."'";
                        mysqli_query($con, $sql);

                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('$ID_to', 'Du har mottat ".number($value_after)."kr fra familien ".$name."', '".time()."')";
                        $result = mysqli_query($con, $query);

                        echo '<div class="feedback velykket">
                            <span><b>velykket!</b> Du overførte ';
                        echo number($value);
                        echo 'kr ';
                        echo 'til ';
                        echo $username_to;
                        echo '!</span> </div>';
                    }
                } else {
                    echo '<div class="feedback mislykket">
                        <span>Brukeren finnes ikke.</span> 
                    </div>';
                }
            } else {
                echo '<div class="feedback feilmelding">
                    <span><b>Feilmelding!</b> Bokstav funnet i input.</span> 
                </div>';
            }
        }
        
    if(isset($_GET['uttak'])){
        echo '<div class="feedback velykket"><span>Du tok ut ';
        echo number($_GET['uttak']);
        echo 'kr fra din familie.</span></div>';
    }


        ?>
        <div class="content">
            <div class="header">
                <span>Familie donasjon</span>
            </div>
            <?php if($row_member['role'] == 1 || $row_member['role'] == 2) { ?>
                <center><br><span style="color: #6e6e6e;">Penger i familiekassen:</span><span style="color: #afafaf;"> <?php if($row_family['fam_bank'] == null) { echo '0'; } else { echo number($row_family['fam_bank']); } ?><span style="color: #6e6e6e;"> kr</span></span></center><br>
            <?php } ?>
            <br><center>
                <form method="post">
                    <input type="text" id="number" name="money_donated" style="width: 30%" placeholder="Antall">
                    <input type="submit" name="donate" style="width: 30%" value="Doner">
                </form>
            </center>
            <?php if($row_member['role'] == 1 || $row_member['role'] == 2) { 

            
            ?>
            <br><div class="header" style="border-top: 1px solid #2c2c2c;">
                <span>Ta ut penger fra familiekassen</span>
            </div>
                <center>
                    <form method="post">
                        <p><?php         
            if($happy_hour == 1){
                echo '0';
            } else {
                echo '10';
            }
                            ?>
                            % går til staten ved uttak</p>
                        <input type="text" id="number1" name="fam_bank_out" style="width: 30%" placeholder="Antall">
                        <input type="submit" name="money_out" style="width: 30%" value="Ta ut penger">
                    </form>
                </center>
            <br><div class="header" style="border-top: 1px solid #2c2c2c;">
                <span>Overfør penger til bruker</span>
            </div>
            <form method="post">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="padding-left: 10px; width: 40%;"><input type="text" placeholder="Til bruker" name="to" required></th>
                    <th style="width: 25%;"><input type="text" id="number2" placeholder="Beløp" min="1" name="value" required></th>
                    <th style="width: 25%;"><input type="submit" value="Overfør" name="send_money"></th>
                </tr>
            </table>
            </form>
            <div class="header" style="border-top: 1px solid #2c2c2c;">
                <span>Siste 20 donasjoner</span>
            </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="padding-left: 10px; width: 40%;">Brukernavn</th>
                    <th style="width: 25%;">Penger</th>
                    <th style="width: 25%;">Dato</th>
                </tr>

            <?php
                    $result_donation = mysqli_query($con, "SELECT * FROM family_donation WHERE family_id='".$_GET['id']."' ORDER BY date DESC LIMIT 20");
                    while($row_donation = mysqli_fetch_assoc($result_donation)) {
                        ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 10px; width: 50%;"><?php fetch_nick($row_donation['acc_id'], $con); ?></td>
                    <td style="width: 25%;"><?php echo number($row_donation['amount']); ?></td>
                    <td style="width: 25%;"><?php 
                        echo date('d', $row_donation['date']);
                        echo ". "; echo $month_short[date('n', $row_donation['date'])];
                        echo ". kl "; echo date('H:i', $row_donation['date']); ?></td>
                </tr>
                <?php
                    }
                ?>

            </table>
            <?php } ?>
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

<script>
$('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
    
$('#number1').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
    
$('#number2').on("keyup", function() {
    this.value = this.value.replace(/ /g,'');
    var number = this.value;
    this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
});
</script>