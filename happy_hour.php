<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} else { 
    if($account_type > 0){
        
    $seconds[0] = 3600;          // 1 time
    $seconds[1] = 7200;          // 2 timer
    $seconds[2] = 21600;         // 6 timer
    $seconds[3] = 43200;         // 12 timer
    $seconds[4] = 86400;         // 24 timer
    $seconds[5] = 30;            // 30 sekunder (for testing)
    $seconds[6] = 259200;        // 72 timer

    if(isset($_POST['submit'])){

        $query = "INSERT into `happy_hour` (happy_hour, start, end)
        VALUES ('1', '".time()."', '".(time() + $seconds[$_POST['happy_hour']])."')";
        $result = mysqli_query($con, $query);
        
//=======================================================================================================
// Create new webhook in your Discord channel settings and copy&paste URL
//=======================================================================================================

$webhookurl = "https://discordapp.com/api/webhooks/671309734434832384/3oE0PofgvgsmfXYCSZBSakOk4AJEh6-baEoKTu3xTIi_r98UnU7YY_czaX3qAuju9MWy";

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================
        
$date = date('d.n.H:i', time() + $seconds[$_POST['happy_hour']]);

$msg = "Happy hour er live til ".$date."";

$json_data = array ('content'=>"$msg");
$make_json = json_encode($json_data);

$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
//If you need to debug, or find out why you can't send message uncomment line below, and execute script.
//echo $response;
        

        
        header("Location: index.php");

    }

?>
<!-- CONTENT -->
<html>
    <head></head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Admin » </span><span style="color: #afafaf;">Happy hour</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <?php 

if($happy_hour == 1){
    echo '<div class="feedback feilmelding">
            <span>Det er allerede en aktiv happy hour!<br>Denne vil gå ut ';
        echo $days[date('N', $end)]; 
        echo " "; echo date('d', $end);
        echo ". "; echo $month[date('n', $end)];
        echo " - kl "; echo date('H:i', $end);
    echo  '</span> 
        </div>';
    
} else {
?>
        <div class="content">
            <p class="pad_5">Hvor lenge skal happy hour vare?</p>
            <form method="post" action="">
              <select style="width: auto; margin-left: 7px;" name="happy_hour">
                <option value="0">1 time</option>
                <option value="1">2 timer</option>
                <option value="2">6 timer</option>
                <option value="3">12 timer</option>
                <option value="4">24 timer</option>
                <option value="5">30 sec (for testing)</option>
                <option value="6">72 timer</option>


              </select>
              <input style="width: auto;" type="submit" name="submit" value="start happy hour!">
            </form>
            
        </div>
    </body>
</html>
<?php 
    }
    } else {
        header("Location: index.php");
    }
}

?>