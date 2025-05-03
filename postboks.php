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
            <span style="color: #3e3e3e;">Bruker » </span><span style="color: #afafaf;">Postboks</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php if(!isset($_GET['id'])){ ?>
        <div class="content" style="overflow: hidden; padding-bottom: 0;">
            <div class="header">
                <span>Postboks (<a href="index.php?side=ny_melding">Ny melding</a>)</span>
            </div>
            <div style="padding: 7px;">
            <?php 
        
                if(isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
            
                $no_of_records_per_page = 10;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM pm WHERE acc_id_from='$ID' OR acc_id_to = '$ID'";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
    
            $result_postboks = mysqli_query($con, "SELECT * FROM pm WHERE acc_id_from='$ID' OR acc_id_to = '$ID' ORDER BY date DESC LIMIT $offset, $no_of_records_per_page");
            while($row_postboks = mysqli_fetch_assoc($result_postboks)) {
                
            $sql = "SELECT * FROM pm_new WHERE pm_ID='".$row_postboks['pm_ID']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_new = mysqli_fetch_assoc($query);
                
                $acc_id1 =      $row_new['acc_id1'];
                $acc_id1_new =  $row_new['acc_id1_new'];

                $acc_id2 =      $row_new['acc_id2'];
                $acc_id2_new =  $row_new['acc_id2_new'];

            ?>
                
                <div class="forum_post pad_5" style="color: #4e4e4e; font-size: 10px !important;">
                    <a style="font-size:12px; text-decoration: none; color:grey;" class="forum_title" href="index.php?side=postboks&id=<?php echo $row_postboks['pm_ID']; ?>">
                        <?php if($acc_id1 == $ID && $acc_id1_new > 0){ ?>
                        <span style="color: #009fe3">NY! </span> -
                        <?php } elseif($acc_id2 == $ID && $acc_id2_new > 0){ ?>
                        <span style="color: #009fe3">NY! </span> -
                        <?php } ?>
                        <?php echo $row_postboks['title']; ?></a><br>
                    <span style="font-size: 10px;">Samtale med: <?php if($row_postboks['acc_id_to'] == $ID){ fetch_nick($row_postboks['acc_id_from'], $con); } else { fetch_nick($row_postboks['acc_id_to'], $con); } ?>-
                        <?php
                
                        echo " Sist aktiv: "; echo date('d', $row_postboks['date']);
                        echo ". "; echo $month_short[date('n', $row_postboks['date'])];
                        echo ". kl "; echo date('H:i', $row_postboks['date']);
                        
                        ?>
                    </span>
                </div>
                
            <?php } ?>
            </div>

        </div>
        
        <?php if($total_pages <= 1) { } else { ?>
        
<div style="margin-top: 4px" class="content">
    <div class="pad_5 pagination">
        <div style="width: 20%; float: left;">
            <span><a href="index.php?side=postboks&pageno=1">«« Første side</a></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=postboks&pageno=".($pageno - 1); } ?>">« Forrige side</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span style="text-align: center;">Side <?php echo $pageno ?></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=postboks&pageno=".($pageno + 1); } ?>">Neste side »</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span><a style="float: right;" href="index.php?side=postboks&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
        </div>
    </div>
</div>
        <?php 
                                              
        } 
        
            } else {
        
        
        
            $sql = "SELECT * FROM pm WHERE pm_ID='".$_GET['id']."'";
            $query = mysqli_query($con, $sql) or die (mysqli_error());
            $row_pm_title = mysqli_fetch_assoc($query);
        
            $check_sort = mysqli_query($con, "SELECT * FROM pm WHERE pm_ID='".$_GET['id']."'");

            if(mysqli_num_rows($check_sort) != 1) { 
                echo '<div class="feedback mislykket">
                    <span>Ingen tilgang.</span> 
                </div>';
                
            } else {
        
        ?>
        <div class="content" style="overflow: hidden; padding-bottom: 0;">
            <div class="header">
                <span><?php echo $row_pm_title['title']; ?> (<a href="index.php?side=postboks">Innboks</a>)</span>
            </div>
            <?php         
        
        if(isset($_GET['answer'])){
           echo '<div class="feedback velykket">
                <span>Meldingen ble sendt.</span> 
            </div>';
        }
        
            if(isset($_POST['answer_pm'])){
                $answer_text =  $_POST['answer_text'];
                $answer_pm =    $_POST['answer_pm'];
                
                
                
        //We remove slashes depending on the configuration
        if(get_magic_quotes_gpc())
        {
                $answer_text = stripslashes($answer_text);
        }
        //We protect the variables
        $answer_text = mysqli_real_escape_string($con, nl2br(htmlentities($answer_text, ENT_QUOTES, 'UTF-8')));
                
                $date = time();
                
                $query = "INSERT into `pm_text` (pm_ID, acc_id, text, date)
                VALUES ('".$_GET['id']."', '$ID', '$answer_text', '$date')";
                $result = mysqli_query($con, $query);
                
                $result_pm_new = mysqli_query($con, "SELECT * FROM pm_new WHERE pm_ID = '".$_GET['id']."'");
                while($row_pm_new = mysqli_fetch_assoc($result_pm_new)) {
                    if($row_pm_new['acc_id1'] != $ID){
                        $result = "UPDATE pm_new SET acc_id1_new = 1 WHERE pm_ID='".$_GET['id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    } elseif($row_pm_new['acc_id2'] != $ID){
                        $result = "UPDATE pm_new SET acc_id2_new = 1 WHERE pm_ID='".$_GET['id']."'";
                        mysqli_query($con, $result) or die("Bad query: $result");
                    }
                }
                
                $result = "UPDATE pm SET date = '$date' WHERE pm_ID='".$_GET['id']."'";
                mysqli_query($con, $result) or die("Bad query: $result");
                
                header("Location: index.php?side=postboks&id=".$_GET['id']."&answer");

            }
        
        ?>
            <?php if($row_pm_title['acc_id_from'] != 0){
                $check_blocked = mysqli_query($con, "SELECT * FROM block WHERE (acc_id = '".$row_pm_title['acc_id_from']."' AND acc_id_blocked = '".$row_pm_title['acc_id_to']."') OR (acc_id_blocked = '".$row_pm_title['acc_id_from']."' AND acc_id = '".$row_pm_title['acc_id_to']."')");
                if(mysqli_num_rows($check_blocked) >= 1){
                    echo '<div class="feedback feilmelding" style="width: 97%;">
                        <span>Du har ikke mulighet til å motta eller sende melding til vedkommende. Du har enten blokkert spilleren eller så har du blitt blokkert av spilleren.</span> 
                    </div>';
                } else {
            ?>
            <div class="pad_10">
                <form method="post">
                    <textarea name="answer_text" style="width: 100%; color: #e7e4de;" id="txtarea" rows="5" wrap="nowrap" required></textarea>         
                    <input style="margin: 0;" type="submit" name="answer_pm" value="Svar">
                </form>
            </div>
            <?php } } ?>

            <?php

            $result_pm = mysqli_query($con, "SELECT * FROM pm_text WHERE pm_ID = '".$_GET['id']."' ORDER BY date DESC");
            while($row_pm = mysqli_fetch_assoc($result_pm)) {
            
            $result_pm_new = mysqli_query($con, "SELECT * FROM pm_new WHERE pm_ID = '".$_GET['id']."'");
            while($row_pm_new = mysqli_fetch_assoc($result_pm_new)) {
                if($row_pm_new['acc_id1'] == $ID && $row_pm_new['acc_id1_new'] > 0){
                    $result = "UPDATE pm_new SET acc_id1_new = 0 WHERE pm_ID='".$_GET['id']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                } elseif($row_pm_new['acc_id2'] == $ID && $row_pm_new['acc_id2_new'] > 0){
                    $result = "UPDATE pm_new SET acc_id2_new = 0 WHERE pm_ID='".$_GET['id']."'";
                    mysqli_query($con, $result) or die("Bad query: $result");
                }
            }
            
            ?>
            <div style="padding: 7px;">
                <div class="forum_post pad_5" style="font-size: 10px !important; ">
                    <span style="color:#3e3e3e;">
                    <?php 
                    if($row_pm['acc_id'] == $ID){
                        echo fetch_nick($ID, $con);
                        echo date('d', $row_pm['date']);
                        echo ". "; echo $month_short[date('n', $row_pm['date'])];
                        echo ". kl "; echo date('H:i', $row_pm['date']);
                        echo '<div style="margin-top: -7px; width: 100%;"></div>';
                    } elseif($row_pm['acc_id'] != $ID){
                        echo fetch_nick($row_pm['acc_id'], $con);
                        echo date('d', $row_pm['date']);
                        echo ". "; echo $month_short[date('n', $row_pm['date'])];
                        echo ". kl "; echo date('H:i', $row_pm['date']);
                        echo '<div style="margin-top: -7px; width: 100%;"></div>';
                    }
                    ?></span><br>
                    <span style="font-size: 12px;"><?php                    
                        
                        $htmltext = showBBcodes($row_pm['text']);

                        echo $htmltext; ?>
                    </span>
                </div>
            </div>
            <?php } ?>

        </div>
        <?php } ?>
    </body>
</html>
<?php 
    }
}

?>

<style>

    .forum_title {
        transition: .3s;
    }
    .forum_title:hover {
        color: #009fe3 !important;
    }

</style>