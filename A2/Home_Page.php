<!DOCTYPE html>
<html>

<head>
	<title>ISIT307 Assignment 2</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>

<body>
	<div class="small-container">
		<h1 class="text-center">Welcome to Final Tests</h1>
		<h2>Rules</h2>
		<label>1. Select a subject and attempt 3 questions!</label><br><br>
		<label>2. Each correct answer will award you with 2 points while each wrong answer will deduct 1 point</label><br><br>
		<label>3. At the end of the challenge, your total score for your current attempt and overall attempt will be shown!</label><br><br>
		<form id="Home_Page" method="post">

			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (empty($_POST['StudentNum'])) {
					$error = "Student number cannot be blank";
					echo "<h4 style='color:red;'>$error</h4>";
				} else {
					session_start();
					$_SESSION['OverallScore'] = 0;
					$_SESSION['StudentNum'] = $_POST['StudentNum'];
					$_SESSION['HisAttempt'] = 0;
					$_SESSION['MathAttempt'] = 0;
					$_SESSION['TotalWrong'] = 0;
					$_SESSION['TotalCorrect'] = 0;
					$_SESSION['Attempted'] = "";
					header("Location: Subject_Page.php");
				}
			}

			?>
			<label style="font-weight: bold;">
				Student Number:
				<input type="text" name="StudentNum" class="input-field" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off"/>
				<button class="smallbluebtn" type="submit">Start</button>
			</label>
		</form>
	</div>
</body>

</html>