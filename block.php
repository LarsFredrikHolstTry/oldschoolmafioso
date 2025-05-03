<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    if(isset($_POST['block'])){
        if(isset($_POST['user_name'])){
            $username_post = $_POST['user_name'];
            $username_post = mysqli_real_escape_string($con, nl2br(htmlentities($username_post, ENT_QUOTES, 'UTF-8')));

            $check_name = mysqli_query($con, "SELECT * FROM accounts WHERE username = '$username_post'");
            if(mysqli_num_rows($check_name) != 1) {
                echo '<div class="feedback feilmelding">
                    <span>Brukeren eksisterer ikke.</span> 
                </div>';
            } else {
                $sql_block_ = "SELECT * FROM accounts WHERE username='$username_post'";
                $query_block_ = mysqli_query($con, $sql_block_) or die (mysqli_error());
                $row_block_ = mysqli_fetch_assoc($query_block_);

                $ID_block =                   $row_block_['ID'];
                
                if($username_post == $username){
                    echo '<div class="feedback feilmelding">
                        <span>Du kan ikke blokkere deg selv, tulling.</span> 
                    </div>';
                } else {
                    $check_block = mysqli_query($con, "SELECT * FROM block WHERE (acc_id_blocked = '".$ID_block."' AND acc_id = '".$_SESSION['ID']."')");
                    if(mysqli_num_rows($check_block) != 1) {

                        $query = "INSERT into `block` (acc_id, acc_id_blocked, date)
                        VALUES ('".$ID."', '".$ID_block."', '".time()."')";
                        $result = mysqli_query($con, $query);
                        
                        echo '<div class="feedback velykket">
                            <span>Brukeren er nå blokkert.</span> 
                        </div>';
                    } else {
                        echo '<div class="feedback feilmelding">
                            <span>Brukeren er allerede blokkert.</span> 
                        </div>';
                    }
                }
            }
        }
    }
    
    if(isset($_GET['remove'])){
        if(is_numeric($_GET['remove'])){
            $check_id = mysqli_query($con, "SELECT * FROM block WHERE (ID = '".$_GET['remove']."' AND acc_id = '".$_SESSION['ID']."')");
            if(mysqli_num_rows($check_id) != 1) {
                echo '<div class="feedback feilmelding">
                    <span>Ugyldig handling.</span> 
                </div>';
            } else {
                $del = mysqli_query($con, "DELETE FROM block WHERE ID = '".$_GET['remove']."'") or die(mysqli_error()); 

                echo '<div class="feedback velykket">
                    <span>Blokkert spiller ble fjernet.</span> 
                </div>';
            }
        } else {
            echo '<div class="feedback feilmelding">
                <span>Ugyldig handling.</span> 
            </div>';
        }
    }
    
?>
<!-- CONTENT -->
<html>

<head></head>

<body>
    <div class="breadcrumb">
        <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">Blokker spiller</span>
        <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
    </div>
    <div class="content">
        <div class="header">
            <span>Blokker spiller</span>
        </div>
        <div class="pad_10">
            <p>Dersom du får uønsket innhold i form av trakassering eller lignende fra en annen bruker kan du blokkere spilleren ved å legge han til i blokkerings-listen.</p>
            <form action="" method="post">
                <input type="text" name="user_name" style="width: 70%; float:left;" placeholder="Brukernavn">
                <input type="submit" class="no" name="block" style="width: 25%;" value="Blokkér">
            </form>
        </div>
        <div class="header header_mid">
            <span>Blokkerte spillere</span>
        </div>
            <table border="0" cellspacing="0" cellpadding="0">
                <tr style="height: 25px;">
                    <th style="padding-left: 10px; width: 40%;">Brukernavn</th>
                    <th style="width: 30%;">Dato blokkert</th>
                    <th style="width: 20%;"></th>
                </tr>
                <?php 
    
        $check_me = mysqli_query($con, "SELECT * FROM block WHERE acc_id = '$ID'");
        if(mysqli_num_rows($check_me) >= 1){

            $result_block = mysqli_query($con, "SELECT * FROM block WHERE acc_id = '$ID' ORDER BY DATE DESC");
            while($row_block = mysqli_fetch_assoc($result_block)) {
                
                $ID_blocked = $row_block['acc_id_blocked'];
                $date = $row_block['date'];

                $sql_blocked = "SELECT * FROM accounts WHERE ID='$ID_blocked'";
                $query_blocked = mysqli_query($con, $sql_blocked) or die (mysqli_error());
                $row_blocked = mysqli_fetch_assoc($query_blocked);

                $username_blocked = $row_blocked['username'];
                
                ?>
                <tr style="height: 35px;">
                    <td style="padding-left: 10px;"><?php echo $username_blocked; ?></td>
                    <td>
                        <?php 
                    echo $days[date('N', $date)]; 
                    echo " "; echo date('d', $date);
                    echo ". "; echo $month[date('n', $date)];
                    echo " - kl "; echo date('H:i', $date);
                        ?>
                    </td>
                    <td style="text-align: right;"><a class="link_as_button no" href="?side=block&remove=<?php echo $row_block['ID']?>">Fjern</a></td>
                </tr>
            <?php } } ?>

        </table>
    </div>
</body>

</html>
<?php 

}

?>