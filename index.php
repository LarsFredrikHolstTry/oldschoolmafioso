<?php

include("auth.php"); 
include("db/db.php");
include("functions/function.php"); 

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title><?php 
            
            $vars = 0;
            
                $result_varsel = mysqli_query($con, "SELECT * FROM varsel WHERE acc_id='$ID' AND new = '0'");
                while($row_varsel = mysqli_fetch_assoc($result_varsel)) {
                    
                    $vars++;
                    
                }
            
            if($vars >= 1){
             echo "(" . $vars . " nye varsler) -"; ?>
    
            <?php } ?> Mafioso</title>
        <meta charset="UTF-8">
        <meta name="description" content="Mafioso er et norsk tekstbasert mafiaspill hvor det handler om å bygge opp makt og jobbe strategisk for å nå toppen."/>
        <meta name="keywords" content="Mafiaspill, Tekstbasert spill"/>
        <meta name="author" content="Mafioso" />
        <meta name="robots" content="follow"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
        <script src="jquery-3.4.1.min.js"></script>
        <script src="js/js.js"></script>
        <link rel="shortcut icon" href="img/favicon.ico">
        <script src="https://kit.fontawesome.com/d5c3b4fdd3.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">
        <link href='jquery-ui.css' rel='stylesheet' type='text/css'> 
        <script src='jquery-3.2.1.min.js' type='text/javascript'></script> 
        <script src='jquery-ui.js' type='text/javascript'></script> 
        <script src='script.js' type='text/javascript'></script>

<?php 

$result = mysqli_query($con, "UPDATE page_views SET value = (value + 1) WHERE acc_id='$ID'")
or die (mysqli_error($con));
        
        ?>
		
		<style>
            
@media screen and (min-width: 0px) and (max-width: 800px) {
	.mobile_bottom{
		display: block;
	}
			}

@media screen and (min-width: 801px) {
	.mobile_bottom{
		display: none;
	}
			}
			
	.mobile_bottom{
		position: fixed; 
        border-top: 1px solid #2c2c2c;
		width: 100%; 
		height: 55px; 
		background-color: #1b1b1b;
		bottom: 0;
	}

	body, html {
	  margin: 0;
	}

	.mobile_bottom a {
		color: #606060;
		text-decoration: none;
	}

	.ready {
		color: #009fe3 !important;
	}
    

		</style>
        <?php if($design == 1){ ?>
        <style>
            div {
                border-color: #202020 !important;
                border-radius: 3px;
            }
        </style>
        <?php } elseif($design == 2){ ?>
        <style>
            div {
                border-color: #26617a !important;
            }
        </style>
        <?php } elseif($design == 3){ ?>
        <style>
            div {
                border-color: #882425 !important;
            }
        </style>
        <?php } elseif($design == 4){ ?>
        <style>
            img {
                display : none !important;
            }
            
            .hedder {
                display: block !important;
            }
            
            
        </style>
        <?php }  elseif($design == 5){ ?>
        <style>
            html {
                background-image: none;
                text-shadow: none !important;
                
            }
            
            .breadcrumb {
                background-color: white;
            }
            
            .side_container, .content {
                background-color: white !important;
                box-shadow: none;
                border: 1px solid grey;
            }
            
            .side_container ul li a {
                color: black !important; 
                text-shadow: none;
            }
            
            .side_header, .header, .rankbar {
                background-image: linear-gradient(
                    to top, 
                    #f1f1f1 50%,
                    #ffffff 50%
                );
                color: black;

            }
            
            b, li, table, td, tr, th, tbody {
                color: black !important;
            }
            
            .rankbar_progress {
                background-image: linear-gradient(
                    to top, 
                    #c1c1c1 50%,
                    #cccccc 50%
                );
            }
            
            .side_header span, .header span {
                    color: black !important;
            }
            
            .role_footer {
                background-color: white;
            }
            
            input[type=number], input[type=submit], input[type=text], input[type=password], input[type=email], input[type=file], textarea, .link_as_button, input[type=checkbox] {
                background-color: white;
                color: black !important;
                border: 1px solid grey;
            }
            
            
            .label, .checkmark {
                background-color: white !important;
            }
            
            .label:hover {
                background-color: red !important;
            }
            
            tr:nth-child(even){
                background-color: white;
            }
            
            tr{
                background-color: white !important;
            }
            
            .tablinks, .tab {
                background-color: grey !important;
                color: black;
            }

            
            .active {
                background-color: white !important;
            }
            
        </style>
        <?php } elseif($design == 6){ ?>
        <style>
            .tablinks, .label, .checkmark {
                background-color: #111111 !important;
            }
            
            .tab button.active {
                background-color: #111111 !important;
            }

            html {
                background-image: none;
                background-color: #111111 !important;
            }
            .side_container, .container, .content {
                background-color: #111111;
            }
            
            input[type=number], input[type=submit], input[type=text], input[type=password], input[type=email], input[type=file], textarea, .link_as_button, input[type=checkbox] {
                background-color: #151515;
                color: #009fe3 !important;
            }
            
            div {
                background-color: #111111;
                border-color: #111111 !important;
                border-radius: 3px;
            }
            
            table, tr, th, td {
                background-color: #111111;
            }
            
            .side_header, .header {
                background-image: linear-gradient(
                    to top, 
                    #121212 50%,
                    #141414 50%
                )
            }
        </style>
        <?php }?>
    </head>
    <body onload="startTime(); startDate();">
