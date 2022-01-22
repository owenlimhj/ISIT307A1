<!DOCTYPE html>
<html>
<head>
<title>Express Interest</title>
<style>
  body 
  {
    background: #B0E0E6;
  }
  .container 
  {
    width: 800px;
    margin: 50px auto;
  	font-size: 15px;
		margin-bottom: 15px;
    background: #f8f8f8;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
		border-radius: 8px;
  }
  h1 
  {
    text-align: center;
    margin: 0 0 15px;
	  color:white; 
		font-family:verdana;
  }
  label 
  {
    padding: 12px 12px 12px 0;
    display: inline-block;
  }
  input[type=text], select, textarea 
  {
    width: 40%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
  }   
  button 
  {
    background-color: #329EAA;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
  }
  .error 
  {
    color:red;
  }
</style>
</head>
<body>

<?php

$nameerr = $phoneerr = $emailerr = "";
$prodnumerr = $priceerr = "";

$name = $phone = $email = "";
$prodnum = $price = "";

$phoneregex = "/^(^[689]{1})(\d{7})$/"; //using SG local number format
$emailregex = "/^[^0-9][_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";
$prodnumregex = "/^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{2}(\-)[a-z][a-z][a-z]$/";

$error= false; //to check through errors

//when user press on submit
if ($_SERVER['REQUEST_METHOD']=='POST') 
{
  //do checking for each variable
  //name
  if (empty($_POST["name"])) 
  {
    $nameerr = "Name cannot be blank";
    $error= true;
  } 
  else 
  {
    $name = test_input($_POST["name"]);
    $error= false;
  }
  //phone
  if (empty($_POST["phone"])) 
  {
    $phoneerr = "Phone number cannot be blank";
    $error= true;
  } 
  elseif (!preg_match($phoneregex, $_POST["phone"])) 
  {
    $phoneerr="Enter a valid phone number."; 
    $error= true;
  }  
  else 
  {
    $phone = test_input($_POST["phone"]);
    $error= false;
  }
  //email
  if (empty($_POST["email"])) 
  {
    $emailerr = "Email cannot be blank";
    $error= true;
  }	
  elseif (!preg_match($emailregex, $_POST["email"])) 
  {
    $emailerr="Enter a valid email address.";
    $error= true;
  } 
  else 
  {
    $email = test_input($_POST["email"]);
    $error= false;
  }
  //product number
  if (empty($_POST["prodnum"])) 
  {
    $prodnumerr="Product ID cannot be blank.";
    $error= true;
  } 
  elseif (!preg_match($prodnumregex, $_POST["prodnum"])) 
  {
    $prodnumerr="Enter a valid product number.";
    $error= true;
  } 
  else 
  {
    $prodnum=test_input($_POST["prodnum"]);
    $error= false;
  }

  //brand
  if (empty($_POST["price"])) 
  {
    $priceerr = "Price cannot be blank";
    $error= true;
  } 
  else 
  {
    $price = test_input($_POST["price"]);
    $error= false;
  }

  

  //if there is no errors,try to read existing data
  //if file is not created, create the file
  $prodnumarray = [];
  $row = 0;
  $read = false;
  if(!$error) 
  {
    echo '<script type="text/javascript">alert("No error");</script>';
    //preparation to read file
    //create a list delimited with ,
    $list = $name . "," . $phone . "," . $email . "," . $price . "\n";
    
    if(($file = fopen("ExpressInterest.txt", "w")) == false)
    {
      $file = fopen("ExpressInterest.txt", "w");
      fclose($file);
      $read = true; //since it is empty, reading is completed
      echo '<script type="text/javascript">alert("ExpressInterest.txt created");</script>';
    }
    else
    {
      $text = fopen("ExpressInterest.txt", "r");
      //d = data
      while (($d = fgetcsv($text, 1000, ",")) !==false) 
      {
        $num = count($d);
        $prodnumarray[$row] = $d[3];
        $row++;
      }
      fclose($text);
      $read = true;
      echo '<script type="text/javascript">alert("ExpressInterest.txt reading completed");</script>';
    }
  }

  //if reading is done, check if product number is unique
  if($read == true)
  {
    echo '<script type="text/javascript">alert("Checking product num");</script>';
    $taken = false;
    for ($i=0; $i < $row; $i++) 
    {
      if($prodnumarray[$i]==$prodnum) 
      {
        $taken = true; 
      }
    }
    if($taken==true) 
    {
      $prodnumerr = "Product number is taken";
    }
    else 
    {
      //write to file if it is unique
      $listfile = fopen("ExpressInterest.txt", "a") or die("Unable to open file.");
      fwrite($listfile, $list);
      fclose($listfile);
      echo '<script type="text/javascript">alert("Successfully listed!");</script>';
    }
  }
}

function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<br>
<h1>Express Interest</h1>
<!-- create a form wih post method to the same page -->
<form id="ExpressInterestPage" method="POST" action="Express_Interest_Page.php">
<div class="container">

<!-- create input text for personal information -->
<h2>Personal Information</h2>
<hr><br>
<label>Name: </label>
<input type="text" id="Name" name="name">
<span class="error"><?php echo $nameerr;?></span><br><br>
<label>Phone: </label>
<input type="text" id="Phone" name="phone">
<span class="error"><?php echo $phoneerr;?></span><br><br>
<label>Email: </label>
<input type="text" id="Email" name="email">
<span class="error"><?php echo $emailerr;?></span><br><br>
<input type="text" id="Price" name="price">
<span class="error"><?php echo $priceerr;?></span><br><br>


<button type="submit" value="Submit">Submit</button>
</div>
</form> 

<a href="Home_Page.php"><button style="display:block; margin-left:auto; margin-right: auto;">Return to Home Page</button></a>
</body>
</html>

