
<html>
    <head>
        
    </head>
    <body>
        <div class="left_container">
            
            <div class="side_container">
                <ul>
                    <li><a href="?side=oppdrag">Oppdrag i <?php if($city == 0) { echo 'Kr.sand'; } else { echo $city_name[$city]; } ?></a></li>
                    <li><a href="?side=hurtig_oppdrag">Hurtig oppdrag</a></li>
                    <?php if($city == 1){ ?><li><a href="?side=heist">Heist i Oslo</a></li><?php } ?>
                </ul>
            </div>
            <?php if($act_bar == 1){ ?>
            <div class="side_container">
                <div class="side_header">
                    <span>Handlinger</span>
                </div>
                <ul>
                    <li><a href="?side=kriminalitet">Kriminalitet<span style="float: right"><?php 
                        
                        if($last_krim <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_krim" style="color:#505050;">';
                            echo $last_krim;
                            echo '</span>';
                        }
                        
                        ?></span></a></li>
                    <li><a href="?side=biltyveri">Biltyveri<span style="float: right"><?php 
                        
                        if($last_gta <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_gta" style="color:#505050;">';
                            echo $last_gta;
                            echo '</span>';
                        }
                        
                        ?></span></a></li>
                    <li><a href="?side=brekk">Brekk<span style="float: right"><?php 
                        
                        if($last_brekk <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_brekk" style="color:#505050;">';
                            echo $last_brekk;
                            echo '</span>';
                        }
                        
                        ?></span></a></li>
                    <li><a href="?side=stjel">Stjel<span style="float: right"><?php 
                        
                        if($last_steal <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_steal" style="color:#505050;">';
                            echo $last_steal;
                            echo '</span>';
                        }
                        
                        ?></span></a></li>
                    <li><a href="?side=raceclub&home">Race Club<span style="float: right"><?php 
                        
                        $sql = "SELECT * FROM race_club_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                        $query = mysqli_query($con, $sql) or die (mysqli_error());
                        $row_raceclub_cd = mysqli_fetch_assoc($query);
                        
                        if($row_raceclub_cd['race_club_status'] == 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_rc" style="color:#505050;">';
                            echo $row_raceclub_cd['race_club_seconds'] - time();
                            echo '</span>';
                        }
                        
                        ?></span></a></li>
                    <li><a href="?side=filmproduksjon">Filmproduksjon<span style="float: right"><?php 
                        
                        if($last_film <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_film" style="color:#505050;">';
                            echo $last_film;
                        }
                        
                        ?></span></a></li>
                </ul>
            </div>
            <?php } ?>

            <div class="side_container">
                <div class="side_header">
                    <span>Diverse</span>
                </div>
                <ul>
                    <li><a href="?side=banken&home">Banken</a></li>
                    <li><a href="?side=aksjemarked&home">Aksjemarked</a></li>
                    <li><a href="?side=fynn">Fynn.no</a></li>
                    <li><a href="?side=crypto">Crypto farm 
                        <?php
                        
                    $sql = "SELECT * FROM crypto_farm WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_cf = mysqli_fetch_assoc($query);
                        
                        if($row_cf['status'] == 1){
                            echo '<span style="float: right; color: #009fe3;">klar!</span>';
                        }
                        ?>
                        </a></li>
                    <li><a href="?side=flyplass">Flyplass</a></li>
                    <li><a href="?side=garasje">Garasje</a></li>
                    
                    
                    <li><a href="?side=familie">Familie<?php 
                    
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID'");

            if(mysqli_num_rows($check_family) > 0){
                
                $sql = "SELECT * FROM family_member WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_member = mysqli_fetch_assoc($query);
                
                $family_id = $row_member['family_id'];
                
                $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_family = mysqli_fetch_assoc($query);
                
                echo " - "; echo $family_name = $row_family['name'];

            } 
                    
                    ?></a></li>

                </ul>
            </div>
            <div class="side_container">
                <div class="side_header">
                    <span>Drap</span>
                </div>
                <ul>
                    <li><a href="?side=drep">Drep</a></li>
                    <li><a href="?side=detektiv">Detektiv</a></li>
                    <li><a href="?side=livvakt">Livvakt</a></li>
                    <?php if($beskyttelse > 1){ ?>
                    <li><a href="?side=bunker">Bunker</a></li>
                    <?php } ?>
                    <li><a href="?side=bolig">Bolig</a></li>
                    <li><a href="?side=vapen">Våpen</a></li>
                    <li><a href="?side=kf">Kulefabrikk</a></li>

                </ul>
            </div>
            <div class="side_container">
                <div class="side_header">
                    <span>Gambling</span>
                </div>
                <ul>
                    <li><a href="?side=kast_mynt">Kast mynt
                        <?php
                        
    $check_kasst = mysqli_query($con, "SELECT * FROM kast_mynt");

    if(mysqli_num_rows($check_kasst) > 0) {
        $i = 0;
        $result_km = mysqli_query($con, "SELECT * FROM kast_mynt ");
        while($row_km = mysqli_fetch_assoc($result_km)) {
            $i++;

        }
        if($i > 0){
            echo '<span style="float: right; color: #009fe3;">('.$i.')</span>';
        }
    }

                        ?></a></li>
                    <li><a href="?side=roulette">Roulette</a></li>
                    <li><a href="?side=slots">Enarmet banditt</a></li>
                </ul>
            </div>
            <?php if($account_type == 2 || $account_type == 1){ ?>
            <div class="side_container">
                <div class="side_header">
                    <span>Admin</span>
                </div>
                <ul>
                    <?php if($account_type > 0){ ?>
                    <li><a href="?side=sjekk_spiller">Sjekk spiller</a></li>
                    <?php } ?>
                    <?php if($account_type > 0){ ?>
                    <li><a href="?side=happy_hour">Happy hours</a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        
    </body>
</html>

