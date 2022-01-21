<!DOCTYPE html>
<html>
<head>
<title>Sell Shoes</title>
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
$prodnumerr = $typeerr = $branderr = "";
$charerr = $conditionerr = $descriptionerr = "";

$name = $phone = $email = "";
$prodnum = $type = $brand = "";
$char = $condition = $description = "";

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
  //type
  if (empty($_POST["type"])) 
  {
    $typeerr = "Type cannot be blank";
    $error= true;
  } 
  else 
  {
    $type = test_input($_POST["type"]);
  }
  //brand
  if (empty($_POST["brand"])) 
  {
    $branderr = "Brand cannot be blank";
    $error= true;
  } 
  else 
  {
    $brand = test_input($_POST["brand"]);
    $error= false;
  }
  //characteristics
  if (empty($_POST["char"])) 
  {
    $charerr = "Characteristics cannot be blank";
    $error= true;
  } 
  else 
  {
    $char = test_input($_POST["char"]);
    $error= false;
  }
  //condition
  if (empty($_POST["condition"])) 
  {
    $conditionerr = "Condition cannot be blank";
    $error= true;
  } 
  else 
  {
    $condition = test_input($_POST["condition"]);
    $error= false;
  }
  //description
  if (empty($_POST["description"])) 
  {
    $descriptionerr = "Description cannot be blank";
    $error= true;
  } 
  else 
  {
    $description = test_input($_POST["description"]);
    $error= false;
  }

  //if there is no errors,try to read existing data
  if(!$error) 
  {
    //preparation to read file
    //create a list delimited with ,
    $list = $name . "," . $phone . "," . $email . "," . $prodnum . "," . $type . "," . $brand . "," . $char . "," . $condition . "," . $description . "\n";
    //create fields to be written
    $fields = array("name", "phone", "email", "prodnum", "type", "brand", "char", "condition", "description");

    //read the existing data
    $prodnumarray = [];
    $row = 0;
    
    if(($text = fopen("ShoesSale.txt", "r")) !== false)
    {
      //d = data
      while (($d = fgetcsv($text, 1000, ",")) !==false) 
      {
        $num = count($d);
        $prodnumarray[$row] = $d[3];
        $row++;
      }
      fclose($text);

      //check if product number is taken
      $taken = false;
      for ($i=0; $i < $row; $i++) 
      {
        if ($prodnumarray[$i]==$prodnum) 
        {
          $taken = true; 
        }
        if ($taken) 
        {
          $prodnumerr = "Product number is taken";
        }
        else 
        {
          //write to file if it is unique
          $listfile = fopen("ShoesSale.txt", "a") or die("Unable to open file.");
          fwrite($listfile, $list);
          fclose($listfile);
          echo '<script type="text/javascript">alert("Successfully listed!");</script>';
        }
      }
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
<h1>Add shoes to listing</h1>
<!-- create a form wih post method to the same page -->
<form id="SellShoesPage" method="POST" action="Sell_Shoes_Page.php">
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

<!-- create input text for basic information -->
<h2>Basic Information</h2>
<hr><br>
<label>Product Number: </label>
<input type="text" id="Prodnum" name="prodnum" placeholder="e.g. dd-mm-yy-abc">
<span class="error"><?php echo $prodnumerr;?></span><br><br>
<label>Type: </label>
<input type="text" id="Type" name="type">
<span class="error"><?php echo $typeerr;?></span><br><br>
<label>Brand: </label>
<input type="text" id="Brand" name="brand">
<span class="error"><?php echo $branderr;?></span><br><br>

<!-- create input text for product details -->
<h2>Product details</h2>
<hr><br>
<label>Characteristics: </label>
<input type="text" id="Char" name="char">
<span class="error"><?php echo $charerr;?></span><br><br>
<label>Condition: </label>
<input type="text" id="Condition" name="condition">
<span class="error"><?php echo $conditionerr;?></span><br><br>
<label>Description: </label>
<input type="text" id="Description" name="description">
<span class="error"><?php echo $descriptionerr;?></span><br><br>
<button type="submit" value="Submit">Submit</button>
</div>
</form> 

<a href="Home_Page.php"><button style="display:block; margin-left:auto; margin-right: auto;">Return to Home Page</button></a>
</body>
</html>
