<!DOCTYPE html>
<html>
<head>
	<title>Final Tests</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Final Tests</h1>
<div class="small-container">
<?php 
session_start();
    $num = $_SESSION["StudentNum"];
	echo "<h1>" . "Hello student&nbsp;". $num . "</h1>";

?>
    <h2>Choose your test subject</h2><br>
    <button class="subjectbtn" onclick="window.location.href = 'History_Page.php';" >History</button><br><br>
    <button class="subjectbtn" onclick="window.location.href = 'Maths_Page.php';" >Mathematics</button><br><br>
    <button class="exit" onclick="window.location.href = 'Exit_Page.php';">Exit</button>
</div>
</body>
</html>