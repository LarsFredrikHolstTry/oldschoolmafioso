<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 

?>
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Bruker » </span><span style="color: #afafaf;">Varsler</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="header">
                <span>Varsel</span>
            </div>
            <table class="cellpadding" border="0" cellspacing="0" cellpadding="5">
                <tr style="height: 30px;">
                    <th style="width: 5%;"></th>
                    <th style="width: 70%;">Beskrivelse</th>
                    <th style="width: 25%;">Dato</th>
                </tr>
                <?php
                
                if(isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
            
                $no_of_records_per_page = 15;
                $offset = ($pageno-1) * $no_of_records_per_page; 

                $total_pages_sql = "SELECT COUNT(*) FROM varsel WHERE acc_id='$ID'";
                $result = mysqli_query($con, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                
                    $result_varsel = mysqli_query($con, "SELECT * FROM varsel WHERE acc_id='$ID' ORDER BY date DESC LIMIT $offset, $no_of_records_per_page");
                    while($row_varsel = mysqli_fetch_assoc($result_varsel)) {

                        $date = $row_varsel['date'];
                        $text = $row_varsel['text'];
                        $new  = $row_varsel['new'];

                ?>
                <tr style="height: 30px;">
                    <td style="padding: 3px; padding-left: 10px; color:#009fe3;"><?php if($new == 0) { ?> NY! <?php } else { echo '-'; } ?></td>
                    <td><?php echo $text ?></td>
                    <td>
                    <?php 
                    
                    $date_ = date('Y-m-d', $date);
                    $today = date('Y-m-d');
                    $yesterday = date('Y-m-d', strtotime('yesterday')); 

                    if ($date_ == $today) {
                        echo "I dag kl "; echo date('H:i', $date);
                    } elseif ($date_ == $yesterday) {
                        echo "I går";
                        echo " kl "; echo date('H:i', $date);
                    } else {
                        echo " "; echo date('d', $date);
                        echo ". "; echo $month_short[date('n', $date)];
                        echo ". kl "; echo date('H:i', $date);
                    }

                    ?></td>
                </tr>
                <?php }  ?>
            </table>
        </div>
        <?php if($total_pages <= 1) { } else { ?>
<div style="margin-top: 4px" class="content">
    <div class="pad_5 pagination">
        <div style="width: 20%; float: left;">
            <span><a href="index.php?side=varsel&pageno=1">«« Første side</a></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "index.php?side=varsel&pageno=".($pageno - 1); } ?>">« Forrige side</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span style="text-align: center;">Side <?php echo $pageno ?></span>
        </div>
        <div style="width: 20%; float: left;">
        <span class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a style="float: right;" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "index.php?side=varsel&pageno=".($pageno + 1); } ?>">Neste side »</a>
        </span>
        </div>
        <div style="width: 20%; float: left;">
        <span><a style="float: right;" href="index.php?side=varsel&pageno=<?php echo $total_pages; ?>">Siste side »»</a></span>
        </div>
    </div>
</div>
        <?php } ?>
        
    </body>
</html>

<?php
    $sql = "UPDATE varsel SET new = '1' WHERE acc_id='".$_SESSION['ID']."' AND new = '0'";
    mysqli_query($con, $sql);
?>
<?php } ?>
