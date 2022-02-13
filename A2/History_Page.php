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

		$wrong = 0;
		$correct = 0;
		$counter = 1;
		$showpoints = 0;
		$_SESSION["historyscore"] = 0;

		if (isset($_POST['submit'])) {

			for ($i = 0; $i < 3; $i++) {
				$keyI = $RandomKey[$i];
				echo $_POST["ans[$keyI]"];
				if (isset($_POST["ans[$keyI]"])) {
					//echo $AnswerCheck;
					for ($j = 1; $j < 7; $j++) {
						if (strcasecmp($HistoryQuestions[$RandomKey[$j]]["Ans"], $_POST["ans[$keyI]"]) == 0) {
							echo "<label>Correct!is " . $HistoryQuestions[$RandomKey[$j]] . ".</label><br /><br />\n";
							$correct++;
						} else {
							echo "<label>Sorry, Incorrect Answer.</label><br /><br />\n";
							//echo $Response;
							$wrong++;
						}
					}
				} else {
					echo "<label>You did not attempt.</label><br /><br />\n";
				}
			}

			//points for current attempt
			$showpoints = calculatepoints($correct, $wrong);
			if ($showpoints > 0) {
				if (empty($_SESSION["historyscore"])) {
					$_SESSION["historycore"] = $showpoints;
				} elseif ($showpoints > $_SESSION["historyscore"]) {
					$_SESSION["historycore"] = $showpoints;
				}
			}
			echo "<h1>You scored $showpoints/6</h1>";
			echo "<button style='display:block;  margin-left:auto; margin-right:auto; background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; font-size: 16px;'><a  href='Subject_Page.php'>Select Another Quiz</a></button>&nbsp;";
			echo "<button style='display:block; margin-left:auto; margin-right:auto; background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; font-size: 16px;'><a  href='Maths_Page.php'>Re-attempt Quiz</a></button>";
		} else {
			echo "<label>Please select the correct answer </label><br/>";

			echo "<form action='History_Page.php' method='POST' autocomplete='off'>\n";
			$counter = 1;
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
		}

		echo "<input type='submit' name='submit' value='Submit Answers' style='background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; display:block; font-size: 16px;' />&nbsp";
		echo "<input type='reset' name='reset' value='Clear' style='background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; display:block; font-size: 16px;' />\n";
		echo "</form>\n";

		?>
	</div>
	<button style="background-color: #329EAA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display:block; font-size: 16px; margin-left:auto; margin-right: auto;"><a href="Subject_Page.php">Back</a></button>
</body>

</html>