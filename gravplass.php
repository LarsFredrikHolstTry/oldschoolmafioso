

            
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
            <span style="color: #3e3e3e;">Mafioso » </span><span style="color: #afafaf;">Gravplass</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div style=" border-bottom: 0;"  class="header">
                <span>✝ Gravplass ✝</span>
            </div>
            <div style="height: auto; width: 100%;">
            <div style="width: 50%; float: left;">
            <div style="border-top: 1px solid #2c2c2c;" class="header">
                <span>Topp 10 beste spillere</span>
            </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <?php 
                    
                    $i = 0;
                    $result = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 69 ORDER BY EXP DESC LIMIT 10");
                    while($row_best = mysqli_fetch_assoc($result)) {
            
                        $usrnm = $row_best['ID'];
                        $i++;
                    ?>
                    <tr style="height: 25px;">
                        <td 
                            <?php if($i == 1){ ?>
                            style="color: gold; padding-left: 10px;" 
                            <?php } elseif($i == 2){ ?>
                            style="color: silver; padding-left: 10px;" 
                            <?php } elseif($i == 3){ ?>
                            style="color: #cd7f32 ; padding-left: 10px;" 
                            <?php }else { ?>
                            style="color: #555555 ; padding-left: 10px;" 
                            <?php } ?>
                            ><?php echo $i; ?>. plass</td>
                        <td><?php echo fetch_nick($usrnm, $con); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div style="width: 50%; float: right; box-shadow: -1px 0px 0px 0px #2c2c2c, 1px 0px 0px 0px #2c2c2c;">
            <div style="border-top: 1px solid #2c2c2c;"  class="header">
                <span>Topp 10 rikeste spillere</span>
            </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <?php 
                    
                    $i = 0;
                    $result = mysqli_query($con, "SELECT * FROM accounts WHERE account_type = 69 ORDER BY (money + bank_money) DESC LIMIT 10");
                    while($row_best = mysqli_fetch_assoc($result)) {
            
                        $usrnm = $row_best['ID'];
                        $i++;
                    ?>
                    <tr style="height: 25px;">
                        <td
                            <?php if($i == 1){ ?>
                            style="color: gold; padding-left: 10px;" 
                            <?php } elseif($i == 2){ ?>
                            style="color: silver; padding-left: 10px;" 
                            <?php } elseif($i == 3){ ?>
                            style="color: #cd7f32 ; padding-left: 10px;" 
                            <?php }else { ?>
                            style="color: #555555 ; padding-left: 10px;" 
                            <?php } ?>><?php echo $i; ?>. plass</td>
                        <td><?php echo fetch_nick($usrnm, $con); ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            </div>
        </div>
    </body>
</html>
<?php 

}

?>