
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    if(!isset($_GET['id'])){
        header("Location: index.php");
    } else {
        
    if(isset($_GET['upgrade'])){
        $sql = "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."' AND acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."' AND role = 1";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_kick = mysqli_fetch_assoc($query);
        
        $check_kick = mysqli_query($con, "SELECT * FROM family_member WHERE acc_id = '".$_GET['upgrade']."' AND family_id = '".$row_kick['family_id']."'");
        
        $check_okonom = mysqli_query($con, "SELECT * FROM family_member WHERE family_id = '".$row_kick['family_id']."' AND role = 2");
        
        if($_GET['upgrade'] == $ID){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke oppgradere deg selv siden du er gudfar.</span> 
            </div>';
        } elseif($row_kick['acc_id'] == $ID){
            if(mysqli_num_rows($check_okonom) > 0){
                $sql = "UPDATE family_member SET role = 0 WHERE role = 2";
                mysqli_query($con, $sql);
                
                $sql = "UPDATE family_member SET role = 2 WHERE acc_id = '".$_GET['upgrade']."'";
                mysqli_query($con, $sql);
                
                header("Location: index.php?side=familie_medlemmer&id=".$row_kick['family_id']."&upgraded");

            } elseif(mysqli_num_rows($check_kick) > 0) {
                $sql = "UPDATE family_member SET role = 2 WHERE acc_id = '".$_GET['upgrade']."'";
                mysqli_query($con, $sql);
                
                header("Location: index.php?side=familie_medlemmer&id=".$row_kick['family_id']."&upgraded");
            } else {
                echo '<div class="feedback feilmelding">
                    <span>Spilleren er ikke i din familien!</span> 
                </div>';
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har ikke rettighet til å oppgradere noen i denne familien!</span> 
            </div>';
        }
    }

    if(isset($_GET['kick'])){
        $sql = "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."' AND acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."' AND role = 1";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_kick = mysqli_fetch_assoc($query);
        
        $check_kick = mysqli_query($con, "SELECT * FROM family_member WHERE acc_id = '".$_GET['kick']."' AND family_id = '".$row_kick['family_id']."'");
        
        if($_GET['kick'] == $ID){
            echo '<div class="feedback feilmelding">
                <span>Du kan ikke sparke deg selv, du kan legge ned familien på familie-siden.</span> 
            </div>';
        } elseif($row_kick['acc_id'] == $ID){
            if(mysqli_num_rows($check_kick) > 0) {
                $del = mysqli_query($con, "DELETE FROM family_member WHERE acc_id = '".$_GET['kick']."'") or die(mysqli_error());
                
                $query = "INSERT into `varsel` (acc_id, text, date)
                VALUES ('".$_GET['kick']."', 'Du har blitt sparket fra familien du var medlem i.', '".time()."')";
                $result = mysqli_query($con, $query);
                
                header("Location: index.php?side=familie_medlemmer&id=".$row_kick['family_id']."&kicked");
            } else {
                echo '<div class="feedback feilmelding">
                    <span>Spilleren er ikke i din familien!</span> 
                </div>';
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Du har ikke rettighet til å sparke noen i denne familien!</span> 
            </div>';
        }
    }



?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » Familie » </span><span style="color: #afafaf;">medlemmer</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php
        
        
    if(isset($_GET['kicked'])){
        echo '<div class="feedback velykket">
            <span>Brukeren ble sparket fra din familie, varsel er sendt til vedkommende.</span> 
        </div>';
    }
        
    if(isset($_GET['upgraded'])){
        echo '<div class="feedback velykket">
            <span>Brukeren ble oppgradert til økonom.</span> 
        </div>';
    }
        
        ?>
        <div class="content">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 30px;">
                    <th style="width: 38%; padding-left: 15px;">Medlem</th>
                    <th style="width: 32%">Rolle</th>

                </tr>
                <?php
    
            $result_fam = mysqli_query($con, "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."'");
    
            $i = 0;
            while($row_fam = mysqli_fetch_assoc($result_fam)) {

                $sql = "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."' AND acc_id='". mysqli_real_escape_string($con, $_SESSION['ID'])."' AND role = 1";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_kick = mysqli_fetch_assoc($query);
                
                $sql = "SELECT * FROM family_member WHERE family_id = '".$_GET['id']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_exp = mysqli_fetch_assoc($query);

                $i++;

            ?>
                <tr style="height: 30px;">
                    <td style="padding-left: 15px;"><?php fetch_nick($row_fam['acc_id'], $con); ?>

                    <?php 
                
            $check_family = mysqli_query($con, "SELECT acc_id FROM family_member WHERE family_id = '".$_GET['id']."' AND acc_id='".$ID."'");

            if(mysqli_num_rows($check_family) > 0){
                
                $sql = "SELECT * FROM daily_exp WHERE acc_id = '".$row_fam['acc_id']."'";
                $query = mysqli_query($con, $sql) or die (mysqli_error());
                $row_exp_member = mysqli_fetch_assoc($query);
                
                echo '<br>';
                echo 'EXP ranket i dag: ';
                if($row_exp_member['exp'] == null){
                    echo '0';
                } else {                
                    echo number($row_exp_member['exp']);
                }
            }
                
                        ?>
                    
                    </td>
                    <td><?php echo $family_role_without[$row_fam['role']]; ?> <?php if($row_kick['acc_id'] == $ID){ ?><a href="index.php?side=familie_medlemmer&id=<?php echo $_GET['id']; ?>&upgrade=<?php echo $row_fam['acc_id']; ?>"> [Oppgrader] </a><?php } ?></td>
                    <?php if($row_kick['acc_id'] == $ID){ ?><td><a href="index.php?side=familie_medlemmer&id=<?php echo $_GET['id']; ?>&kick=<?php echo $row_fam['acc_id']; ?>">Spark fra familie</a></td><?php } ?>
                    
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
<?php 
        
    }
}

?>