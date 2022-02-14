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

$currentScore = $_SESSION['currentScore'];
$correct = $_SESSION['Correct'];
$wrong = $_SESSION['Wrong'];	
$overallScore = $_SESSION['OverallScore'];
$attempt = $_SESSION['Attempted'];
$_SESSION['OverallScore'] = $overallScore;
echo "<h1>Test Results</h1>";
echo "<h3>You just attempted a $attempt test</h3>";
echo "<h3>You got $correct correct</h3>";
echo "<h3>You got $wrong wrong</h3>";
echo "<h2>Your Current Score is:$currentScore/6</h2>";
echo "<h1>Your Overall Score is:$overallScore</h1>";
?>
		<button class="subjectbtn" onclick="window.location.href = 'Subject_Page.php';" >Select Another Test</button><br><br>
		<button class="exit" onclick="window.location.href = 'Exit_Page.php';" style="display: block;">Exit</button><br><br>
</div>

</body>
</html>