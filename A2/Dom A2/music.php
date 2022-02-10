<!DOCTYPE html>
<html>
<head>
	<title>Take A Challenge</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<h1 class="header">Take A Challenge - Music</h1>

<div class="block">
<div class="form-style">
<button onclick="window.location.href = 'category.php';" style="display: block;">Back</button>
<?php 
session_start();

$MusicQuestions = array(
					"Shania Twain is a distant relative of Huckleberry Finn author Mark Twain" => "T",
					"Radiohead Thom Yorke real name is not Thom, or even Thomas, it is John" => "F",
					"The only member of ZZ Top without a beard is called Frank Beard" => "F",
					"Robbie Williams was just 14 years old when he joined Take That" => "F",
					"The Bee Gees took their name from an Irish family friend who often said Bejesus when they were growing up" => "T",
					"The first-ever music video played on MTV was Video Killed the Radio Star" => "T",
					"Actor Billy Crystals babysitter when he was a kid was jazz great Billie Holiday" => "T",
					"John Lennon once owned an island in Clew Bay, off the coast of Co Mayo" => "F",
					"Elton John refuses to wear a backstage pass at his gigs, because he thinks people should already know who he is" => "T",
					"Taylor Swifts first job was on a Christmas Tree farm" => "T",
					"Elvis Presley got the idea for his iconic white jumpsuit after seeing footage of our own Joe Dolan wearing something similar" => "F",
					"Noel Gallaghers job was as a roadie for The Inspiral Carpets before he joined his brother Liams band" => "T",
					"Justin Bieber has a fear of oranges and specifies that each venue he plays must be cleared of them before he enters the building" => "F",
					"Only half of U2s members were actually born in Ireland" => "F",
					"Don McLean wrote American Pie because that was the name of the plane which crashed and killed Buddy Holly, Ritchie Valens and The Big Bopper" => "T",
					"Rapper Vanilla Ices real name is Robert Van Winkle" => "F",
					"Madonna is afraid of thunder" => "T",
					"Rapper Drake was born in prison while his mother was serving a sentence for shoplifting lipsticks" => "F",
					"Chris de Burghs Lady in Red was originally called Lady in Black, but he changed it after his wife said that she didnT like the colour red" => "T",
					"Lady Gaga named her new album Joanne after her late aunt, who died at the age of 19" => "T"
					
					);

$RandomQuestions = array_rand($MusicQuestions,7);

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
				if (strcasecmp($MusicQuestions["$Questions"],$Response)==0) {
					echo "<label>Correct! $Questions is " . $MusicQuestions[$Questions] . ".</label><br /><br />\n";
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
		
		if (empty($_SESSION["musicscore"])) {
			$_SESSION["musicscore"] = $displaypoints;
		}

		elseif ($displaypoints > $_SESSION["musicscore"]) {
			$_SESSION["musicscore"] = $displaypoints;
		}
	} 

	echo "<h1 class=naming>You scored $displaypoints/21</h1>";
	echo "<button onclick=\"window.location.href = 'category.php';\" >Select Other Quiz</button>&nbsp;";
	echo "<button onclick=\"window.location.href = 'music.php';\" >Re-attempt Quiz</button>";
}

else {
	

	if(!empty($_SESSION["musicscore"])){
		echo "<label class='naming'>Highest attempt: ";
		echo $_SESSION["musicscore"];
		echo "/21</label>";

	}
	
	echo "<label class='naming'>Answer either T / F in the text field </label><br/>";

	echo "<form action='music.php' method='POST' autocomplete='off'>\n";
	
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
