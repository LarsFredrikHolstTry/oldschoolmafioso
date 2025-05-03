<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
if($role == 1){
    $pris =  10000000 * 0.9;
} else {
    $pris =  10000000;
}

?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Diverse » </span><span style="color: #afafaf;">Familie</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php 
    
    if(isset($_POST['make_family'])){
        $family_name = $_POST['family_name'];
        
        $check_soknads = mysqli_query($con, "SELECT acc_id FROM family_applicant WHERE acc_id = '$ID'");

        $check_family = mysqli_query($con, "SELECT name FROM family WHERE name = '$family_name'");
        
        if(mysqli_num_rows($check_family) > 0){
            echo '<div class="feedback feilmelding">
                <span>Familienavnet eksisterer allerede.</span> 
            </div>';
        } elseif($money < $pris){
            echo '<div class="feedback mislykket">
                <span>Du har for lite penger til å opprette familie.</span> 
            </div>';
        } elseif(strlen($_POST['family_name']) > 20 || strlen($_POST['family_name']) < 5 ) {
            echo '<div class="feedback mislykket">
                <span>Familienavnet må være lengre enn 5 tegn og mindre enn 20.</span> 
            </div>';
        } else {
            if(mysqli_num_rows($check_soknads) > 0){
                $del = mysqli_query($con, "DELETE FROM family_applicant WHERE acc_id = $ID") or die(mysqli_error()); 
            }
            
            $countdown = 86400 + time();
            $query = "INSERT into `family` (name, countdown)
            VALUES ('$family_name', '$countdown')";
            $result = mysqli_query($con, $query);

            $query = "INSERT into `family_member` (family_id, acc_id, role)
            VALUES ((SELECT LAST_INSERT_ID()), '$ID', '1')";
            $result = mysqli_query($con, $query);
			
			$result = "UPDATE accounts SET money = ($money - $pris) WHERE ID='".$_SESSION['ID']."'";
            mysqli_query($con, $result) or die("Bad query: $result");

            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'Familie - opprettelse - ".$family_name."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);

            echo '<div class="feedback velykket">
                <span>Du har velykket opprettet en familie.</span> 
                </div>';
        }
    }
    
    if(isset($_GET['sok'])){
        $check_member = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");
        
        $check_soknad = mysqli_query($con, "SELECT acc_id FROM family_applicant WHERE acc_id = '$ID' AND family_id = '".$_GET['sok']."'");
        
        if(mysqli_num_rows($check_member) > 0){
            echo '<div class="feedback mislykket">
                <span>Du er allerede med i en familie.</span> 
            </div>';
        } elseif(mysqli_num_rows($check_soknad) > 0) {
            echo '<div class="feedback mislykket">
                <span>Du har allerede sendt søknad til denne familien.</span> 
            </div>';
        } else {
            $query = "INSERT into `family_applicant` (acc_id, family_id)
            VALUES ('$ID', '".$_GET['sok']."')";
            $result = mysqli_query($con, $query);
            
            echo '<div class="feedback velykket">
                <span>Søknaden er sendt.</span> 
            </div>';
        }
    }
    
    if(isset($_GET['avslaa'])){
        $sql = "SELECT * FROM family_member WHERE acc_id='".$ID."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_leader = mysqli_fetch_assoc($query);
        
        $family_id_leader = $row_leader['family_id'];
        $role_leader =      $row_leader['role'];

        $sql = "SELECT * FROM family_applicant WHERE acc_id='".$_GET['avslaa']."' AND family_id = $family_id_leader";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_applicant = mysqli_fetch_assoc($query);
        
        $family_id = $row_applicant['family_id'];

        if($family_id == $family_id_leader && $role_leader == 1){
            $del = mysqli_query($con, "DELETE FROM family_applicant WHERE acc_id = '".$_GET['avslaa']."' AND family_id = '$family_id'") or die(mysqli_error());
            
            echo '<div class="feedback velykket">
                <span>Brukeren ble ikke akseptert inn i din familie.</span> 
            </div>';
        } else {
            echo '<div class="feedback feilmelding">
                <span>Ingen adgang!</span> 
            </div>';
        }
    }
    
    if(isset($_GET['godkjenn'])){
        $sql = "SELECT * FROM family_member WHERE acc_id='".$ID."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_leader = mysqli_fetch_assoc($query);
        
        $family_id_leader = $row_leader['family_id'];
        $role_leader =      $row_leader['role'];
        
        $sql = "SELECT * FROM family_applicant WHERE acc_id='".$_GET['godkjenn']."' AND family_id = $family_id_leader";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_applicant = mysqli_fetch_assoc($query);
        
        $family_id = $row_applicant['family_id'];


        $max_members = 0;
        $result_max = mysqli_query($con, "SELECT * FROM family_member WHERE family_id='".$family_id_leader."'");
        while($row_max = mysqli_fetch_assoc($result_max)) {
            $max_members++;
        }
        
        if($max_members == 10){
            echo '<div class="feedback mislykket">
                <span>Det er max plass til 10 stk i denne familien.</span> 
            </div>';
        } elseif($family_id == $family_id_leader && $role_leader == 1){
            $query = "INSERT into `family_member` (family_id, acc_id, role)
            VALUES ('$family_id_leader', '".$_GET['godkjenn']."', '0')";
            $result = mysqli_query($con, $query);
            
            $query = "INSERT into `logg` (acc_id, action, money, bank_money, date)
            VALUES ('$ID', 'Familie - godkjenn medlem - ".$_GET['godkjenn']."', '$money', '$bank_money', '".time()."')";
            $result = mysqli_query($con, $query);
            
            $del = mysqli_query($con, "DELETE FROM family_applicant WHERE acc_id = '".$_GET['godkjenn']."'") or die(mysqli_error()); 
            
            echo '<div class="feedback velykket">
                <span>Brukeren ble akseptert inn i din familie.</span> 
            </div>';
        } else {
            echo '<div class="feedback feilmelding">
                <span>Ingen adgang!</span> 
            </div>';
        }
    }
    
    if(isset($_GET['nedleggelse'])){
        echo '<div class="feedback velykket">
            <span>Familien ble velykket lagt ned.</span> 
        </div>';
    }
    
    if(isset($_GET['forlat'])){
        echo '<div class="feedback velykket">
            <span>Du har forlatt familien.</span> 
        </div>';
    }
    
    if(isset($_GET['nomoney'])){
        echo '<div class="feedback feilmelding">
            <span>Det er ikke nok penger i familiekassen til antall forsvar.</span> 
        </div>';
    }
    
    if(isset($_GET['baught'])){
        echo '<div class="feedback velykket">
            <span>Familieforsvar ble kjøpt.</span> 
        </div>';
    }
    
    if(isset($_GET['number_input'])){
        echo '<div class="feedback feilmelding">
            <span>Bokstav i input.</span> 
        </div>';
    }
        
        ?>
    <div class="content">
        <div class="tab">
                <button style="width: 33.3%;" class="tablinks pad_10" onclick="openTab(event, 'familie')" <?php if(isset($_GET['war'])){  } else { ?> id="defaultOpen" <?php } ?>>Familie</button>
                <button style="width: 33.3%;" class="tablinks pad_10" onclick="openTab(event, 'oversikt')">Familieoversikt</button>
            <?php
    
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");

            if(mysqli_num_rows($check_family) > 0){
    
            ?>
            
                <button style="width: 33.4%;" class="tablinks pad_10" onclick="openTab(event, 'fam_krig')" <?php if(isset($_GET['war'])){ ?> id="defaultOpen" <?php } ?>>Familiekrig</button>
            
            <?php } ?>

        </div>

        <div id="familie" class="tabcontent">
            <?php 
                
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");

            if(mysqli_num_rows($check_family) > 0){
                
                $sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_member = mysqli_fetch_assoc($query);
                
                $family_id = $row_member['family_id'];
                
                $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_family = mysqli_fetch_assoc($query);
                
                $family_name = $row_family['name'];
                
                if(isset($_POST['legg_ned'])){
                    $del = mysqli_query($con, "DELETE FROM family_applicant WHERE family_id = '".$family_id."'") or die(mysqli_error()); 
                    $del = mysqli_query($con, "DELETE FROM family_member WHERE family_id = '".$family_id."'") or die(mysqli_error()); 
                    $del = mysqli_query($con, "DELETE FROM family WHERE ID = '".$family_id."'") or die(mysqli_error()); 
                    
                    header("Location: index.php?side=familie&nedleggelse");
                }
                
                if(isset($_POST['forlat'])){
                    $del = mysqli_query($con, "DELETE FROM family_member WHERE family_id = '".$family_id."' AND acc_id = '".$ID."'") or die(mysqli_error()); 
                    
                    header("Location: index.php?side=familie&forlat");
                }
                
            ?>
            
            <?php if($row_member['role'] == 1) { ?>
                <style>
                    .row {
                        width: 25%; 
                        height: 100px;
                        float: left;
                    }
                </style>
            <?php } else { ?>
                <style>
                    .row {
                        width: 33.3%; 
                        height: 100px;
                        float: left;
                    }
                </style>
            <?php } ?>

            <div class="pad_10" style="text-align: center;">Du er <?php echo $family_role_without[$row_member['role']] ?> i familien: <?php echo $family_name ?><br>
                
            <div style="width: 100%; padding-top: 10px; height: 100px;">
                <?php if($row_member['role'] == 1) { ?>
                <div class="row">
                    <a href="index.php?side=familie_rediger_profil&id=<?php echo $family_id?>"><img src="img/family/row_1.png"></a>
                </div>
                <?php } ?>
                <div class="row">
                    <a href="index.php?side=familie_medlemmer&id=<?php echo $family_id?>"><img src="img/family/row_2.png"></a>
                </div>
                <div class="row">
                    <a href="index.php?side=familie_donasjon&id=<?php echo $family_id?>"><img src="img/family/row_3.png"></a>
                </div>
                <div class="row">
                    <a href="index.php?side=familiebedrift&id=<?php echo $family_id?>"><img src="img/family/row_4.png"></a>
                </div>
            </div>
            </div>

                        <?php if($row_member['role'] == 1) { ?>
                            
                                <form method="post"><center><input style="width: 40%; margin: 6px 0 12px 0;" class="no" type="submit" name="legg_ned" value="legg ned familie"></center></form>
                                <?php } else { ?>
                                <form method="post"><center><input style="width: 40%; margin:6px 0 12px 0;" type="submit" name="forlat" value="Forlat familien"></center></form>
                            
                        <?php } ?>

            
            <?php if($row_member['role'] == 1) { ?>
            <div class="header header_mid">
                <span>Søknader</span>
            </div>
            <p style="padding-left: 10px; text-align: center;">Hvis du har noen som ønsker å bli med i din familie vil du se de under her</p>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th style="width: 88%; padding-left: 15px;"></th>
                    <th style="width: 6%;"></th>
                    <th style="width: 6%;"></th>
                </tr>
                <?php   
    
            $result_fam = mysqli_query($con, "SELECT * FROM family_applicant WHERE family_id = $family_id ");
    
            while($row_fam = mysqli_fetch_assoc($result_fam)) {
                $acc_id = $row_fam['acc_id'];

    
            ?>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;"><?php fetch_nick($acc_id, $con); ?></td>
                    <td style="text-align:right;"><a style="color:green;" href="index.php?side=familie&godkjenn=<?php echo $acc_id ?>">Godkjenn</a></td>
                    <td style="text-align:right;"><a style="color:red;" href="index.php?side=familie&avslaa=<?php echo $acc_id ?>">Avslå</a></td>
                </tr>
                <?php } ?>
            </table>
            <?php
            } } else {
                
                ?>
            <form method="post" action="">
                <img src="img/action/familie.png" style="width: 100%; height: auto;">
                <div style="padding-left: 10px; word-wrap: break-word; white-space: pre-line;" class="textbox">
                    <b>Velkommen til familie!</b>
                    <p style="padding-bottom: 0px; margin-bottom: -10px;">For å opprette en familie må du være ranken <b>El Capitan</b> og ha <b><?php echo number($pris); ?></b>kr</p>
                </div>
                <br>
                <input style="width: 27.2%; margin-left: 10px;" type="text" name="family_name" placeholder="Familienavn" required>
                <input style="width: 27.2%;" type="submit" name="make_family" value="Opprett familie">
            </form>
            <?php } ?>
        </div>

        <div id="oversikt" class="tabcontent">
            <table class="cellpadding" border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 15%;"></th>
                    <th style="width: 10%;">Navn</th>
                    <th style="width: 10%;">Leder</th>
                    <th style="width: 15%;">Medlemmer</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 35%;"></th>
                </tr>
                <?php   
    
            $result_fam = mysqli_query($con, "SELECT * FROM family WHERE name != 'Ledelsen'");
    
            while($row_fam = mysqli_fetch_assoc($result_fam)) {

                $id_fam = $row_fam['ID'];
                $name = $row_fam['name'];
                $stat = $row_fam['status'];
                $avatar = $row_fam['avatar'];
                
                $sql = "SELECT * FROM family_member WHERE family_id='".$id_fam."' AND role = 1";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_leader = mysqli_fetch_assoc($query);
                
                $sql = "SELECT * FROM family_member WHERE family_id='".$id_fam."' AND role = 2";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_okonom = mysqli_fetch_assoc($query);
                
        $i = 0;
        $result_members = mysqli_query($con, "SELECT * FROM family_member WHERE family_id='".$id_fam."'");
        while($row_members = mysqli_fetch_assoc($result_members)) {
            $i++;
        }

            ?>
                <tr style="height: 25px;">
                    <td style="padding-left: 15px;"><img style="width: 50px; height: auto;" src="<?php echo $avatar ?>"></td>
                    <td><a href="index.php?side=familie_profil&id=<?php echo $id_fam ?>"><?php echo $name ?></a></td>
                    <td><?php echo fetch_nick($row_leader['acc_id'], $con); ?></td>
                    <td><?php echo $i ?></td>
                    <td><?php echo $status[$stat]; ?></td>
                    <td><a href="index.php?side=familie&sok=<?php echo $id_fam ?>">Søk</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <?php
    
    $war_status_text[0] = "<span style='color: green;'>Ikke i krig</span>";
    
    $sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_member = mysqli_fetch_assoc($query);

    $family_id = $row_member['family_id'];

    $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
    $query = mysqli_query($con, $sql) or die (mysqli_error());
    $row_family = mysqli_fetch_assoc($query);
    
    $family_name =      $row_family['name'];
    $family_forsvar =   $row_family['fam_forsvar'];
    $war_status =       $row_family['war_status'];
    $fam_bank =         $row_family['fam_bank'];
    $fam_forsvar =      $row_family['fam_forsvar'];

    
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");

            if(mysqli_num_rows($check_family) > 0){
                
                if(isset($_POST['forsvar_buy'])){
                    $antall_forsvar = preg_replace('/\s+/', '', $_POST['forsvar_ant']);
                    
                    $pris_pr_forsvar = 10000;
                    $total_pris = $pris_pr_forsvar * $antall_forsvar;
                    if(is_numeric($antall_forsvar)){
                        if($fam_bank < $total_pris){
                            header("Location: index.php?side=familie&war&nomoney");
                        } elseif($antall_forsvar < 0){
                            echo '<div class="feedback mislykket">
                                <span>Du kan ikke kjøpe minus forsvar.</span> 
                            </div>';
                        } else {
                            $result = "UPDATE family SET fam_forsvar = (fam_forsvar + $antall_forsvar), fam_bank = (fam_bank - $total_pris) WHERE ID='".$family_id."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            header("Location: index.php?side=familie&war&baught");
                        }
                    } else {
                        header("Location: index.php?side=familie&war&number_input");
                    }
                }
                
                if(isset($_POST['start_war'])){
                    $family_name_war = $_POST['start_war_name'];
                    
                    if($family_name_war == "Ledelsen"){
                        echo '<div class="feedback mislykket">
                            <span>Du kan ikke erklære krig mot ledelsen</span> 
                        </div>';
                    } else {
                        $check_family = mysqli_query($con, "SELECT name FROM family WHERE name = '$family_name_war'");
                        if(mysqli_num_rows($check_family) > 0){
                            $sql = "SELECT * FROM family WHERE name='$family_name_war'";
                            $query = mysqli_query($con, $sql) or die (mysqli_error());
                            $row_fam_war = mysqli_fetch_assoc($query);

                            $result = "UPDATE family SET war_family = '".$family_name_war."', war_status = 1 WHERE name = '".$family_name_war."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                            $result = "UPDATE family SET war_family = '".$family_name."', war_status = 1 WHERE ID = '".$family_id."'";
                            mysqli_query($con, $result) or die("Bad query: $result");

                        } else {
                            echo '<div class="feedback mislykket">
                                <span>Denne familien eksisterer ikke.</span> 
                            </div>';
                        }
                    }
                }

        ?>
        <div id="fam_krig" class="tabcontent">
            <img src="img/action/fam_war.png">
            <div class="pad_10">
                <center>Krigstatus: <?php echo $war_status_text[$war_status]; ?></center>
                <center>Antall forsvar: <span style="color: #afafaf;"><?php if($family_forsvar == null) { echo 0; } else { echo number($family_forsvar); } ?></span></center>

                <p>For å unngå at familien skal skytes ned må det bygges opp et godt forsvar. Det er kun familiegudfaren og økonomiansvarlig som kan kjøpe familieforsvar og erklære krig mot andre familier.</p>
                <?php if($row_member['role'] == 1 || $row_member['role'] == 2){ ?>
                <form method="post">
                    <b style="color: #afafaf;">Kjøp forsvar</b><br>
                    <span style="color: #6e6e6e;">Pris pr forsvar 10 000kr</span><br>
                    <input type="text" id="number" name="forsvar_ant" style="width: 50%;" required><input type="submit" value="Kjøp" name="forsvar_buy" style="width: auto;">
                </form>
                <?php if($row_member['role'] == 1){ ?>
                <br><br>
                <form method="post">
                    <b style="color: #afafaf;">Erklær krig</b><br>
                    <input type="text" name="start_war_name" style="width: 50%;" required><input type="submit" value="Start krig" name="start_war" style="width: auto;">
                </form>
                <?php } } else { } ?>
            </div>
        </div>
        <?php 
            }
        ?>
    </div>

</body>

</html>
<?php 

}

?>

<script>
    $("#selectAll").click(function() {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    $("#submit-code").click(function() {
        $("div.output").html($("#txtarea").val().replace(/\n/g, "<br>"));
    });

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
    
    $('#number').on("keyup", function(e) {
        if (e.keyCode !== 39 && e.keyCode !== 37) {
            this.value = this.value.replace(/ /g, '');
            var number = this.value;
            this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
    });

</script>

