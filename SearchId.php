<!DOCTYPE html>
<html>
<head>
	<title>Search Result</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<h1 class="head">Welcome to My Music Gear!</h1>
	<div class="nav">
		<a href="Homepage.html">Home</a>
		<a href="AllListings.php">View All Listed Gears</a>
		<a href="ListGear.php">List A Gear</a>
	</div>

	<h1 class="header">Search Result</h1>
	<div class="listing-style">
	
	<?php
	$listerr = "Id number not found.";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (empty($_POST["SearchId"])) {
			$listerr = "Please enter an id number.";
		} else {
			$searchfor = $_POST["SearchId"];
			$listheader= array("Seller Name", "Phone Number", "Email", "ID No", "Model","Year of Manufacture","Characteristics","Condition");
			$idnumarray = [];
			$row = 0;
			if (($text = fopen("GearDirectory.txt", "r")) !== false) {

				while (($d = fgetcsv($text, 1000, ",")) !==false) {
					$num = count($d);
					$idnumarray[$row] = $d[3];
					$row++;
				}

			}
			rewind($text);

			$idnumarray1 = [];
			$row2 = 0;
			$buyercount = 0;
			if (($buyerInterest = fopen("BuyerExInterest.txt", "r")) !== false) {
				while (($d1 = fgetcsv($buyerInterest, 1000, ",")) !== false) {
					$num2 = count($d1);
					$idnumarray1[$row2] = $d1[0];
					$buyercount += substr_count($d1[0],$searchfor);
					$row2++;

				}
			}	
			rewind($buyerInterest);

			$c = 0;
			$row1 = 0;
			$validator = false;
			for ($i=0; $i < $row; $i++) {
				if ($idnumarray[$i]==$searchfor) {
					$validator = true; 
					if ($validator) {
						while (($data = fgetcsv($text, 1000, ",")) !==false) {
							if ($row1==$c) {
								$num1 = count($data);
								for ($a=0; $a < $num1 ; $a++) { 
									$listerr = "";
									echo $listheader[$a] . ": " . "</span>" . "<span>" . $data[$a] . "</span>" . "</label>" . "<br>";

								}
								echo "No of Buyer Interested" . ": " . "</span>" . "<span>" . $buyercount . "</span>" . "</label>" . "<br>";
							}
							$row1++;
						}

					}
				} 
				else
				{
					$c++;
				}
	}

	fclose($text);
	fclose($buyerInterest);
	}
}
	
	?>
	
	<label><span><?php echo $listerr;?></span></label>
</div>

	<?php 
	
		$idnumberr = $pricer = $namer = $phoner = $emailer = "";
		$idNumber = $proposedPrice = $buyerName = $contactNum = $buyerEmail = "";
		$phoneregex = "/^(^[689]{1})(\d{7})$/";
		$emailregex = "/^[^0-9][_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";
		$idnumregex = "/^([a-z]{3})-(\d{4})-(([0-1][0-9])|([2][0-1])|([5-9][0-9]))$/";

		if (isset($_POST["submitInterest"])){
		
		if (empty($_POST["idNumber"])){
			$idnumberr="Product ID is required.";
		} elseif (!preg_match($idnumregex, $_POST["idNumber"])) {
			$idnumberr="Please enter a valid product id number.";
		} else {
			$idNumber=test_input($_POST["idNumber"]);
		}
		
		if (empty($_POST["proposedPrice"])) {
			$pricer = "Price is required";
		} else {
			$proposedPrice = test_input($_POST["proposedPrice"]);
		}
		
		if (empty($_POST["buyerName"])) {
			$namer = "Name is required";
		} else {
			$buyerName = test_input($_POST["buyerName"]);
		}

		if (empty($_POST["contactNum"])) {
			$phoner = "Phone number is required";
		} elseif (!preg_match($phoneregex, $_POST["contactNum"])) {
			$phoner="Please enter a valid phone number."; 
		}  else {
			$contactNum = test_input($_POST["contactNum"]);
		}
		
		if (empty($_POST["buyerEmail"])) {
			$emailer = "Email is required";
		}	elseif (!preg_match($emailregex, $_POST["buyerEmail"])) {
			$emailer="Please enter a valid email address.";
		} else {
			$buyerEmail = test_input($_POST["buyerEmail"]);
		}

		$list = $idNumber . "," . $proposedPrice . "," . $buyerName . "," . $contactNum . "," . $buyerEmail . "\n";

			// Validnumate form
			$fields = array("idNumber", "proposedPrice", "buyerName", "contactNum", "buyerEmail");
			$error = false; 
			foreach ($fields AS $fieldname) { //Loop trough each field
				if (!isset($_POST[$fieldname])||empty($_POST[$fieldname])){
			    $error = true; //error is present
			}
		}
			if(!preg_match($phoneregex, $contactNum) || !preg_match($emailregex,$buyerEmail) || !preg_match($idnumregex, $idNumber)){
			$error= true; //error is present
        }
		
		$idnumarray = [];
		$row = 0;
		if (($text = fopen("BuyerExInterest.txt", "r")) !== false) {
					// d = data
			while (($d = fgetcsv($text, 1000, ",")) !==false) {
				$num = count($d);
						// see what the system has read
				$idnumarray[$row] = $d[3];
				$row++;
			}
			fclose($text);
		}
		else {
			echo "No such file." . "<br>";
		}
			if(!$error) { //Only create queries when no error occurs
			  	//Validate Product idnum
				$validator = false;
				for ($i=0; $i < $row; $i++) 
					if ($idnumarray[$i]==$idNumber) {
						$validator = true; 
					}
					
					if ($validator) {
						$idnumberr = "Product idnum is taken";
					}
					else {
					// Store input into text file
						$listfile = fopen("BuyerExInterest.txt", "a") or die("Unable to open file.");
						fwrite($listfile, $list);
						fclose($listfile);
						echo '<script type="text/javascript">alert("Interest has been successfully submited! Redirecting you to the homepage!"); window.location.href="Homepage.html";</script>';
					}
				}
			
		}
		
		function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
		}
	?>

	<div class="form-style">
	<form action="SearchId.php" method="post">
		<div class="form-style-heading">Express Interest</div>
			<label>
				<span>Product Id Number:</span>
				<input type="text" name="idNumber" class="input-field" value="<?php print $idNumber;?>">
				<span class="error"><?php echo $idnumberr;?></span>
			</label>
			<label>
				<span>Proposed Price:</span>
				<input type="number" name="proposedPrice"  class="input-field" value="<?php print $proposedPrice;?>">
				<span class="error"><?php echo $pricer;?></span>
			</label>
			<label>
				<span>Name:</span>
				<input type="text" name="buyerName" class="input-field" value="<?php print $buyerName;?>">
				<span class="error"><?php echo $namer;?></span>
			</label>
			<label>
				<span>Contact Number:</span>
				<input type="tel" class="input-field" name="contactNum" pattern="[0-9]{8}" value="<?php print $contactNum;?>">
				<span class="error"><?php echo $phoner;?></span>
			</label>
			<label>
				<span>Email Address:</span>
				<input type="email" name="buyerEmail" class="input-field" value="<?php print $buyerEmail;?>">
				<span class="error"><?php echo $emailer;?></span>
			</label>
			<label>
				<span></span>
				<input type="submit" value="Submit Interest" name="submitInterest">
			</label>
			<label>
				<span></span>
				<input type="reset" value="Clear Fields">
			</label>
			
	</form>
	</div>
</body>
</html>