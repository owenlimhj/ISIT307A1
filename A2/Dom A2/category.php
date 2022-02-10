<!DOCTYPE html>
<html>
<head>
	<title>Take A Challenge</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Take A Challenge</h1>
<?php 
session_start();
if (isset($_POST["name"])) { 
	$name = $_POST["name"];
	$_SESSION["name"] = $_POST["name"];
	echo "<h1 class='block' style='text-align:center; font-size:30px;'>" . "Hello,&nbsp;". $_SESSION["name"] . "</h1>";
 } 
?>
<div class="block">
<div class="form-style" style="text-align: center;">
<button onclick="window.location.href = 'exit.php';" style="display: block;">Exit</button>
<h3 class="naming" style="font-size: 30px;">Choose your Category</h3><br>
<button class="category" onclick="window.location.href = 'movies.php';" >Movies</button>
<button class="category" onclick="window.location.href = 'music.php';" >Music</button>
<button class="category" onclick="window.location.href = 'sports.php';" >Sport</button>
</div>
</div>

</body>
</html>
