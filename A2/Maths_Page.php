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
$MathQuestions = array(
    "1+1" => "2",
    "2*2" => "4",
    "6/6" => "1",
    "7-2" => "5",
    "2+1" => "3",
    "12/2" => "6",
);

$RandomQuestions = array_rand($MathQuestions,3);

function calculatepoints($correct,$wrong) 
{
    $total = ($correct * 2)-($wrong * 1);
    return $total;
}

$wrong = 0;
$correct = 0;
$counter = 1;
$showpoints = 0;
$_SESSION["mathscore"] = 0;

if (isset($_POST['submit'])) 
{
	$Answer = $_POST['ans'];
	if (is_array($Answer)) 
    {
		foreach ($Answer as $Questions => $Response) 
        {
			$Response = stripslashes($Response);
            //check length of response string
			if (strlen($Response)>0) 
            {
				if (strcasecmp($MathQuestions["$Questions"],$Response)==0) 
                {
					echo "<label>Correct! $Questions is " . $MathQuestions[$Questions] . ".</label><br /><br />\n";
					$correct++;
				}
				else 
                {
					echo "<label>Sorry, Incorrect Answer.</label><br /><br />\n";
					$wrong++;
				}	
			}
			else 
            {
				echo "<label>You did not attempt $Questions.</label><br /><br />\n";
			} 
		}
	}
    //points for current attempt
    $showpoints = calculatepoints($correct,$wrong);
	if ($showpoints > 0) 
    {
		if (empty($_SESSION["mathscore"])) 
        {
			$_SESSION["mathscore"] = $showpoints;
		}
		elseif ($showpoints > $_SESSION["mathscore"]) 
        {
			$_SESSION["mathscore"] = $showpoints;
		}
	} 
	echo "<h1>You scored $showpoints/6</h1>";
	echo "<button style='display:block;  margin-left:auto; margin-right:auto; background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; font-size: 16px;'><a  href='Subject_Page.php'>Select Another Quiz</a></button>&nbsp;";
	echo "<button style='display:block; margin-left:auto; margin-right:auto; background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; font-size: 16px;'><a  href='Maths_Page.php'>Re-attempt Quiz</a></button>";
}
else 
{	
	echo "<label>Enter your answer in the text field </label><br/>";

	echo "<form action='Maths_Page.php' method='POST' autocomplete='off'>\n";
	
	for ($i=0; $i < 3 ; $i++) 
    { 
		echo "<label class='question-text'>$counter. ";
		echo "$RandomQuestions[$i].</label>";
		echo "<input type='text' class='input-field-quiz' name='ans[$RandomQuestions[$i]]' /><br /><br />";
		$counter++;
	}
	echo "<input type='submit' name='submit' value='Submit Answers' style='background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; display:block; font-size: 16px;' />&nbsp"; 
	echo "<input type='reset' name='reset' value='Clear' style='background-color: #329EAA; border-radius:8px; border: none; color: white; padding: 5px 15px 8px 15px; text-align: center; text-decoration: none; display:block; font-size: 16px;' />\n";
	echo "</form>\n";
}
?>
</div>
<button style="background-color: #329EAA; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display:block; font-size: 16px; margin-left:auto; margin-right: auto;"><a  href="Subject_Page.php">Back</a></button>
</body>
</html>