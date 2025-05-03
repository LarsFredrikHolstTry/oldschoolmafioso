<html>
    <head>
        
    </head>
    <body>
        <div class="right_container">
            <div class="side_container" style="margin-bottom: 3px;">
                <div class="side_header">
                        <?php if($account_type == 2){ ?>
                            <span><a style="color: #fff429;" href="?side=profil&bruker=<?php echo $ID ?>"><?php echo $username; ?></a></span>
                        <?php } elseif($account_type == 1){ ?>
                            <span><a style="color: #009fe3;" href="?side=profil&bruker=<?php echo $ID ?>"><?php echo $username; ?></a></span>
                        <?php } elseif($account_type == 3){ ?>
                            <span><a style="color: #93fcff;" href="?side=profil&bruker=<?php echo $ID ?>"><?php echo $username; ?></a></span>
                        <?php } else { ?>
                            <span><a href="?side=profil&bruker=<?php echo $ID ?>"><?php echo $username; ?></a></span>
                        <?php } ?>
                    </div>
                <a href="index.php?side=profil&bruker=<?php echo $ID ?>"><img src="<?php echo $avatar ?>" style="width: 165px; height: auto; margin: 5px;"></a>
                <ul>
                    <li><div class="rankbar" data-balloon-length="small"  aria-label="EXP: <?php echo number($exp); ?>" data-balloon-pos="down"><div style="width: <?php echo $percent7 ?>%;" class="rankbar_progress"><span style="padding: 5px;"><?php echo round($percent7, 3) ?>%</span></div></div></li>
                    <li><b><i class="fab fa-redhat" style="color: #525252"></i></b> <?php echo $rank_name[$rank] ?></li>
                    <li><a href="index.php?side=banken&home"><b><i class="fas fa-coins" style="color: #525252"></i></b> <?php echo number($money); ?> kr</a></li>
                    <li><a href="index.php?side=flyplass"><b><i class="fas fa-city" style="color: #525252"></i></b> <?php echo $city_name[$city]; ?></a></li>
                    <li><a href="index.php?side=sykehus"><b><i class="fas fa-heart" style="color: #525252"></i></b>
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
                
                echo "<li><a href='index.php?side=familie'><b><i class='fas fa-user-secret' style='color: #525252'></i></b> "; 
                echo $family_name = $row_family['name'];
                echo "</a></li>";

            }
                    
                $vars = 0;
            
                $result_varsel = mysqli_query($con, "SELECT * FROM varsel WHERE acc_id='$ID' AND new = '0'");
                while($row_varsel = mysqli_fetch_assoc($result_varsel)) {
                    
                    $vars++;
                    
                }
                    
                $postboks = 0;
                $result_pm_new = mysqli_query($con, "SELECT * FROM pm_new WHERE acc_id1 = '$ID' OR acc_id2 = '$ID'");
                while($row_pm_new = mysqli_fetch_assoc($result_pm_new)) {
                    if($row_pm_new['acc_id1'] == $ID && $row_pm_new['acc_id1_new'] > 0){
                        $postboks++;
                    } elseif($row_pm_new['acc_id2'] == $ID && $row_pm_new['acc_id2_new'] > 0){
                        $postboks++;
                    }
                }
                    
                        
                        ?>

                </ul>
            </div>
            <div class="side_container">
                <div class="side_header">
                    <span>Bruker</span>
                </div>
                <div style="padding: 5px; margin: 5px 0px;">
                    <div style="width: 50%; float: left; text-align: center;">
                        <a style="<?php if($vars > 0) { ?> color: 009fe3; <?php } else { ?> color: grey; <?php } ?> font-size: 11px; text-decoration: none;" href="?side=varsel"><i class="fas fa-bell <?php if($vars > 0) { ?> blink_me <?php } ?>"></i><br>
                            Varsel</a>
                    </div>
                    <div style="width: 50%; float: left; text-align: center;">
                        <a style="<?php if($postboks > 0) { ?> color: 009fe3; <?php } else { ?> color: grey; <?php } ?> font-size: 11px; text-decoration: none;" href="?side=postboks"><i class="fas fa-inbox <?php if($postboks > 0) { ?> blink_me <?php } ?>"></i><br>
                            Innboks</a>
                    </div>
                </div><br>
                <ul>
                    <li><a href="?side=innstillinger">Innstillinger</a></li>
                    <li><a href="?side=block">Blokker spiller</a></li>
                </ul>
            </div>
            <div class="side_container">
                <div class="side_header">
                    <span>Forum</span>
                </div>
                <ul>
                    <li><a href="?side=forum&cat=1">Generelt</a></li>
                    <li><a href="?side=forum&cat=2">Salg / søknad</a></li>
                    <li><a href="?side=forum&cat=3">Off-topic</a></li>
                </ul>
            </div>
            <div class="side_container">
                <ul>
                    <!-- <li><a href="?side=poeng">Poeng</a></li> -->
                    <li><a href="?side=topp5">Topp 5</a></li>
                    <li><a href="?side=statistikk">Statistikk</a></li>
                    <li><a href="?side=gravplass">Gravplass</a></li>
                    <li><a href="?side=faq">FAQ</a></li>
                    <li><a style="color: #738adb" href="https://discord.gg/YD9Pxyu"><i class="fab fa-discord"></i> Discord</a></li>
                    <li><a class="logout" href="loggut.php">Logg ut</a></li>
                </ul>
            </div>
        </div>
        
    </body>
</html>

<style>

.logout:hover {
    color: #f8642c !important;
}
    
</style>