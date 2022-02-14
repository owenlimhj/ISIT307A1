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
		$_SESSION["currentscore"] = 0;
		$MathQuestions = array(
			"1+1" => "2",
			"2*2" => "4",
			"6/6" => "1",
			"7-2" => "5",
			"2+1" => "3",
			"12/2" => "6",
		);

		$RandomQuestions = array_rand($MathQuestions, 3);

		function calculatepoints($correct, $wrong)
		{
			$total = ($correct * 2) - ($wrong * 1);
			return $total;
		}

		$wrong = 3;
		$correct = 0;
		$counter = 1;
		$showpoints = 0;

		?>

		<form id='Maths_Page' method='POST'>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if(isset($_POST['submit'])){
				$Answer = $_POST['ans'];

				foreach ($Answer as $Questions => $Response) {
					$Response = stripslashes($Response);
					//check length of response string
					if (strcasecmp($MathQuestions["$Questions"], $Response) == 0) {
						$correct++;
						$wrong--;
					}
				}
				//points for current attempt
				$showpoints = calculatepoints($correct, $wrong);
				$_SESSION["currentScore"] = $showpoints;
				$_SESSION['Correct'] = $correct;
				$_SESSION['Wrong'] = $wrong;
				$_SESSION['MathAttempt'] += 1;
				$_SESSION['Attempted'] = "Math";
				$_SESSION['TotalCorrect'] += $correct;
				$_SESSION['TotalWrong'] += $wrong;
				$_SESSION['OverallScore'] += $showpoints;
				header("Location: Result_Page.php");
			}
			if(isset($_POST['back'])){
				header("Location: Subject_Page.php");
			}
		}
		
			?>
			<label>Enter your answer in the text field </label><br />
			<?php
			for ($i = 0; $i < 3; $i++) {
				echo "<label class='question-text'>$counter. ";
				echo "$RandomQuestions[$i].</label>";
				echo "<input type='text' class='input-field-quiz' name='ans[$RandomQuestions[$i]]' /><br /><br />";
				$counter++;
			}
			?>
			<button type="submit" name = "submit" value="Submit">Submit</button><br><br>
			<button type="reset" value="Reset">Clear</button>
			<button class = "back" name = "back">Back</button>
		</form>

	</div>
</body>

</html>