<?php 

// Logg template
$query = "INSERT into `logg` (acc_id, action, text, money, bank_money, date)
VALUES ('$ID', '5', 'Stjel bil velykket, bil_id = ".$car_car_id."', '$money', '$bank_money', '".time()."')";
$result = mysqli_query($con, $query);

?>

<!-- FEEDBACKS -->
<div class="feedback velykket">
    <span><b>Vellykket!</b> Dette er en velykket feedback!</span> 
</div>

<div class="feedback mislykket">
    <span><b>Mislykket!</b> Dette er en mislykket feedback!</span> 
</div>

<div class="feedback feilmelding">
    <span><b>Feilmelding!</b> Dette er en feilmelding!</span> 
</div>

<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif($bunker_status == 1){
    echo '<div class="feedback velykket">
        <span>Du er i bunker og kan ikke gjøre denne aktiviteten.</span> 
    </div>';
} else { 
    
?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Hvor » </span><span style="color: #afafaf;">Hvor</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
        </div>
    </body>
</html>
<?php 

}

?>