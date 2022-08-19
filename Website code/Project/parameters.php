<?php
session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location: userlogin.php");
  exit;
}

$device_no = $_SESSION['device_no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- If you are opening this page from local machine, uncomment belwo line -->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->

    <!-- If you are opening this page from a web hosting server machine, uncomment belwo line -->
	
	 <script type="text/javascript">
		document.write([
			"\<script src='",
			("https:" == document.location.protocol) ? "https://" : "http://",
			"ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js' type='text/javascript'>\<\/script>" 
		].join(''));
	  </script>
	 

    <title>Parameters</title>

    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/parameters.css">

    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
        rel="stylesheet">

</head>
<body>
    
    <?php require 'partials/_navbar.php' ?> 

    <div id="background">
        
            <h1 class="h-secondary centre">You are now observing the device no. <?php echo $device_no; ?> </h1>
            <p id="datetime" class="p centre"></p>
            <p id="temperature" class="p centre"></p>
            <p id="humidity" class="p centre"></p>
            <p id="soil moisture" class="p centre"></p>
            <h1 class="h-secondary centre">Control your water pump using below buttons.</h1>
            <form class="centre" action="/project/parameters.php" method="get">
                  <button type="button" id="on" class="button on">ON</button>
                  <button type="button" id="off" class="button off">OFF</button>
            </form>
    </div>
    
 </body>

    <script>
        window.onload = function () {
            loaddata();
        };
        function loaddata() {
            var url = "partials/read.php";
            $.getJSON(url, function (data) {
                var val = data;
                var dt = (data['parameters'][(Object.keys(data['parameters']).length) - 1]['datetime']);
                var humid = (data['parameters'][(Object.keys(data['parameters']).length) - 1]['hum']);
                var temper = (data['parameters'][(Object.keys(data['parameters']).length) - 1]['temp']);
                var moisture = (data['parameters'][(Object.keys(data['parameters']).length) - 1]['moisture']);
                document.getElementById("datetime").innerHTML = "Date/Time = " + dt;
                document.getElementById("temperature").innerHTML = "Temperature = " + temper + " degree celsius";
                document.getElementById("humidity").innerHTML = "Humidity = " + humid + " percentage";
                document.getElementById("soil moisture").innerHTML = "Soil Moisture = " + moisture + " percentage";
                // console.log(data['parameters'][(Object.keys(data['parameters']).length)-1]['temp']);
            });
        }
        document.getElementById('on').addEventListener('click', function() {
				var url = "partials/update.php?device_no=<?php echo $device_no;?>&pump=on";
				$.getJSON(url, function(data) {
					// console.log(data);
				});
		});
		
		document.getElementById('off').addEventListener('click', function() {
				var url = "partials/update.php?device_no=<?php echo $device_no;?>&pump=off";
				$.getJSON(url, function(data) {
					// console.log(data);
				});
		});
        window.setInterval(function () {
            loaddata();
        }, 3000);

    </script>

</html>