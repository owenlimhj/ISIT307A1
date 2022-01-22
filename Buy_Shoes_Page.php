<!DOCTYPE html>
<html>
<head>
<title>Buy Shoes</title>
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
    font-family: arial, sans-serif;
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
  table 
  {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th 
  {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) 
  {
    background-color: #B0E0E6;
  }
</style>
</head>
<body>
<br>
<h1>Shoes on the listing</h1>
<div class="container">
<?php

$name = $phone = $email = "";
$prodnum = $type = $brand = "";
$char = $condition = $description = "";

session_start();


if(file_exists("ShoesSale.txt"))
{
  $text = file("ShoesSale.txt");
  if(!empty($text))
  {
    if (count($text)) 
    {
      echo "<table>";
      echo "<th>Product Number</th>";
      echo "<th>Type</th>";
      echo "<th>Brand</th>";

      foreach ($text as $txt) 
      {
        // Parse the line, retriving the values 
        list($name, $phone, $email, $prodnum, $type, $brand, $char, $condition, $description) = explode(",", $txt);

        // Remove newline from $description
        $description = trim($description);

        echo "<tr>";
        echo "<td>$prodnum</td>";
        $_SESSION['ProductNum'] = $prodnum;
        echo "<td>$type</td>";
        echo "<td>$brand</td>";
        echo "</tr>";
      }
      echo "</table>";
    }
  }
  else
  {
    //the array is empty
    echo "<label>" . "There are no shoes on sale yet." . "</label>";
  }
  fclose($text);
}
else
{
  //file doesnt exist
  echo "<label>" . "There are no shoes on sale yet." . "</label>";
} 
?>
<br><br>
<!--search value from this form will be submitted to Details Page-->
<!--Pressing submit brings you to the Details Page-->
<form id="BuyShoesPage" method="POST" action="Shoes_Details_Page.php">
<label>&nbsp;Enter Product Number to search: </label><br><br>
<input type="text" id="search" placeholder="Search.."><br><br>
<button type="submit" value="Submit">Submit</button>
</form> 

</div>
<a href="Home_Page.php"><button style="display:block; margin-left:auto; margin-right: auto;">Return to Home Page</button></a>
</body>
</html>

