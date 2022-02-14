<!DOCTYPE html>
<html>

<head>
	<title>ISIT307 Assignment 2</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
	<div class="small-container">

		<h1 class="text-center">Congratulation!</h1>
		<form id="Exit_Page" method="post">
			<?php
			session_start();
			$studNum = $_SESSION['StudentNum'];
			$overallScore = $_SESSION['OverallScore'];
			$hAtt = $_SESSION['HisAttempt'];
			$mAtt = $_SESSION['MathAttempt'];
			$totalCorrect = $_SESSION['TotalCorrect'];
			$totalWrong = $_SESSION['TotalWrong'];
			$_SESSION['OverallScore'] = $overallScore;
			$totalAttempt = $hAtt + $mAtt;
			$totalScore = $totalAttempt * 6;
			echo "<h2>Student Num: $studNum</h2>";
			echo "<h3>You attempted $hAtt History Tests</h3>";
			echo "<h3>You attempted $mAtt Math Tests</h3>";
			echo "<h3>You attempted a total of $totalAttempt Tests</h3>";
			echo "<h3>You have total of $totalCorrect correct answers</h3>";
			echo "<h3>You have total of $totalWrong wrong answers</h3>";
			echo "<h1>Your overall score is $overallScore/$totalScore</h1>";
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				session_unset();
				header("Location: Home_Page.php");
			}

			?>

			<button type="submit" value="Submit" style="display:block; margin-left:auto; margin-right: auto;">Restart</button>
		</form>
	</div>
</body>

</html>