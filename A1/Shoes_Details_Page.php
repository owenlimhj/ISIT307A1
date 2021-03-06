<!DOCTYPE html>
<html>

<head>
  <title>Shoe Details</title>
  <style>
    body {
      background: #B0E0E6;
    }

    .container {
      width: 800px;
      margin: 50px auto;
      font-size: 15px;
      margin-bottom: 15px;
      background: #f8f8f8;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border-radius: 8px;
    }

    h1 {
      text-align: center;
      margin: 0 0 15px;
      color: white;
      font-family: verdana;
    }

    label {
      padding: 12px 12px 12px 0;
      display: inline-block;
    }

    input[type=text],
    select,
    textarea {
      width: 40%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    button {
      background-color: #329EAA;
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }
    a:visited{
    color: inherit;
    }

    .error {
      color: red;
    }
  </style>
</head>

<body>

  <?php

  session_start();
  $prodnum = $_SESSION['ProductNum'];


  if ($file = fopen("ShoesSale.txt", "r")) {
    while (!feof($file)) {
      $line = fgets($file);
      if (strpos($line, $_SESSION['ProductNum']) == true) {
        $DetailsArray = explode(',', $line);

        if (strcmp($DetailsArray[3], $_SESSION['ProductNum']) == 0) {

          $prodNum = $DetailsArray[3];
          $type = $DetailsArray[4];
          $brand = $DetailsArray[5];
          $char = $DetailsArray[6];
          $condition = $DetailsArray[7];
          $description = $DetailsArray[8];
          $interest = $DetailsArray[9];
        }
      }
      //echo "<br>";
    }
    fclose($file);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: Express_Interest_Page.php");
  }


  ?>
  <br>
  <h1>Shoe Details</h1>

  <form id="ExpressInterestPage" method="POST">
    <div class="container">

      <!-- create input text for basic information -->
      <h2>Basic Information</h2>
      <hr><br>
      <label>Product Number: </label>
      <input type="text" id="Prodnum" name="prodnum" value='<?php echo $prodnum; ?>' disabled="disabled">
      <br><br>
      <label>Type: </label>
      <input type="text" id="Type" name="type" value='<?php echo $type; ?>' disabled="disabled"><br><br>
      <label>Brand: </label>
      <input type="text" id="Brand" name="brand" value='<?php echo $brand; ?>' disabled="disabled"><br><br>

      <!-- create input text for product details -->
      <h2>Product details</h2>
      <hr><br>
      <label>Characteristics: </label>
      <input type="text" id="Char" name="char" value='<?php echo $char; ?>' disabled="disabled"><br><br>
      <label>Condition: </label>
      <input type="text" id="Condition" name="condition" value='<?php echo $condition; ?>' disabled="disabled"><br><br>
      <label>Description: </label>
      <input type="text" id="Description" name="description" value='<?php echo $description; ?>' disabled="disabled"><br><br>

      <h2>Product details</h2>
      <hr><br>
      <label>Number of Interest: </label>
      <input type="text" id="interest" name="interest" value='<?php echo $interest; ?>' disabled="disabled"><br><br>
      <button type="submit" value="ExpressInterest">Express Interest</button>
    </div>
  </form>

  <button style="display:block; margin-left:auto; margin-right: auto;"><a  href="Home_Page.php">Return to Home Page</a></button>
</body>

</html>