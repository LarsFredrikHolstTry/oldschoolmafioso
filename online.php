
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">Brukere pålogget</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">

            <div class="header">
                <span><?php 
                    
                    $online = 0;
                    $differanse = time() - 900;
                    
        $result_online = mysqli_query($con, "SELECT * FROM accounts WHERE last_active > '$differanse'");
        while($row_online = mysqli_fetch_assoc($result_online)) {

            $online++;

        }
                          
            echo $online;
                    
                    ?> brukere pålogget</span>
            </div>
            <div style="text-align: left; padding: 10px;">
            <?php 
    
        $differanse = time() - 900;
    
        $result_online = mysqli_query($con, "SELECT * FROM accounts WHERE last_active > '$differanse'");
        while($row_online = mysqli_fetch_assoc($result_online)) {
            
    $leader = false;
    $check_leader = mysqli_query($con, "SELECT * FROM family_member WHERE acc_id = '".$row_online['ID']."' AND role = 1");
    if(mysqli_num_rows($check_leader) > 0) { 
        $leader = true;
    }
            
    $okonom = false;
    $check_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE acc_id = '".$row_online['ID']."' AND role = 2");
    if(mysqli_num_rows($check_okonom) > 0) { 
        $okonom = true;
    }

            if($row_online['ID'] == "0"){ ?>
            <a style="color: chocolate; text-decoration: none;" href="index.php?side=profil&bruker=0">Staten</a>,
        <?php } elseif($row_online['account_type'] == 2){ ?>
            <a style="color: #fff429; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
        <?php } elseif($row_online['account_type'] == 1){ ?>
            <a style="color: #009fe3; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
        <?php } elseif($row_online['account_type'] == 3) { ?>
                <a style="color: #93fcff; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
        <?php } elseif($leader == true){ ?>
                <a style="color: chocolate; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
          <?php } elseif($okonom == true){ ?>
                <a style="color: #19bc63; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
          <?php } else { ?>
            <a style="color: grey; text-decoration: none;" href="index.php?side=profil&bruker=<?php echo $row_online['ID'] ?>"><?php echo $row_online['username']; ?></a>,
        <?php }

        }

            ?>
            </div>
            <?php 
    
                    $online_last24hr = 0;
                    $differanse = time() - 900;
            

                    $sincemidnight = time() - mktime(0, 0, 0);
                    $sincemidnight = time() - $sincemidnight;

                    $result_online = mysqli_query($con, "SELECT * FROM accounts WHERE last_active > '$sincemidnight'");
                    while($row_online = mysqli_fetch_assoc($result_online)) {

                        $online_last24hr++;

                    }
                          echo '<br>';
            echo '<center><span style="color:#3e3e3e;">Pålogget dette døgnet: '; echo $online_last24hr; echo '</span></center>';
            echo '<center><span style="color:#fff429;">Administrator</span> - <span style="color:#009fe3;">Moderator</span> - <span style="color:#93fcff;">Forum moderator</span> - <span style="color:grey;">Bruker</span><br><span style="color:chocolate;">Gudfar av familie</span> - <span style="color:#19bc63;">Økonom av familie</span></center>';


            
            ?>
        </div>
        
        <div class="content" style="margin-top: 3px;">
            <div class="header">
                <span>Søk etter spiller</span>
            </div>
            <div style="text-align: center; padding: 5px;">
                <form method="post">
                <input type="text" style="width: 35%;" name="sok_bruker" placeholder="Brukernavn">
                <input type="submit" style="width: auto;" name="sok" value="Søk">
                </form>
            </div>
    <?php
        if(isset($_POST['sok'])) {
            $brukernavn = $_POST['sok_bruker'];
            
            $brukernavn = mysqli_real_escape_string($con, nl2br(htmlentities($brukernavn, ENT_QUOTES, 'UTF-8')));
            
            $check_sort = mysqli_query($con, "SELECT * FROM accounts WHERE username LIKE '%$brukernavn%'");
            
            if(mysqli_num_rows($check_sort) <= 0) {
                echo '<center>Ingen treff</center>';
            } else {

            $result = mysqli_query($con, "SELECT * FROM accounts
            WHERE username LIKE '%$brukernavn%' ORDER BY last_active DESC") or die(mysqli_error());

?>

            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="padding-left: 15px; width: 50%;">Brukernavn</th>
                    <th style="width: 50%;  text-align: right;">Sist aktiv</th>
                </tr>
                  	<?php 
            $search = 0;
        
            while($row = mysqli_fetch_array($result)){
                
                $search++;
                
                ?> 
                <tr style="height: 30px;">
                    <td style="padding-left: 15px; width: 50%;"><?php echo fetch_nick($row['ID'], $con); ?></td>
                    <td style="width: 50%; text-align: right;">
                        <?php  
                
                    $date_ = date('Y-m-d', $row['last_active']);
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('yesterday')); 

                    if ($date_ == $today) {
                        echo "I dag";
                        echo " kl "; echo date('H:i', $row['last_active']);
                    } elseif ($date_ == $yesterday) {
                        echo "I går";
                    } else {
                        echo " "; echo date('d', $row['last_active']);
                        echo ". "; echo $month_short[date('n', $row['last_active'])];
                        echo " - "; echo date('H:i', $row['last_active']); 
                    }

                                ?>
                    
                    
                    </td>
                </tr>
                <?php } 
                
                if($search == 1) {
                    echo fetch_nick($row['ID'], $con);
                } else {
                    
                }
                
                ?>
            </table>
            <?php
            }
        }

?>

        </div>
    </body>
</html>
<?php 

}

?>