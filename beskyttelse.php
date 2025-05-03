
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
            <span style="color: #3e3e3e;">Drap » </span><span style="color: #afafaf;">beskyttelse</span>
            <span style="color: #3e3e3e; float: right;"><span id="date"></span> - <span id="clock"></span></span>
        </div>
        <div class="content">
        </div>
    </body>
</html>
<?php 

}

?>