<div class="mobile_bottom">
<!-- Krim -->
<a <?php if($last_krim <= 0){ ?> class="ready" <?php } ?> href="?side=kriminalitet">
  <div style="float: left; width: 16%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-fist-raised"></i><br><?php 

	if($last_krim <= 0){
		echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
	} else {
		echo '<span id="countdowntimer_krim_mob" style="font-size: 12px; color:#606060;">';
		echo $last_krim;
		echo '</span>';
	}

	?></center>
  </div>
  </a>
 <!-- Biltyveri -->
<a <?php if($last_gta <= 0){ ?> class="ready" <?php } ?> href="?side=biltyveri">
  <div style="float: left; width: 16%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-car"></i><br><?php 

	if($last_gta <= 0){
		echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
	} else {
		echo '<span id="countdowntimer_gta_mob" style="font-size: 12px; color:#606060;">';
		echo $last_gta;
		echo '</span>';
	}

	?></center>
  </div>
  </a>
 <!-- Brekk -->
<a <?php if($last_brekk <= 0){ ?> class="ready" <?php } ?> href="?side=brekk">
  <div style="float: left; width: 17%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-tools"></i><br><?php 

	if($last_brekk <= 0){
		echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
	} else {
		echo '<span id="countdowntimer_brekk_mob" style="font-size: 12px; color:#606060;">';
		echo $last_brekk;
		echo '</span>';
	}

	?></center>
  </div>
  </a>
 <!-- Stjel -->
<a <?php if($last_steal <= 0){ ?> class="ready" <?php } ?> href="?side=stjel">
  <div style="float: left; width: 17%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-dollar-sign"></i><br><?php 

	if($last_steal <= 0){
		echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
	} else {
		echo '<span id="countdowntimer_steal_mob" style="font-size: 12px; color:#606060;">';
		echo $last_steal;
		echo '</span>';
	}

	?></center>
  </div>
  </a>
 <!-- RC -->
	<?php   
	
		$sql = "SELECT * FROM race_club_cd WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
		$query = mysqli_query($con, $sql) or die (mysqli_error());
		$row_raceclub_cd = mysqli_fetch_assoc($query);

	?>
<a <?php if($row_raceclub_cd['race_club_status'] == 0){ ?> class="ready" <?php } ?> href="?side=raceclub&home">
  <div style="float: left; width: 17%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-flag-checkered"></i><br><?php 


		if($row_raceclub_cd['race_club_status'] == 0){
			echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
		} else {
			echo '<span id="countdowntimer_rc_mob" style="font-size: 12px; color:#505050;">';
			echo $row_raceclub_cd['race_club_seconds'] - time();
			echo '</span>';
		}

		?></center>
  </div>
  </a>
 <!-- Film -->
<a <?php if($last_film <= 0){ ?> class="ready" <?php } ?> href="?side=filmproduksjon">
  <div style="float: left; width: 17%; padding-top: 8px; height: 100%; background-color: #1b1b1b;">
  <center><i style="font-size: 25px;" class="fas fa-video"></i><br><?php 

		if($last_film <= 0){
			echo '<span style="font-size: 12px; color: #009fe3;">klar!</span>';
		} else {
			echo '<span id="countdowntimer_film_mob" style="font-size: 12px; color:#505050;">';
			echo $last_film;
		}

		?></center>
  </div>
  </a>
