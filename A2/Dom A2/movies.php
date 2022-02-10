<!DOCTYPE html>
<html>
<head>
	<title>Take A Challenge</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Take A Challenge - Movies</h1>
<div class="block">
<div class="form-style">
<button onclick="window.location.href = 'category.php';" style="display: block;">Back</button>
<?php 
session_start();

$MovieQuestions = array(
						"The nickname of Morgan Freemans character in Million Dollar Baby is Red" => "F",
						"Elizabeth Taylor married the same man twice" => "T",
						"Gone With The Wind was the first movie to win the Oscar for best picture" => "F",
						"Lala land was filmed entirely in Vancouver" => "F",
						"Cool Runnings is based on a true story" => "T",
						"Unadjusted for inflation, Avatar is the highest grossing movie of all time" => "T",
						"The Lion featured in MGM production logo is the same Lion that appears in the Wizard Of Oz" => "F",
						"Sophies Choice was Meryl Streeps first ever movie role" => "F",
						"Superman made his first movie appearance in the 1940s" => "T",
						"During its original release, the movie ET had a run time of over four hours" => "F",
						"Mary Poppins features the first use of a swear word in a Hollywood movie" => "F",
						"Tom Hanks speaks less than 200 words in Toy Story 2" => "F",
						"There have been over 10 movies released in the Friday The 13th franchise" => "T",
						"Snow White and the 7 dwarfs was the first full length animated movie released by Disney" => "T",
						"The Sandlot was released in 1993" => "T",
						"Moonlight won Best Picture in 2018" => "F",
						"Molly Ringwald made four movies with director John Hughes" => "F",
						"Julia Roberts was married to Kiefer Sutherland" => "F",
						"Val Kilmer was offered the role of Johnny in the movie Dirty Dancing" => "T",
						"Meg Ryan played Tom Cruises love interest in the movie Top Gun" => "F"
					);

$RandomQuestions = array_rand($MovieQuestions,7);

function calculatepoints($correct,$wrong) {
	$total = ($correct * 3)-($wrong * 2);
	return $total;
}

$wrong = 0;
$correct = 0;
$counter = 1;
$showpoints = 0;
if (isset($_POST['submit'])) {
	$Answers = $_POST['ans'];
	if (is_array($Answers)) {
		foreach ($Answers as $Questions => $Response) {
			$Response = stripslashes($Response);
			if (strlen($Response)>0) {
				if (strcasecmp($MovieQuestions["$Questions"],$Response)==0) {
					echo "<label>Correct! $Questions is " . $MovieQuestions[$Questions] . ".</label><br /><br />\n";
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
	
$showpoints = calculatepoints($correct,$wrong);
	if ($showpoints > 0) {
		if (empty($_SESSION["moviescore"])) {
			$_SESSION["moviescore"] = $showpoints;
		}

		elseif ($showpoints > $_SESSION["moviescore"]) {
			$_SESSION["moviescore"] = $showpoints;
		}
	} 

	echo "<h1 class=naming>You scored $showpoints/21</h1>";
	echo "<button onclick=\"window.location.href = 'category.php';\" >Select Other Quiz</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'movies.php';\" >Re-attempt Quiz</button>";
}

else {

	if(!empty($_SESSION["moviescore"])){
		echo "<label class='naming'>Highest attempt: ";
		echo $_SESSION["moviescore"];
		echo "/21</label>";

	}
	
	echo "<label class='naming'>Answer either T / F in the text field </label><br/>";

	echo "<form action='movies.php' method='POST' autocomplete='off'>\n";
	
	for ($i=0; $i < 7 ; $i++) { 
		echo "<label class='question-text'>$counter. ";
		echo "$RandomQuestions[$i].</label>";
		echo "<input type='text' class='input-field-quiz' name='ans[$RandomQuestions[$i]]' /><br /><br />";
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
