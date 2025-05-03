
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    
    if(isset($_POST['send_msg'])){
        $sql = "SELECT * FROM accounts WHERE username='".$_POST['username']."'";
        $query = mysqli_query($con, $sql) or die (mysqli_error());
        $row_acc_to = mysqli_fetch_assoc($query);
        
        $username =     $_POST['username'];
        $title =        $_POST['title'];
        $text =         $_POST['text'];
        
        $check_blocked = mysqli_query($con, "SELECT * FROM block WHERE (acc_id = '".$row_acc_to['ID']."' AND acc_id_blocked = '".$_SESSION['ID']."') OR (acc_id_blocked = '".$row_acc_to['ID']."' AND acc_id = '".$_SESSION['ID']."')");
        if(mysqli_num_rows($check_blocked) >= 1){
            echo '<div class="feedback feilmelding">
                <span>Du har ikke mulighet til å sende melding til vedkommende. Du har enten blokkert spilleren eller så har du blitt blokkert av spilleren.</span> 
            </div>';
        } else {
        
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
                $text = stripslashes($text);
        }
        //We protect the variables
        $text = mysqli_real_escape_string($con, nl2br(htmlentities($text, ENT_QUOTES, 'UTF-8')));
        strip_tags($text);
        
        if(empty($title)){
            $title = "Ingen tittel";
        } else {
            $title = $title;
        }
        
        if(empty($text)){
            $text = "Ingen meldinger";
        } else {
            $text = $text;
        }
        
        $pm_ID = uniqid();
        $time = time();
        
        $query = "INSERT into `pm` (pm_ID, acc_id_from, acc_id_to, title, date)
        VALUES ('$pm_ID', '$ID', '".$row_acc_to['ID']."', '$title', '$time')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `pm_text` (pm_ID, acc_id, text, date)
        VALUES ('$pm_ID', '$ID', '".$text."', '$time')";
        $result = mysqli_query($con, $query);
        
        $query = "INSERT into `pm_new` (pm_ID, acc_id1, acc_id1_new, acc_id2, acc_id2_new)
        VALUES ('$pm_ID', '$ID', '0', '".$row_acc_to['ID']."', '1')";
        $result = mysqli_query($con, $query);
        
           echo '<div class="feedback velykket">
                <span>Meldingen ble sendt.</span> 
            </div>';
        }
    }
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Bruker » Postboks » </span><span style="color: #afafaf;">Ny melding</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Ny melding</span>
            </div>
            <div class="pad_10" style="padding-top: 0;">
                <form method="post">
                    <p style="margin-bottom: 5px;">Brukernavn</p>
                    <input type="text" name="username" <?php if(isset($_GET['id'])){ ?> value = "<?php fetch_nick_quote($_GET['id'], $con) ?>" <?php } ?>>

                    <p style="margin-bottom: 5px;">Tittel</p>
                    <input type="text" name="title">

                    <p style="margin-bottom: 5px;">Melding</p>
                    <textarea name="text" style="color: #e7e4de;" id="txtarea" rows="10" cols="67" style="white-space: pre-line;"  wrap="nowrap"></textarea>         

                    <input style="margin: 0;" type="submit" name="send_msg">
                </form>
            </div>
        </div>
    </body>
</html>
<?php 

}

?>