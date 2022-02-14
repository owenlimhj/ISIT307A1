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
		$_SESSION['currentScore'] = 0;
		$HistoryQuestions = array(
			1 => array("Qns" => "Whose death sparked World War I", "Ans" => "Archduke Franz Ferdinand"),
			2 => array("Qns" => "In which city would you find the Statue of Liberty", "Ans" => "New York City"),
			3 => array("Qns" => "Which one of the seven wonders of ancient world was situated in Egypt", "Ans" => "Pyramid"),
			4 => array("Qns" => "Which of these nations was neutral in World War I", "Ans" => "Norway"),
			5 => array("Qns" => "World War I ended in", "Ans" => "1918"),
			6 => array("Qns" => "Who was the first U.S. president to appear on television?", "Ans" => "Franklin Delano Roosevelt")
		);
		$HistoryChoices = array(
			1 => array("Kaiser Wilhelm", "Queen Victoria", "Archduke Franz Ferdinand"),
			2 => array("San Francisco", "New York City", "Philadelphia"),
			3 => array("Petra", "Colosseum", "Pyramid"),
			4 => array("Germany", "Norway", "England"),
			5 => array("1925", "1918", "1920"),
			6 => array("Richard Nixon", "Abraham Lincoln", "Franklin Delano Roosevelt")
		);

		$RandomKey = array_rand($HistoryQuestions, 3);
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

		<form id='History_Page' method='POST'>
			<?php

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (isset($_POST['submit'])) {
					$Answer = $_POST['ans'];
					foreach ($Answer as $Questions => $Response) {
						$Response = stripslashes($Response);

						if (strcasecmp($HistoryQuestions[$Questions]["Ans"], $Response) == 0) {
							$correct++;
							$wrong--;
						}
					}

					//points for current attempt
					$showpoints = calculatepoints($correct, $wrong);
					$_SESSION['currentScore'] = $showpoints;
					$_SESSION['Correct'] = $correct;
					$_SESSION['Wrong'] = $wrong;
					$_SESSION['HisAttempt'] += 1;
					$_SESSION['Attempted'] = "History";
					$_SESSION['OverallScore'] += $showpoints;
					header("Location: Result_Page.php");
				}
				if (isset($_POST['back'])) {
					header("Location: Subject_Page.php");
				}
			}
			?>
			<label>Please select the correct answer</label><br>

			<?php

			for ($i = 0; $i < 3; $i++) {
				echo "<label class='question-text'>$counter. ";
				$key = $RandomKey[$i];

				echo $HistoryQuestions[$key]["Qns"], "<br><br>";
				$counter++;
				for ($j = 0; $j < 3; $j++) {
					$answer = $HistoryChoices[$key][$j];
					echo "<input type='radio' name='ans[$key]' value='$answer'/>";
					echo $HistoryChoices[$key][$j],  "<br>";
				}

				echo "<br>";
			}
			?>
			<button type="submit" name="submit" value="Submit">Submit</button><br><br>
			<button type="reset" value="Reset">Clear</button>
			<button class="back" name="back">Back</button>
		</form>



	</div>

</body>


</html>