</div>
		
        <div class="container">

            <!-- MOBIL SHIT lol start -->
            <div class="mobile_header" style="width: auto; height: 45px; background-color: #1b1b1b; padding: 5px; border: 1px solid #2c2c2c;">
                
<script>
function openNav_left() {
  document.getElementById("mySidenav_left").style.width = "250px";
}

function closeNav_left() {
  document.getElementById("mySidenav_left").style.width = "0";
}
    
function openNav_right() {
  document.getElementById("mySidenav_right").style.width = "250px";
}

function closeNav_right() {
  document.getElementById("mySidenav_right").style.width = "0";
}
</script>
              
                
                
                <div id="mySidenav_left" style="background-color: #1b1b1b; height: 100%;" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav_left()">&times;</a>
                    <div class="left_container_mobile">
                    <div style="width:99%;" class="side_container">
                        <ul>
                            <li><a href="?side=oppdrag">Oppdrag i <?php if($city == 0) { echo 'Kr.sand'; } else { echo $city_name[$city]; } ?></a></li>
                            <li><a href="?side=hurtig_oppdrag">Hurtig oppdrag</a></li>
                            <?php if($city == 1) { ?> <li><a href="?side=heist">Heist Oslo</a></li> <?php } ?>

                        </ul>
                    </div>

                    <div  style="width:99%;" class="side_container">
                        <div class="side_header">
                            <span>Diverse</span>
                        </div>
                        <ul>
                            <li><a href="?side=banken&home">Banken</a></li>
                            <li><a href="index.php">Nyheter</a></li>
                            <li><a href="?side=aksjemarked&my_acc">Aksjemarked</a></li>
                            <li><a href="?side=fynn">Fynn.no</a></li>
                            <li><a href="?side=crypto">Crypto farm 
                                <?php
                        
                    $sql = "SELECT * FROM crypto_farm WHERE acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."'";
                    $query = mysqli_query($con, $sql) or die (mysqli_error());
                    $row_cf = mysqli_fetch_assoc($query);
                        
                        if($row_cf['status'] == 1){
                            echo '<span style="float: right; color: #009fe3;">klar!</span>';
                        }
                        ?></a></li>

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
                    <div  style="width:99%;" class="side_container">
                        <div class="side_header">
                            <span>Drap</span>
                        </div>
                        <ul>
                            <li><a href="?side=drep">Drep</a></li>
                            <li><a href="?side=detektiv">Detektiv</a></li>
                            <li><a href="?side=livvakt">Livvakt</a></li>
                            <?php if($bunker == 1 && $beskyttelse > 1){ ?>
                            <li><a href="?side=bunker">Bunker</a></li>
                            <?php } ?>
                            <li><a href="?side=bolig">Bolig</a></li>
                            <li><a href="?side=vapen">Våpen</a></li>
                            <li><a href="?side=kf">Kulefabrikk</a></li>

                        </ul>
                    </div>
                    <div  style="width:99%;" class="side_container">
                        <div class="side_header">
                            <span>Gambling</span>
                        </div>
                        <ul>
                            <li><a href="?side=kast_mynt">Kast mynt</a></li>
                            <li><a href="?side=roulette">Roulette</a></li>
                            <li><a href="?side=slots">Enarmet banditt</a></li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>
                    </div>
                    <?php if($account_type > 0){ ?>
                    <div  style="width:99%;" class="side_container">
                        <div class="side_header">
                            <span>Admin</span>
                        </div>
                        <ul>
                            <li><a href="?side=sjekk_spiller">Sjekk spiller</a></li>
                            <li><a href="?side=happy_hour">Happy hours</a></li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
                </div>
                
                <div class="left_button"  onclick="openNav_left()" style="position: relative;">
                <i style="position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); font-size: 20px; <?php if($row_cf['status'] == 1){ ?> color: #009fe3; <?php }else{ ?> color: #e7e4de; <?php } ?>" class="fas fa-ellipsis-v"></i>
                </div>
                <div class="middle_logo">
                    <div style=" 
    vertical-align:middle;
    text-align:center;">
                    <img src="img/header/text.png" style="padding-top: 3px; width: 150px; height: auto;">
                        </div>
                </div>
                
                <div id="mySidenav_right" style="background-color: #1b1b1b; margin-bottom: 500px !important;" class="sidenav" style="float: right;">
                  <a href="javascript:void(0)" style="left: -50;" class="closebtn" onclick="closeNav_right()">&times;</a>
                    <div class="right_container_mobile">
                        <div  style="width:100%;" class="side_container" style="margin-bottom: 3px;">
                            <ul>
                                <li><?php fetch_nick($ID, $con); ?></li>
                                <li><div class="rankbar" data-balloon-length="small"  aria-label="EXP: <?php echo number($exp); ?>" data-balloon-pos="down"><div style="width: <?php echo $percent7 ?>%;" class="rankbar_progress"><span style="padding: 5px;"><?php echo round($percent7, 3) ?>%</span></div></div></li>
                                <li><b>Rank:</b> <?php echo $rank_name[$rank] ?></li>
                                <li><a href="index.php?side=banken"><b>Penger:</b> <?php echo number($money); ?> kr</a></li>
                                <li><a href="index.php?side=flyplass"><b>By: </b><?php echo $city_name[$city]; ?></a></li>
                                <li><a href="index.php?side=sykehus"><b>Helse: </b>
                                    <?php 
                                    if($helse > 70){ 
                                        echo $helse;
                                        echo '%';
                                    } elseif($helse < 70 && $helse > 20){ 
                                        echo '<span style="color: orange;">';
                                        echo $helse;
                                        echo '%</span>';
                                    }  elseif($helse < 20){ 
                                        echo '<span style="color: red;">';
                                        echo $helse;
                                        echo '%</span>';
                                    }
                                    ?>

                                </a></li>
                            </ul>
                        </div>
                        <?php 

                        $vars = 0;

                            $result_varsel = mysqli_query($con, "SELECT * FROM varsel WHERE acc_id='$ID' AND new = '0'");
                            while($row_varsel = mysqli_fetch_assoc($result_varsel)) {

                                $vars++;

                            }

                                if($vars == 1){
                                    ?>
                        <a href="?side=varsel">
                        <div style="width:100%;" class="side_container" style="border: 0;">
                            <div class="side_header" style="
                                background-image: linear-gradient( to top, #921b18 50%, #bb1d1a 50% );
                                border: 1px solid #e23936;">
                                <span style="color: white;">Du har <?php echo $vars ?> ulest varsel</span>
                            </div>
                        </div>
                        </a>
                        <?php } elseif($vars > 1){ ?>
                        <a href="?side=varsel">
                        <div style="width:100%;" class="side_container" style="border: 0;">
                            <div class="side_header" style="
                                background-image: linear-gradient( to top, #921b18 50%, #bb1d1a 50% );
                                border: 1px solid #e23936;">
                                <span style="color: white;">Du har <?php echo $vars ?> uleste varsler</span>
                            </div>
                        </div>
                        </a>
                            <?php
                                }
                        ?>
                        <div style="width:100%;" class="side_container">
                            <div class="side_header">
                                <span>Bruker</span>
                            </div>
                            <ul>
                                <li><a href="?side=postboks">Postboks <?php
            
                        $i = 0;
            $result_pm_new = mysqli_query($con, "SELECT * FROM pm_new WHERE acc_id1 = '$ID' OR acc_id2 = '$ID'");
            while($row_pm_new = mysqli_fetch_assoc($result_pm_new)) {
                if($row_pm_new['acc_id1'] == $ID && $row_pm_new['acc_id1_new'] > 0){
                    $i++;
                } elseif($row_pm_new['acc_id2'] == $ID && $row_pm_new['acc_id2_new'] > 0){
                    $i++;
                }
            }
                        
            if($i > 0) {
                echo '<span style=" color: #009fe3;">(';
                echo $i;
                echo ')</span>';
            }

            ?></a></li>
                                <li><a href="?side=varsel">Varsler</a></li>
                                <li><a href="?side=innstillinger">Innstillinger</a></li>
								<li><a href="?side=online">Spillere pålogget</a></li>
                            </ul>
                        </div>
                        <div style="width:100%;" class="side_container">
                            <div class="side_header">
                                <span>Forum</span>
                            </div>
                            <ul>
                                <li><a href="?side=forum&cat=1">Generelt</a></li>
                                <li><a href="?side=forum&cat=2">Salg / søknad</a></li>
                                <li><a href="?side=forum&cat=3">Off-topic</a></li>
                            </ul>
                        </div>
                        <div style="margin-bottom: 500px !important; width:100%;" class="side_container">
                            <ul>
                                <li><a href="?side=topp5">Topp 5</a></li>
                                <li><a href="?side=statistikk">Statistikk</a></li>
                                <li><a href="?side=gravplass">Gravplass</a></li>
                                <li><a href="?side=faq">FAQ</a></li>
                                <li><a class="logout" href="loggut.php">Logg ut</a></li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="right_button"  onclick="openNav_right()" style="position: relative;">
                <i style="position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); font-size: 20px; <?php if(($i > 0) || ($vars > 0)){ ?> color: #009fe3; <?php }else{ ?>color: #e7e4de;<?php } ?>" class="fas fa-ellipsis-v"></i>

                </div>
            </div>
            <!-- MOBIL SHIT lol slutt -->
            <div class="header_container" style="padding-bottom: 2px;">
                <?php 
                
                $sql = "SELECT * FROM happy_hour ORDER BY end DESC";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row = mysqli_fetch_assoc($query);

                $happy_hour =       $row['happy_hour'];
                $start =            $row['start'];
                $end =              $row['end'];
                
                if(time() > $end){
                    $result = "UPDATE happy_hour SET happy_hour = '0'";
                    mysqli_query($con, $result) or die("Bad query: $result"); 
                }
                ?>
                <div class="tag_right tag" style="margin-bottom: 2px;"><span><a href="index.php?side=online"><?php 
                    
                    $online = 0;
                    $differanse = time() - 900;
                    
        $result_online = mysqli_query($con, "SELECT * FROM accounts WHERE last_active > '$differanse'");
        while($row_online = mysqli_fetch_assoc($result_online)) {

            $online++;

        }
                          
            echo $online;
                    
                    ?> mafiosoer pålogget</a></span></div>

                <?php if($happy_hour == 1){ ?>
                <div class="tag_left tag" style="margin-bottom: 2px;"><span class="help" data-balloon-length="large" aria-label="Happy hour varer til <?php
                    echo " "; echo date('d', $end);
                    echo ". "; echo $month_short[date('n', $end)];
                    echo ". kl "; echo date('H:i:s', $end);
                 ?> Dette gir dobbel exp på krim, brekk, biltyveri, oppdrag og gebyrfri overførsel i banken" data-balloon-pos="down">Happy hour!</span></div>
                
                <?php } ?>
                <a href="?side=hjem">
                    <?php if($header == 0){ ?>
                    <img class="hedder" src="img/community_header/mafioso_1.png">
                    <?php } elseif($header == 1){ ?>
                    <img class="hedder" src="img/community_header/mafioso_2.png">
                    <?php } elseif($header == 2){ ?>
                    <img class="hedder" src="img/community_header/savior.png">
                    <?php } elseif($header == 3){ ?>
                    <img class="hedder" src="img/community_header/sleep.png">
                    <?php } elseif($header == 4){ ?>
                    <img class="hedder" src="img/community_header/mafioso_3.png">
                    <?php } ?>
                </a>
            </div>
            <?php if($act_bar == 0){ ?>
            <style>
                
.action_menu {
    display: table;
    table-layout: fixed;

    width: 100%; 
    height: 35px; 
    border: 1px solid #2c2c2c;
    background-color: #1b1b1b;
    margin: 1px 0px 4px 0px;
    box-shadow: 0px 2px 2px #121212;
}

.action_menu div {
    display: table-cell;
    height: 35px;
    text-align: center;
    padding: 5px;
}

.action_menu div a  {
    font-size: 11px;
    text-decoration: none;
    color: #777777;
    transition: .2s;
}

.action_menu div a:hover  {
    color: #009fe3;
}

@media screen and (max-width:800px) {
    .action_menu {
        display: none !important;
    }
}
    
            
            </style>
            <div class="action_menu">
                <div class="action_div_0">
                    <a href="?side=kriminalitet">Kriminalitet<br><?php 
                        
                        if($last_krim <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_krim" style="color:#505050;">';
                            echo $last_krim;
                            echo '</span>';
                        }
                        
                        ?></a>
                </div>
                <div class="action_div_1">
                    <a href="?side=biltyveri">Biltyveri<br><?php 
                        
                        if($last_gta <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_gta" style="color:#505050;">';
                            echo $last_gta;
                            echo '</span>';
                        }
                        
                        ?></a>

                </div>
                <div class="action_div_2">
                    <a href="?side=brekk">Brekk<br><?php 
                        
                        if($last_brekk <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_brekk" style="color:#505050;">';
                            echo $last_brekk;
                            echo '</span>';
                        }
                        
                        ?></a>

                </div>
                <div class="action_div_3">
                    <a href="?side=stjel">Stjel<br><?php 
                        
                        if($last_steal <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_steal" style="color:#505050;">';
                            echo $last_steal;
                            echo '</span>';
                        }
                        
                        ?></a>

                </div>
                <div class="action_div_4">
                    <a href="?side=raceclub&home">Race Club<br>
                        <?php 
                        
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
                        
                        ?>
                    </a>

                </div>
                <div class="action_div_5">
                    <a href="?side=filmproduksjon">Filmproduksjon<br>
                        <?php 
                        
                        if($last_film <= 0){
                            echo '<span style="color: #009fe3;">klar!</span>';
                        } else {
                            echo '<span id="countdowntimer_film" style="color:#505050;">';
                            echo $last_film;
                        }
                        
                        ?></a>

                </div>
            </div>
        <?php } ?>
            <?php
            
                include("left.php");
                include("right.php");
            
            if(isset($_GET['role'])){
                ?>
            <div class="feedback velykket">
                <span><b>Velkommen!</b> Du valgte rollen <?php echo $role_status[$_GET['role']]; ?>. Fordelene med denne rollen er <?php echo $role_benefit[$_GET['role']]; ?>. Lykke til i kampen om tronen! Om du trenger hjelp med spillet så ta kontakt med Skitzo.</span> 
            </div>
                <?php
            }

            
            if($role == 0){
                include("roles.php");
            } else {
                if(isset($_GET['adminside'])){
                    if($account_type >= 2){
                        $adminside = $_GET['adminside'];

                        if($adminside = "nyhet"){
                            include("ny_nyhet.php");
                        }
                    } else {
                        include("nyheter.php");
                    }
                } else {
                    if(isset($_GET['side'])){
                        
                        /*
                    $result = mysqli_query($con, "UPDATE accounts SET money = (money + 1) WHERE ID='$ID'")
                    or die (mysqli_error($con));
                        */
                        
                        $side = $_GET['side'];
                        if($row_pw['value'] > 560){
                            echo '<div class="feedback mislykket">
                                <span>Du har for mange sidevisninger innen ett minutt!<br>Dette er for å forhindre bruk av jukseprogrammer.<br>Når klokken går over til ett helt minutt kan du refreshe denne siden.</span> 
                            </div>';
                        } else {

                        if($side == "banken"){
                            include("banken.php");
                        } elseif($side == "kriminalitet"){
                            include("kriminalitet.php");
                        } elseif($side == "profil"){
                            include("profil.php");
                        } elseif($side == "biltyveri"){
                            include("biltyveri.php");
                        } elseif($side == "garasje"){
                            include("garasje.php");
                        } elseif($side == "flyplass"){
                            include("flyplass.php");
                        } elseif($side == "filmproduksjon"){
                            include("filmproduksjon.php");
                        } elseif($side == "oppdrag"){
                            include("oppdrag.php");
                        } elseif($side == "innstillinger"){
                            include("innstillinger.php");
                        } elseif($side == "raceclub"){
                            include("raceclub.php");
                        } elseif($side == "forum"){
                            include("forum.php");
                        } elseif($side == "new_topic"){
                            include("new_topic.php");
                        } elseif($side == "topic"){
                            include("topic.php");
                        } elseif($side == "happy_hour"){
                            include("happy_hour.php");
                        } elseif($side == "brekk"){
                            include("brekk.php");
                        } elseif($side == "varsel"){
                            include("varsel.php");
                        } elseif($side == "postboks"){
                            include("postboks.php");
                        } elseif($side == "familie"){
                            include("familie.php");
                        } elseif($side == "sjekk_spiller"){
                            include("sjekk_spiller.php");
                        } elseif($side == "stjel"){
                            include("stjel.php");
                        } elseif($side == "familie_profil"){
                            include("familie_profil.php");
                        } elseif($side == "ny_melding"){
                            include("ny_melding.php");
                        } elseif($side == "online"){
                            include("online.php");
                        } elseif($side == "faq"){
                            include("faq2.php");
                        } elseif($side == "bolig"){
                            include("bolig.php");
                        } elseif($side == "vapen"){
                            include("vapen.php");
                        } elseif($side == "familie_medlemmer"){
                            include("familie_medlemmer.php");
                        } elseif($side == "kf"){
                            include("kf.php");
                        } elseif($side == "kast_mynt"){
                            include("kast_mynt.php");
                        } elseif($side == "hurtig_oppdrag"){
                            include("hurtig_oppdrag.php");
                        } elseif($side == "sykehus"){
                            include("sykehus.php");
                        } elseif($side == "statistikk"){
                            include("statistikk.php");
                        } elseif($side == "bunker"){
                            include("bunker.php");
                        } elseif($side == "heist"){
                            include("heist.php");
                        } elseif($side == "drep"){
                            include("drep.php");
                        } elseif($side == "crypto"){
                            include("crypto.php");
                        } elseif($side == "detektiv"){
                            include("detektiv.php");
                        } elseif($side == "gravplass"){
                            include("gravplass.php");
                        } elseif($side == "familie_rediger_profil"){
                            include("familie_rediger_profil.php");
                        } elseif($side == "familie_donasjon"){
                            include("familie_donasjon.php");
                        } elseif($side == "familiebedrift"){
                            include("familiebedrift.php");
                        } elseif($side == "filmproduksjon_v2"){
                            include("filmproduksjon_v2.php");
                        } elseif($side == "verv"){
                            include("verv.php");
                        } elseif($side == "fynn"){
                            include("fynn.php");
                        } elseif($side == "roulette"){
                            include("roulette.php");
                        } elseif($side == "innbrudd"){
                            include("innbrudd.php");
                        } elseif($side == "slots"){
                            include("slots.php");
                        } elseif($side == "blackjack"){
                            include("blackjack.php");
                        } elseif($side == "topp5"){
                            include("topp5.php");
                        } elseif($side == "oppnaelser"){
                            include("oppnaelser.php");
                        } elseif($side == "hjem"){
                            include("nyheter.php");
                        } elseif($side == "aksjemarked"){
                            include("aksjemarked.php");
                        } elseif($side == "vervekonk"){
                            include("vervekonk.php");
                        } elseif($side == "aksjegraf"){
                            include("aksjegraf.php");
                        } elseif($side == "livvakt"){
                            include("livvakt.php");
                        } elseif($side == "bordell"){
                            include("bordell.php");
                        } elseif($side == "nav"){
                            include("nav.php");
                        } elseif($side == "block"){
                            include("block.php");
                        } else {
                            echo '<div class="feedback feilmelding">
                                <span>404 - side ikke funnet</span> 
                            </div>';
                        }
                        }
                    } else {
                        include("nyheter.php");
                    }
                }
            }
            
            echo '<div style="width: 100%; color:#4b4b4b;"><p style="text-align: center; font-size: 11px;">Spillet er designet og utviklet av Lars Fredrik Holst-Try<br>© Mafioso.no | <a href="terms.php">Vilkår</a></p></div>'
            
            ?>
        </div>
<?php                 
                
               // include("chatbar.php");
?>
                
                </body>
</html>

<script type="text/javascript">

    timer(<?php echo $last_film ?>, "countdowntimer_film_mob");
    timer(<?php echo $row_raceclub_cd['race_club_seconds'] - time() ?>, "countdowntimer_rc_mob");
    timer(<?php echo $last_steal ?>, "countdowntimer_steal_mob");
    timer(<?php echo $last_brekk ?>, "countdowntimer_brekk_mob");
    timer(<?php echo $last_gta ?>, "countdowntimer_gta_mob");
    timer(<?php echo $last_krim ?>, "countdowntimer_krim_mob");
    
    timer(<?php echo $last_krim ?>, "countdowntimer_krim");
    timer(<?php echo $last_gta ?>, "countdowntimer_gta");
    timer(<?php echo $last_brekk ?>, "countdowntimer_brekk");
    timer(<?php echo $last_steal ?>, "countdowntimer_steal");
    timer(<?php echo $row_raceclub_cd['race_club_seconds'] - time() ?>, "countdowntimer_rc");
    timer(<?php echo $last_film ?>, "countdowntimer_film");

</script>