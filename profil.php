<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<html>

<head></head>

<body>
    <?php
            if(isset($_GET['bruker'])){
                
                $check_id = mysqli_query($con, "SELECT ID FROM accounts WHERE ID = '".$_GET['bruker']."'");
                if(mysqli_num_rows($check_id) > 0){
                } else {
                    header("Location: index.php");
                }
                
                if($_GET['bruker'] == null){
                    header("Location: index.php");
                }
                
                $sql = "SELECT * FROM stats WHERE acc_id='".$_GET['bruker']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_stat = mysqli_fetch_assoc($query);
                
                $killz = $row_stat['kills'];
                
                $sql = "SELECT * FROM accounts WHERE ID='".$_GET['bruker']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_profile = mysqli_fetch_assoc($query);

                $ID_profile =               $row_profile['ID'];
                $username_profile =         $row_profile['username'];
                $avatar_profile =           $row_profile['avatar'];
                $role_profile =             $row_profile['role'];
                $acc_type_profile =         $row_profile['account_type'];
                $profile_profile =          $row_profile['profile'];
                $profile_money =            $row_profile['money'];
                $profile_bank_money =       $row_profile['bank_money'];
                $register_profile =         $row_profile['register_date'];
                $last_active_profile =      $row_profile['last_active'];
                $rank_profile =             $row_profile['rank'];
                $exp_profile =              $row_profile['exp'];

                $profile_all_money = ($profile_money + $profile_bank_money);

        ?>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Profil » </span><span style="color: #afafaf;"><?php echo $username_profile; ?></span> <?php if($account_type == 2 || $account_type == 1){ ?><a style="text-decoration: none; color: grey" href="index.php?side=sjekk_spiller&id=<?php echo $ID_profile; ?>">[SJEKK SPILLER]</a><?php } ?>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <?php if(($register_profile + 432000) > time()){ ?>
    <div class="breadcrumb">
        <span style="color: #afafaf;">Brukeren har startbeskyttelse og kan ikke drepe eller bli drept før
            <?php  
                $drep_meg_dato = $register_profile + 432000;

                echo " "; echo date('d', $drep_meg_dato);
                echo ". "; echo $month_short[date('n', $drep_meg_dato)];
                echo " - "; echo date('H:i', $drep_meg_dato);  ?></span>
    </div>
    <?php } ?>
    <?php 
                
$check_half_hp = mysqli_query($con, "SELECT * FROM half_hp WHERE acc_id = '".$ID_profile."'");
if(mysqli_num_rows($check_half_hp) > 0) {
    
$sql = "SELECT * FROM half_hp WHERE acc_id='".$ID_profile."'";
$query = mysqli_query($con, $sql) or die (mysqli_error());
$row_half_hp = mysqli_fetch_assoc($query);
    
$timeout = $row_half_hp['timeout'];
    ?>
    <div class="breadcrumb">
        <span style="color: #afafaf;">Brukeren har nylig angrepet en spiller og har dermed redusert liv.</span>
    </div>
    <?php } ?>
    <div class="content">
        <div style="width: 100%; height: 220px;">
            <div class="profile_left pad_10">
                <img class="hedder" src="<?php echo $avatar_profile ?>">
            </div>
            <div class="profile_right pad_5">
                <table>
                    <tr>
                        <td style="width: 50%; text-align: right;">Brukernavn:</td>
                        <?php if($acc_type_profile == 2){ ?>
                        <td style="width: 50%;"><a style="color: #fff429;" href="index.php?side=ny_melding&id=<?php echo $ID_profile ?>"><?php echo $username_profile ?></a></td>
                        <?php } elseif($acc_type_profile == 1){ ?>
                        <td style="width: 50%;"><a style="color: #009fe3;" href="index.php?side=ny_melding&id=<?php echo $ID_profile ?>"><?php echo $username_profile ?></a></td>
                        <?php } elseif($acc_type_profile == 0){  ?>
                        <td style="width: 50%;"><a style="color: grey;" href="index.php?side=ny_melding&id=<?php echo $ID_profile ?>"><?php echo $username_profile ?></a></td>
                        <?php } elseif($acc_type_profile == 69 || $acc_type_profile == 68){ ?>
                        <td style="width: 50%;"><a style="color: red;" href="index.php?side=ny_melding&id=<?php echo $ID_profile ?>"><?php echo $username_profile ?></a></td>
                        <?php } elseif($acc_type_profile == 3){ ?>
                        <td style="width: 50%;"><a style="color: #93fcff;" href="index.php?side=ny_melding&id=<?php echo $ID_profile ?>"><?php echo $username_profile ?></a></td>
                        <?php } ?>
                    </tr>
                    <tr style="background-color: #1b1b1b">
                        <td style="text-align: right;">Status:</td>
                        <td><?php echo $account_type_status[$acc_type_profile]; ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Rolle:</td>
                        <td><?php if($acc_type_profile == 2){ echo 'N/A'; } else { echo $role_status[$role_profile]; } ?></td>
                    </tr>
                    <tr style="background-color: #1b1b1b">
                        <td style="text-align: right;">Rank:</td>
                        <td><?php if($acc_type_profile == 2){ echo 'N/A'; } else { echo $rank_name[$rank_profile];  ?>
                            <?php if($exp_profile > 400000000){ ?>
                            <i style="color: gold" class="fas fa-crown"></i>
                            <?php } elseif($exp_profile > 800000000){ ?>
                            <i style="color: silver" class="fas fa-crown"></i>
                            <?php } } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">Pengerank:</td>
                        <td><?php  if($acc_type_profile == 2){ echo 'N/A'; } else { pengerank($profile_all_money); } ?></td>
                    </tr>
                    <tr style="background-color: #1b1b1b">
                        <td style="text-align: right;">Antall drap:</td>
                        <td><?php if($killz < 1){ ?> 0 <?php } else{ echo number($killz); } ?></td>
                    </tr>
                    <tr style="background-color: #1b1b1b">
                        <td style="text-align: right;">Registrert:</td>
                        <td><?php  
                
                    $date_ = date('Y-m-d', $register_profile);
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('yesterday')); 

                    if ($date_ == $today) {
                        echo "I dag";
                        echo " kl "; echo date('H:i', $register_profile);
                    } elseif ($date_ == $yesterday) {
                        echo "I går";
                    } else {
                        echo " "; echo date('d', $register_profile);
                        echo ". "; echo $month_short[date('n', $register_profile)];
                        echo " - "; echo date('H:i', $register_profile); 
                    }

                                ?></td>
                    </tr>
                    <tr style="background-color: #1b1b1b;">
                        <td style="text-align: right;">Sist aktiv:</td>
                        <td><?php  
                
                    $date__ = date('Y-m-d', $last_active_profile);
                    $today__ = date('Y-m-d');
                    $yesterday__ = date('Y-m-d', strtotime('yesterday')); 

                    if($last_active_profile > (time() - 300)){
                        echo "<span style='color: #009fe3;'>Nå (";
                        echo date('H:i', $last_active_profile);
                        echo ")</span>";
                    } elseif ($date__ == $today__) {
                        echo "<span style='color: #009fe3;'>I dag (";
                        echo date('H:i', $last_active_profile);
                        echo ")</span>";
                    } elseif ($date__ == $yesterday__) {
                        echo "I går";
                        echo " kl "; echo date('H:i', $last_active_profile);
                    } else {
                        echo " "; echo date('d', $last_active_profile);
                        echo ". "; echo $month_short[date('n', $last_active_profile)];
                        echo " - "; echo date('H:i', $last_active_profile); 
                    }
                                ?></td>
                    </tr>
                    <tr style="background-color: #1b1b1b">
                        <td style="text-align: right;">Familie:</td>
                        <td><?php 
                
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE acc_id = '$ID_profile'");

            if(mysqli_num_rows($check_family) > 0) {
                
                $sql = "SELECT * FROM family_member WHERE acc_id='".$ID_profile."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_fam_member = mysqli_fetch_assoc($query);
                
                $family_id = $row_fam_member['family_id'];
                $role =      $row_fam_member['role'];

                $sql = "SELECT * FROM family WHERE ID='".$family_id."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_fam = mysqli_fetch_assoc($query);
                
                $family_name = $row_fam['name'];
                
                echo $family_role[$role];
                echo "<a href='index.php?side=familie_profil&id=".$family_id."'</a>";
                echo $family_name;
                
            } else { echo 'Ingen'; }
                                
                                ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="header header_mid">
            <span>Profiltekst</span>
        </div>
        <div class="profiltekst pad_5">
            <div class="output" style=" word-wrap: break-word; margin-top: -15px; white-space: pre-line;">
                <?php 

                    $profile_profile = showBBcodes($profile_profile);
                    
                    echo $profile_profile 

                    ?>
            </div>
        </div>
    </div>
    <?php
                
            } else {
                header("Location: index.php");
            }
        
        ?>
</body>

</html>
<?php } ?>
