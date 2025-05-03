
<?php 

if(!isset($_GET['side'])){ 
    header("Location: index.php");
} elseif(!isset($_GET['company'])){
    header("Location: index.php?side=aksjemarked&home");
} else { 
    
$stock_name[0] = "Mafioso Eiendom C";
$stock_name[1] = "Den Sveitsiske bank";
$stock_name[2] = "Det Norske Dampskibselskap";
$stock_name[3] = "Sansung";
$stock_name[4] = "Eple";
$stock_name[5] = "Potet Solutions Inc.";
$stock_name[6] = "Fart & Bart AS";

$company = $_GET['company'];
?>

<!-- CONTENT -->
<html>
    <head>
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Tid', 'Verdi'],
                    
                    <?php 

                $result = mysqli_query($con, "SELECT * FROM stocks WHERE stock_id = '".$company."' ORDER BY date DESC LIMIT 30");
                while($row_stock = mysqli_fetch_assoc($result)) {
    
                    ?>
                        [
                            <?php echo $row_stock['date']; ?>
                            , 
                         
                         <?php echo $row_stock['price']; ?>],
                    <?php } ?>
                    
                    
                ]);

                var options = {
                    title: '<?php echo $stock_name[$company]; ?>',
                    hAxis: {
                        title: 'Tid',
                        titleTextStyle: {
                            color: '#333'
                        }
                    },
                    vAxis: {
                        minValue: 0
                    },
                    
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div class="breadcrumb">
            <span style="color: #3e3e3e;">Diverse » Aksjemarked » </span><span style="color: #afafaf;"><?php echo $stock_name[$company] ?></span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
            <div class="pad_10"><a style="color: white;" href="index.php?side=aksjemarked&home">Tilbake til aksjemarked</a></div>
            <div id="chart_div" style="width: 100%; height: 300px;"></div>

        </div>
    </body>
</html>
<?php 

}

?>