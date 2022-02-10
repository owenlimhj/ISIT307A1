<!DOCTYPE html>
<html>
<head>
	<title>Take A Challenge</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Take A Challenge</h1>
<div class="block">
<div class="form-style" style="text-align: center;">
<?php 
session_start();

if(isset($_SESSION["name"])) {

	echo "<h1 class='naming'>" . "Goodbye,&nbsp;" . $_SESSION["name"] . "</h1>";

	if (!empty($_SESSION["moviescore"])) {
		echo "<h4 class='naming'>Movie Score:  " . $_SESSION["moviescore"] . "</h4>";
	} 
	else {
		$_SESSION["moviescore"] = 0;
		echo "<h4 class='naming'>Movie Score:  " . $_SESSION["moviescore"] . "</h4>";
	}

	if (!empty($_SESSION["musicscore"])) {
		echo "<h4 class='naming'>Music Score:  " . $_SESSION["musicscore"] . "</h4>";
	}
	else {
		$_SESSION["musicscore"] = 0;
		echo "<h4 class='naming'>Music Score:  " . $_SESSION["musicscore"] . "</h4>";
	}

	if (!empty($_SESSION["sportscore"])) {
		echo "<h4 class='naming'>Sport Score:  " . $_SESSION["sportscore"] . "</h4>";
	}
	else {
		$_SESSION["sportscore"] = 0;
		echo "<h4 class='naming'>Sport Score:  " . $_SESSION["sportscore"] . "</h4>";
	}

	if ($_SESSION["sportscore"] >= 0 && $_SESSION["sportscore"] >= 0 && $_SESSION["sportscore"] >= 0) {
		$totalscore = $_SESSION["moviescore"] + $_SESSION["musicscore"] + $_SESSION["sportscore"];
		echo "<br>";
		echo "<h2 class='naming'>Total Score: " . $totalscore . "/63</h2>";
	}
	
}

session_destroy();

?>

<button onclick="window.location.href = 'homepage.html';" style="display: block;">Back to Main Menu</button>
</div>
</div>
</body>
</html>
