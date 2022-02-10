<!DOCTYPE html>
<html>
<head>
	<title>Take A Challenge</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Take A Challenge - Sports</h1>
<div class="form-style">
<div class="block">
<button onclick="window.location.href = 'category.php';" style="display: block;">Back</button>
<?php 
session_start();

$SportQuestions = array(
					"Hurling uses a ball called a sliothar" => "T",
					"There are 30 balls in the game of snooker" => "F",
					"An Olympic slalom course must have a vertical drop of less than 200 feet" => "F",
					"There has never been a woman chess master" => "F",
					"Pétanque is played with balls" => "T",
					"Polo is not an Olympic sport" => "T",
					"The game mah-jongg takes its name from a mythical bird" => "T",
					"Monica Seles, the tennis player, never earned a prize title" => "F",
					"In the Tour de France, the winner wears a yellow jersey" => "T",
					"A dartboard is divided into 20 numbered sections" => "T",
					"Boxing has 3 rounds" => "F",
					"There are five colours in the Olympic Ring" => "T",
					"There are ten players in a rugby team" => "F",
					"Argentina won the 2019 FIFA World Cup" => "F",
					"Usain bolt holds the world record for the 100m sprint" => "T",
					"There are 10 players in a baseball team" => "F",
					"China won 100 medals in the 2008 Beijing Olympics" => "T",
					"Kyrie Irving was born in France" => "F",
					"The first FIFA World Cup was won by Uruguay" => "T",
					"Hans-Gunnar Liljenwall was the first ever athlete to fail a drug test for the Olympics" => "T"
					
					);

$RandomQuestions = array_rand($SportQuestions,7);

function calculatepoints($correct,$wrong) {
	$total = ($correct * 3)-($wrong * 2);
	return $total;
}

$wrong = 0;
$correct = 0;
$counter = 1;
$displaypoints = 0;
if (isset($_POST['submit'])) {
	$Answers = $_POST['ans'];
	if (is_array($Answers)) {
		foreach ($Answers as $Questions => $Response) {
			$Response = stripslashes($Response);
			if (strlen($Response)>0) {
				if (strcasecmp($SportQuestions["$Questions"],$Response)==0) {
					echo "<label>Correct! $Questions is " . $SportQuestions[$Questions] . ".</label><br /><br />\n";
					$correct++;
				}
					
				else {
					echo "<label>Sorry, Incorrect Answer.</label><br /><br />\n";
					$wrong++;
				}
					
			}
			else {
				echo "<label>You did not attempt $Questions.</label><br /><br />\n";
			} 
				
		}
	}
	$displaypoints = calculatepoints($correct,$wrong);
	if ($displaypoints > 0) {
		
		if (empty($_SESSION["sportscore"])) {
			$_SESSION["sportscore"] = $displaypoints;
		}

		elseif ($displaypoints > $_SESSION["sportscore"]) {
			$_SESSION["sportscore"] = $displaypoints;
		}
	} 

	echo "<h1 class=naming>You scored $displaypoints/21</h1>";
	echo "<button onclick=\"window.location.href = 'category.php';\" >Select Other Quiz</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'sports.php';\" >Re-attempt Quiz</button>";
}

else {
	

	if(!empty($_SESSION["sportscore"])){
		echo "<label class='naming'>Highest attempt: ";
		echo $_SESSION["sportscore"];
		echo "/21</label>";

	}
	
	echo "<label class='naming'>Answer either T / F in the text field </label><br/>";

	echo "<form action='sports.php' method='POST' autocomplete='off'>\n";
	
	for ($i=0; $i < 7 ; $i++) { 
		echo "<label class='question-text'>$counter. ";
		echo "$RandomQuestions[$i].</label>";
		echo "<input type='text' class='input-field-quiz' name='ans[$RandomQuestions[$i]]' /><br/><br />";
		$counter++;
	}
	
	echo "<input type='submit' name='submit' value='Submit Answers' /> ";
	echo "<input type='reset' name='reset' value='Clear' />\n";
	echo "</form>\n";
	
}
?>

</div>
</div>
</body>
</html>
