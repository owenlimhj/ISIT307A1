<head>
	<title>My Music Gear</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<h1 class="head">Welcome to My Music Gear!</h1>
	<div class="nav">
		<a href="Homepage.html">Home</a>
		<a href="AllListings.php">View All Listed Gears</a>
		<a href="ListGear.php">List A Gear</a>
	</div>
	<h1 class="header">All Listed Gears</h1>
	
	<div class="container">
	<?php

	$listheader= array("Seller Name", "Phone Number", "Email", "ID No", "Model","Year of Manufacture","Characteristics","Condition");
	$row = 0;
	if (($text = fopen("GearDirectory.txt", "r")) !== false) {
		// d = data
		while (($d = fgetcsv($text, 1000, ",")) !==false) {
			$num = count($d);
			// see what the system has read
			for ($c=0; $c < $num; $c++) {
				echo "<label>" . "<span class='container'>" .  $listheader[$c] . ": " . "</span>" . "<span>" . $d[$c] . "</span>" . "</label>" . "<br>";
			}
			echo "<br>";
			$row++;

		}
		fclose($text);

	}
	else {
		echo "No such file." . "<br>";
	}
	?>
	</div>
	
	<button onclick="topFunction()" id="toTopButton">Back to Top</button>
	<script>
		var mybutton = document.getElementById("toTopButton");
		window.onscroll = function() {scrollFunction()};
		function scrollFunction() {
		  if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
			mybutton.style.display = "block";
		  } else {
			mybutton.style.display = "none";
		  }
		}
		
		function topFunction() {
		  document.body.scrollTop = 0;
		  document.documentElement.scrollTop = 0;
		}
</script>
</body>
</html>
