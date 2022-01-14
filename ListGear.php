<html>
<head>
	<title>List Music Gear</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<h1 class="head">Welcome to My Music Gear!</h1>
	<div class="nav">
		<a href="Homepage.html">Home</a>
		<a href="AllListings.php">View All Listed Gears</a>
		<a href="ListGear.php">List A Gear</a>
	</div>

	<h1 class="header">List Music Gear</h1>
	<?php
	
		$nameerr = $phoneerr = $emailerr = $idnumerr = $branderr = $yearerr  = $characteristicserr = $conditionerr = "";
		$name = $phone = $email = $idnum = $brand = $year = $characteristics = $condition = "";
		
		$phoneregex = "/^(^[689]{1})(\d{7})$/";
		$emailregex = "/^[^0-9][_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";
		$idnumregex = "/^([a-z]{3})-(\d{4})-(([0-1][0-9])|([2][0-1])|([5-9][0-9]))$/";
		
	if (isset($_POST["submit"])){

		if (empty($_POST["name"])) {
			$nameerr = "Name is required";
		} else {
			$name = test_input($_POST["name"]);
		}

		if (empty($_POST["phone"])) {
			$phoneerr = "Phone number is required";
		} elseif (!preg_match($phoneregex, $_POST["phone"])) {
			$phoneerr="Please enter a valid phone number."; 
		}  else {
			$phone = test_input($_POST["phone"]);
		}
		
		if (empty($_POST["email"])) {
			$emailerr = "Email is required";
		}	elseif (!preg_match($emailregex, $_POST["email"])) {
			$emailerr="Please enter a valid email address.";
		} else {
			$email = test_input($_POST["email"]);
		}
		
		if (empty($_POST["idnum"])){
			$idnumerr="Product ID is required.";
		} elseif (!preg_match($idnumregex, $_POST["idnum"])) {
			$idnumerr="Please enter a valid product number.";
		} else {
			$idnum=test_input($_POST["idnum"]);
		}

		if (empty($_POST["brand"])) {
			$branderr = "brand is required";
		} else {
			$brand = test_input($_POST["brand"]);
		}
		
		if (empty($_POST["year"])) {
			$yearerr = "Year of manufacture is required";
		} else {
			$year = test_input($_POST["year"]);
		}

		if (empty($_POST["char"])) {
			$characteristicserr = "Characteristics is required";
		} else {
			$characteristics = test_input($_POST["char"]);
		}

		if (empty($_POST["condition"])) {
			$conditionerr = "conditions is required";
		} else {
			$condition = test_input($_POST["condition"]);
		}

		$list = $name . "," . $phone . "," . $email . "," . $idnum . "," . $brand . "," . $year . "," . $characteristics . "," . $condition . "\n";

			// Validnumate form
				$fields = array("name", "phone", "email", "idnum", "brand", "year", "char", "condition");

			$error = false; 
			foreach ($fields AS $fieldname) { //Loop trough each field
				if (!isset($_POST[$fieldname])||empty($_POST[$fieldname])){
			    $error = true; //error is present
			}
		}
			if(!preg_match($phoneregex, $phone) || !preg_match($emailregex,$email) || !preg_match($idnumregex, $idnum)){
          $error= true; //error is present
        }
		
		$idnumarray = [];
		$row = 0;
		if (($text = fopen("GearDirectory.txt", "r")) !== false) {
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
					if ($idnumarray[$i]==$idnum) {
						$validator = true; 
					}
					
					if ($validator) {
						$idnumerr = "Product idnum is taken";
					}
					else {
					// Store input into text file
						$listfile = fopen("GearDirectory.txt", "a") or die("Unable to open file.");
						fwrite($listfile, $list);
						fclose($listfile);
						echo '<script type="text/javascript">alert("Successfully listed!"); window.location.href="Homepage.html";</script>';
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
		<form action="ListGear.php" method="post">
			<div class="form-style-heading">Contact Details</div>
			<label>
				<span>Name</span>
				<input type="text" class="input-field" name="name" value="<?php print $name;?>" />
				<span class="error"><?php echo $nameerr;?></span>
			</label>
			<label>
				<span>Phone Number</span>
				<input type="tel" class="input-field" name="phone" pattern="[0-9]{8}" value="<?php print $phone;?>"/>
				<span class="error"><?php echo $phoneerr;?></span>
			</label>

			<label><span>Email</span>
				<input type="email" class="input-field" name="email" value="<?php print $email;?>"/>
				<span class="error"><?php echo $emailerr;?></span>
			</label>

			<div class="form-style-heading">Music Gear Information</div>
			<label>
				<span>Product ID number</span>
				<input type="text" class="input-field" name="idnum" value="<?php print $idnum;?>"/>
				<span class="error"><?php echo $idnumerr;?></span>
			</label>
			<label>
				<span>Brand</span>
				<input type="text" class="input-field" name="brand" value="<?php print $brand;?>"/>
				<span class="error"><?php echo $branderr;?></span>
			</label>
			<label>
				<span>Year of Manufacture</span>
				<input type="number" class="input-field" name="year" min="1800" max="2020" value="<?php print $year;?>"/>
				<span class="error"><?php echo $yearerr;?></span>
			</label>
			<label>
				<span>Characteristics</span>
				<input type="textbox" class="input-field" name="char" value="<?php print $characteristics;?>"/>
				<span class="error"><?php echo $characteristicserr;?></span>
			</label>
			<label>
				<span>Condition</span>
				<input type="textbox" class="input-field" name="condition" value="<?php print $condition;?>"/>
				<span class="error"><?php echo $conditionerr;?></span>
			</label>
			<label>
				<span></span>
				<input type="submit" name = "submit">
			</label>
			<label>
				<span></span>
				<input type="reset" value="Clear Fields">
			</label>
		</form>
	</div>
</body>
</html>