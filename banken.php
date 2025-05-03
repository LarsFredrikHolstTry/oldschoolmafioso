<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
?>
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Banken</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php
        
        if(isset($_POST['sett_inn'])){
            $number = preg_replace('/\s+/', '', $_POST['number']);

            if($_POST['number'] == null || is_numeric($number)){
                if($number < 0){
                    echo '<div class="feedback feilmelding">
                        <span>Du kan ikke lege inn minus-tall</span> 
                    </div>';
                } else {

                    if(!empty($_POST['radioBtn'])){
                        $answer = $_POST['radioBtn'];

                        $result = "UPDATE accounts SET money = 0, bank_money = ($money + $bank_money) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=banken&action=1&home");
                    } else {
                        if($_POST['number'] == null){
                        echo '<div class="feedback feilmelding">
                            <span><b>Feilmelding!</b> Du må gi en verdi om hva som skal inn i banken</span> 
                        </div>';
                        } elseif($money >= $number) {
                            $result = "UPDATE accounts SET money = ($money - $number), bank_money = ($bank_money + $number) WHERE ID='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            header("Location: index.php?side=banken&action=2&home");
                        } else {
                            echo '<div class="feedback feilmelding">
                                <span><b>Feilmelding!</b> Du kan ikke sette inn mer penger i banken enn du har på hånden.</span> 
                            </div>';
                        }
                    }
                }
            } else {
                echo '<div class="feedback feilmelding">
                    <span><b>Feilmelding!</b> Bokstav funnet i input.</span> 
                </div>';
            }
        }
        
        if(isset($_POST['ta_ut'])){
            $number = preg_replace('/\s+/', '', $_POST['number']);
            
            if($_POST['number'] == null || is_numeric($number)){
                if($number < 0){
                    echo '<div class="feedback feilmelding">
                        <span>Du kan ikke lege inn minus-tall</span> 
                    </div>';
                } else {
                    if(!empty($_POST['radioBtn'])){
                        $answer = $_POST['radioBtn'];

                        $result = "UPDATE accounts SET bank_money = 0, money = ($money + $bank_money) WHERE ID='".$_SESSION['ID']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");

                        header("Location: index.php?side=banken&action=3&amount=".$number."&home");
                    } else {
                        if($_POST['number'] == null){
                        echo '<div class="feedback feilmelding">
                            <span><b>Feilmelding!</b> Du må gi en verdi om hva som skal ut av banken</span> 
                        </div>';
                        } elseif($bank_money >= $number) {
                            $result = "UPDATE accounts SET money = ($money + $number), bank_money = ($bank_money - $number) WHERE ID='".$_SESSION['ID']."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            header("Location: index.php?side=banken&action=4&home");
                        } else {
                        echo '<div class="feedback feilmelding">
                            <span><b>Feilmelding!</b> Du kan ikke ta ut mer penger enn du har i banken.</span> 
                        </div>';
                        }
                    }
                }
            } else {
                echo '<div class="feedback feilmelding">
                    <span><b>Feilmelding!</b> Bokstav funnet i input.</span> 
                </div>';
            }
        }
        
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            
            if($action == 1){
                echo '<div class="feedback velykket">
                    <span>Du satt inn alle dine penger i banken.</span> 
                </div>';
            } elseif($action == 2){
                echo '<div class="feedback velykket">
                    <span>Du satt inn penger i banken.</span> 
                </div>';
            } elseif($action == 3){
                echo '<div class="feedback velykket">
                    <span>Du tok ut alle pengene fra banken.</span> 
                </div>';
            } elseif($action == 4){
                echo '<div class="feedback velykket">
                    <span>Du tok ut penger fra banken.</span> 
                </div>';
            }
        }
    
        if(isset($_POST['send_money'])){
            $to =       $_POST['to'];
            $value =    preg_replace('/\s+/', '', $_POST['value']);

            $to = mysqli_real_escape_string($con, nl2br(htmlentities($to, ENT_QUOTES, 'UTF-8')));
            strip_tags($to);
            
            $check_user = mysqli_query($con, "SELECT * FROM accounts WHERE username = '$to'");

            if(is_numeric($value)){
                if(mysqli_num_rows($check_user) > 0) {

                    $sql = "SELECT * FROM accounts WHERE ID='".$ID."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_from = mysqli_fetch_assoc($query);

                    $bank_money_from = $row_from['bank_money'];

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
                            <span>Du kan ikke sende mer penger enn du har i banken!</span> 
                        </div>';
                    } elseif($to == $username){
                        echo '<div class="feedback mislykket">
                            <span>Du kan ikke sende penger til deg selv!</span> 
                        </div>';
                    } elseif($value < 0){
                        echo '<div class="feedback mislykket">
                            <span>Du kan ikke sende mindre enn 0 kr!</span> 
                        </div>';
                    } else {
                        $sql = "UPDATE accounts SET money = ($money_to + $value_after) WHERE username = '$username_to'";
                        mysqli_query($con, $sql);

                        $sql = "UPDATE accounts SET bank_money = ($bank_money_from - $value) WHERE ID = '$ID'";
                        mysqli_query($con, $sql);

                        $query = "INSERT into `varsel` (acc_id, text, date)
                        VALUES ('$ID_to', 'Du har mottatt ".number($value_after)."kr fra ".$username."', '".time()."')";
                        $result = mysqli_query($con, $query);

                        echo '<div class="feedback velykket">
                            <span>Du overførte ';
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
                    <span>Ugyldig input.</span> 
                </div>';
            }
        }
        
        ?>
    <div class="content" style="padding-bottom: 0;">
        <div class="tab">
            <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'my_acc')" <?php if(isset($_GET['home'])){ ?> id="defaultOpen" <?php } ?>>Min bankkonto</button>
            <button style="width: 50%;" class="tablinks pad_10" onclick="openTab(event, 'new_acc')" <?php if(isset($_GET['swiss'])){ ?> id="defaultOpen" <?php } ?>>Swissbank</button>
        </div>
        <div id="my_acc" class="tabcontent">
            <img src="img/action/bank.png" style="width: 100%; height: auto;">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 50%; padding-left: 15px;">Konto</th>
                    <th style="width: 50%;">Saldo</th>
                </tr>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;">Brukskonto <span class="help" data-balloon-length="medium" aria-label="I en brukskonto får du 10% renter ved midnatt om du har under 500 mill i banken" data-balloon-pos="up">(?)</span></td>
                    <td><?php echo number($bank_money); ?> kr</td>
                </tr>
            </table>
            
            <?php
    
            $check_swiss = mysqli_query($con, "SELECT * FROM bank_accounts WHERE acc_id = '$ID'");

            if(mysqli_num_rows($check_swiss) > 0) {
                ?>
            
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 50%; padding-left: 15px;">Safe nr</th>
                    <th style="width: 50%;">Saldo</th>
                </tr>
                
            <?php
                
            while($row_fam = mysqli_fetch_assoc($check_swiss)) {

                $sql = "SELECT * FROM bank_accounts WHERE acc_id = '$ID' ORDER BY bank_id";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_swizz = mysqli_fetch_assoc($query);
    
                
            ?>

                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><?php echo $row_fam['bank_id']; ?></td>
                    <td><?php echo number($row_fam['amount']); ?> kr</td>
                </tr>
            
            <?php } ?>
            
            </table>

            <?php } ?>
            
            <form method="post">
                <div class="header header_mid">
                    <span>Sett inn / ta ut penger</span>
                </div>
                <table>
                    <tr>
                        <th style="width: 40%;">Beløp</th>
                        <th style="width: 20%;"></th>
                        <th style="width: 20%;"></th>
                        <th style="width: 20%;"></th>
                    </tr>
                    <tr style="background-color: #1b1b1b;">
                        <td><input name="number" id="number" placeholder="Beløp" type="text"></td>
                        <td style="padding-bottom: 7px;">
                            <label class="radio_container">
                                <input type="radio" name='radioBtn' name="radio" value="altinn">
                                <span class="checkmark"></span>
                            </label>
                            <t style="display: absolute; padding-left: 30px;">Alt</t>
                        </td>
                        <td><input type="submit" name="ta_ut" value="Ta ut"></td>
                        <td><input type="submit" name="sett_inn" value="Sett inn"></td>
                    </tr>
                </table>
            </form>

            <form method="post">
                <div class="header header_mid">
                    <span>Overfør penger</span>
                </div>
                <table>
                    <tr>
                        <th style="width: 45%;" required>Til bruker</th>
                        <th style="width: 45%;" required>Beløp</th>
                        <?php if($happy_hour == 1){ ?>
                        <th style="width: 25%; padding-left: 8px;"><span style="color: #3e3e3e;">Gebyr: 0%</span></th>
                        <?php } else { ?>
                        <th style="width: 25%; padding-left: 8px;"><span style="color: #3e3e3e;">Gebyr: 10%</span></th>
                        <?php } ?>
                    </tr>
                    <tr style="background-color: #1b1b1b;">
                        <td><input type="text" placeholder="Til bruker" name="to" required></td>
                        <td><input type="text" id="number2" placeholder="Beløp" min="1" name="value" required></td>
                        <td><input type="submit" value="Overfør" name="send_money"></td>
                    </tr>
                </table>
            </form>

        </div>
        <?php 
        
    $pris = 750000000;
    
    if(isset($_GET['too_broke'])){
        echo '<div class="feedback mislykket" style="width: 97.5%">
            <span>Du har ikke nok penger.</span> 
        </div>';
    }
    
    if(isset($_GET['konto_opprettet'])){
        echo '<div class="feedback velykket" style="width: 97.5%">
            <span>Swisskonto med konto nr ';
        echo $_GET['konto_opprettet'];
            echo ' ble opprettet.</span> 
        </div>';
    }
    
    if(isset($_GET['konto_busy'])){
        echo '<div class="feedback mislykket" style="width: 97.5%">
            <span>Swisskonto nr er opptatt.</span> 
        </div>';
    }
    
    if(isset($_GET['konto_non_exist'])){
        echo '<div class="feedback mislykket" style="width: 97.5%">
            <span>Det er ingen swisskontoer som tilsvarer konto nr du oppga</span> 
        </div>';
    }
    
    if(isset($_GET['wrong_pass'])){
        echo '<div class="feedback mislykket" style="width: 97.5%">
            <span>Passordet for safe er feil</span> 
        </div>';
    }
    
    if(isset($_GET['saldo'])){
        echo '<div class="feedback velykket" style="width: 97.5%">
            <span>Disponibelt beløp på konto: ';
        echo number($_GET['saldo']);
        echo ' kr</span> 
        </div>';
    }
    
    if(isset($_GET['money_in'])){
        echo '<div class="feedback velykket" style="width: 97.5%">
            <span>';
        echo number($_GET['money_in']);
            echo ' (';
        echo number($_GET['money_in'] * 0.85);
        echo ')';
        echo ' kr ble sendt inn til safen.</span> 
        </div>';
    }
    
    if(isset($_GET['too_much'])){
        echo '<div class="feedback mislykket" style="width: 97.5%">
            <span>Du kan ikke ta ut mer penger enn det er på swisskontoen.</span> 
        </div>';
    }
    
    if(isset($_GET['money_out'])){
        echo '<div class="feedback velykket" style="width: 97.5%">
            <span>';
        echo number($_GET['money_out']);
        echo ' kr ble tatt ut av safen.</span> 
        </div>';
    }
    
    if(isset($_POST['check_swiss'])){
        $swiss_safe_nr =    $_POST['swiss_safe_nr'];
        $swiss_pass =       $_POST['swiss_pass'];
        
        $check_swiss_safe_nr = mysqli_query($con, "SELECT * FROM bank_accounts WHERE bank_id = $swiss_safe_nr");
        if(mysqli_num_rows($check_swiss_safe_nr) > 0) {
            $sql = "SELECT * FROM bank_accounts WHERE bank_id='".$swiss_safe_nr."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_swiss = mysqli_fetch_assoc($query);
            
            if($row_swiss['password'] == $swiss_pass){
                header("Location: index.php?side=banken&saldo=".$row_swiss['amount']."&swiss");
            } else {
                header("Location: index.php?side=banken&wrong_pass&swiss");
            }
        } else {
            header("Location: index.php?side=banken&konto_non_exist&swiss");
        }
    }
    
    if(isset($_POST['create_swiss'])){
        $swiss_safe_nr =    $_POST['swiss_safe_nr'];
        $swiss_pass =       uniqid();
        
        $check_swiss_safe_nr = mysqli_query($con, "SELECT * FROM bank_accounts WHERE bank_id = $swiss_safe_nr");
        if(mysqli_num_rows($check_swiss_safe_nr) > 0) {
            header("Location: index.php?side=banken&konto_busy&swiss");
        } else {
            if($money < $pris){
                header("Location: index.php?side=banken&too_broke&swiss");
            } else {
                $result = "UPDATE accounts SET money = (money - $pris) WHERE ID='".$_SESSION['ID']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                $swiss_safe_nr = rand(1000, 9999);

                $check_nr = mysqli_query($con, "SELECT bank_id FROM bank_accounts WHERE bank_id = '$swiss_safe_nr'");
                
                do { 
                    $swiss_safe_nr = rand(1000, 9999);
                }
                while(mysqli_num_rows($check_nr) > 0);

                $query = "INSERT into `bank_accounts` (acc_id, bank_id, password, amount)
                VALUES ('$ID', '$swiss_safe_nr', '$swiss_pass', '0')";
                $result = mysqli_query($con, $query);
                
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('$ID', 'Du har opprettet swisskonto. Konto nr: ".$swiss_safe_nr.". Passord: ".$swiss_pass.". Skriv ned konto nr og passord da dette ikke kan hentes senere', '".time()."')";
                $result = mysqli_query($con, $query);


                header("Location: index.php?side=banken&konto_opprettet=".$swiss_safe_nr."&swiss");
            }
        }
    }
    
    if(isset($_POST['swiss_in'])){
        $swiss_safe_nr =    $_POST['swiss_safe_nr'];
        $swiss_money =  preg_replace('/\s+/', '', $_POST['swiss_money']);

        if(is_numeric($swiss_money)){
        
        $money_after = $swiss_money * 0.85;
        
            $check_swiss_safe_nr = mysqli_query($con, "SELECT * FROM bank_accounts WHERE bank_id = $swiss_safe_nr");
            if(mysqli_num_rows($check_swiss_safe_nr) > 0) {
                if($swiss_money > $money){
                    header("Location: index.php?side=banken&too_broke&swiss");
                } elseif($swiss_money < 0){
                    echo '<div class="feedback feilmelding">
                        <span>Tallet kan ikke være mindre enn 0</span> 
                    </div>';
                } else {
                    $result = "UPDATE bank_accounts SET amount = (amount + $money_after) WHERE bank_id = $swiss_safe_nr";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money - $swiss_money) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=banken&money_in=".$swiss_money."&swiss");
                }
            } else {
                header("Location: index.php?side=banken&konto_non_exist&swiss");
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Bokstav funnet i input.</span> 
            </div>';
        }
    }
    
    if(isset($_POST['swiss_out'])){
        $swiss_safe_nr =    $_POST['swiss_safe_nr'];
        $swiss_password =   $_POST['swiss_password'];
        $swiss_money =  preg_replace('/\s+/', '', $_POST['swiss_money']);
        
        if(is_numeric($swiss_money)){
            $check_swiss_safe_nr = mysqli_query($con, "SELECT * FROM bank_accounts WHERE bank_id = $swiss_safe_nr");
            if(mysqli_num_rows($check_swiss_safe_nr) > 0) {
                $sql = "SELECT * FROM bank_accounts WHERE bank_id='".$swiss_safe_nr."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_swiss = mysqli_fetch_assoc($query);

                if($swiss_money > $row_swiss['amount']){
                    header("Location: index.php?side=banken&too_much&swiss");
                } elseif($swiss_money < 0){
                    echo '<div class="feedback feilmelding">
                        <span>Tallet kan ikke være mindre enn 0</span> 
                    </div>';
                } else {
                    $result = "UPDATE bank_accounts SET amount = (amount - $swiss_money) WHERE bank_id = $swiss_safe_nr";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    $result = "UPDATE accounts SET money = (money + $swiss_money) WHERE ID='".$_SESSION['ID']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");

                    header("Location: index.php?side=banken&money_out=".$swiss_money."&swiss");
                }
            } else {
                header("Location: index.php?side=banken&konto_non_exist&swiss");
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span><b>Feilmelding!</b> Bokstav funnet i input.</span> 
            </div>';
        }
    }
        
        ?>
        <div id="new_acc" style="height: 500px;" class="tabcontent">
            <img src="img/action/swissbank.png" style="width: 100%; height: auto;">
            <div style="padding-left: 10px; word-wrap: break-word; margin-top: -15px; white-space: pre-line;" class="textbox">
                <p style="margin: 10 0 0 0;">En swissbank er en bank hvor du kan opprette en safe. Pengene som ligger i safen er skjult fra din pengerank.</p>
                <p style="margin: 0; color: orange">Safe boks er personlig og passordet skal ikke deles med noen. </p>
            </div>
            <form method="post" action="">
                <div style="width: 49%; float: left; height: 170px; box-shadow: -1px 0px #2c2c2c inset;">
                    <div class="header header_mid">
                        <span>Opprett konto</span>
                    </div>
                    <div class="pad_10">


                        Opprettelse av en safe er <?php echo number($pris); ?>kr<br>
                        Swissbank tar 15% ved innskudd<br>
                        1% forsvinner ved midnatt<br><br>
                        <input style="margin: 0;" type="submit" name="create_swiss" value="Opprett konto">
                    </div>
                </div>
            </form>
            <form method="post" action="">
                <div style="width: 50.81%; float: left; height: 170px;">
                    <div class="header header_mid">
                        <span>Sjekk saldo</span>
                    </div>
                    <div class="pad_10">
                        Safe nr<br>
                        <input type="number" name="swiss_safe_nr" min="1000" max="9999" placeholder="Safe nr" required><br><br>

                        Passord<br>
                        <input type="text" name="swiss_pass" placeholder="Passord" required><br>
                        <input style="margin: 0;" type="submit" name="check_swiss" value="Sjekk saldo">
                    </div>
                </div>
            </form>
            <form method="post" action="">
                <div style="width: 49%; float: left; height: 230px; box-shadow: -1px 0px #2c2c2c inset;">
                    <div class="header header_mid">
                        <span>Sett inn penger</span>
                    </div>
                    <div class="pad_10">
                        <p style="margin-top: 0;">Husk at ved inntak så tar swissbank 15% av summen</p>
                        Safe nr<br>
                        <input type="number" name="swiss_safe_nr" min="1000" max="9999" placeholder="Safe nr" required><br><br>

                        Sum<br>
                        <input type="text" id="number3" min="10000" name="swiss_money" placeholder="Sum" required><br>
                        <input style="margin: 0;" type="submit" name="swiss_in" value="Sett inn">
                    </div>
                </div>
            </form>
            <form method="post" action="">
                <div style="width: 50.81%; float: left; height: 230px;">
                    <div class="header header_mid">
                        <span>Ta ut penger</span>
                    </div>
                    <div class="pad_10">
                        Safe nr<br>
                        <input type="number" min="1000" max="9999" name="swiss_safe_nr" placeholder="Safe nr" required><br><br>

                        Passord<br>
                        <input type="text" placeholder="Passord" name="swiss_password" required><br><br>

                        Sum<br>
                        <input type="text" id="number4" min="10000" placeholder="Sum" name="swiss_money" required><br>
                        <input style="margin: 0;" type="submit" name="swiss_out" value="Ta ut penger">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php 

}

?>

<script src="jquery-3.4.1.min.js"></script>
<script>
    var DivTxt = new Array()
    DivTxt[0] = "BSU vilkår: Opprettelse av BSU koster 100 000 000kr. Den gir deg 5% renter ved midnatt men har kun 5 uttak pr uke.";
    DivTxt[1] = "AKS vilkår: Opprettelse av en aksjesparekonto gir deg muligheten til å handle skattefritt på aksjemarkedet.";
    DivTxt[2] = "SWZ vilkår: Opprettelse av en Swizzbank konto gir deg muligheten til å hvitvaske penger i utlandet for å ikke bli tatt av politiet ved razzia.";

    function getText(slction) {
        txtSelected = slction.selectedIndex;
        document.getElementById('textDiv').innerHTML = DivTxt[txtSelected];
    }


    function openTab(evt, tabPage) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabPage).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();


    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $('#number').on("keyup", function() {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });

    $('#number2').on("keyup", function() {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });

    $('#number3').on("keyup", function() {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });

    $('#number4').on("keyup", function() {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });

</script>
