<!DOCTYPE html>
<html>

<head>
  <title>Express Interest</title>
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

    .error {
      color: red;
    }
  </style>
</head>

<body>

  <?php
  session_start();
  $nameerr = $phoneerr = $emailerr = $priceerr = "";
  $name = $phone = $email = $price = "";
  $prodnum = $_SESSION['ProductNum'];
  $phoneregex = "/^(^[689]{1})(\d{7})$/"; //using SG local number format
  $emailregex = "/^[^0-9][_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/";

  $error = []; //to check through errors

  //when user press on submit
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //do checking for each variable
    //name
    if (empty($_POST["name"])) {
      $nameerr = "Name cannot be blank";
      $error[0] = true;
    } else {
      $name = test_input($_POST["name"]);
      $error[0] = false;
    }
    //phone
    if (empty($_POST["phone"])) {
      $phoneerr = "Phone number cannot be blank";
      $error[1] = true;
    } elseif (!preg_match($phoneregex, $_POST["phone"])) {
      $phoneerr = "Enter a valid phone number.";
      $error[1] = true;
    } else {
      $phone = test_input($_POST["phone"]);
      $error[1] = false;
    }
    //email
    if (empty($_POST["email"])) {
      $emailerr = "Email cannot be blank";
      $error[2] = true;
    } elseif (!preg_match($emailregex, $_POST["email"])) {
      $emailerr = "Enter a valid email address.";
      $error[2] = true;
    } else {
      $email = test_input($_POST["email"]);
      $error[2] = false;
    }

    if (empty($_POST["price"])) {
      $priceerr = "Price cannot be blank";
      $error[3] = true;
    } else if (!is_numeric($_POST["price"])) {
      $priceerr = "Price must be number";
      $error[3] = true;
    } else {
      $price = test_input($_POST["price"]);
      $error[3] = false;
    }



    //if there is no errors,try to read existing data
    //if file is not created, create the file
    $read = false;
    if ($error[0] == false && count(array_unique($error)) == 1) {

      echo '<script type="text/javascript">alert("No error");</script>';
      //preparation to read file
      //create a list delimited with ,
      $list = $prodnum . "," . $name . "," . $phone . "," . $email . "," . $price . "\n";

      if (!file_exists("ExpInterest.txt")) {
        $file = fopen("ExpInterest.txt", "w");
        fclose($file);
        $read = true; //since it is empty, reading is completed
        echo '<script type="text/javascript">alert("ExpInterest.txt created");</script>';
      } else {
        $listfile = fopen("ExpInterest.txt", "a") or die("Unable to open file.");
        fwrite($listfile, $list);
        fclose($listfile);
        echo '<script type="text/javascript">alert("We have taken note of your interest, THANK YOU!");</script>';
      }

      $contents = file_get_contents("ShoesSale.txt");
      $contents = preg_replace('/^\h*\v+/m', '', $contents);
      $contents_array = preg_split("/\\r\\n|\\r|\\n/", $contents);
      $new_contents = "";
      echo count($contents_array);
      foreach ($contents_array as &$line) {    // for each line
        if (isset($line)) {
          if (strpos($line, $_SESSION["ProductNum"]) == true) {
            $DetailsArray = explode(',', $line);
            $interest = $DetailsArray[9] + 1;
            $name = $DetailsArray[0];
            $phone = $DetailsArray[1];
            $email = $DetailsArray[2];
            $prodNum = $DetailsArray[3];
            $type = $DetailsArray[4];
            $brand = $DetailsArray[5];
            $char = $DetailsArray[6];
            $condition = $DetailsArray[7];
            $description = $DetailsArray[8];
            $interest = $DetailsArray[9] + 1;
            $new_line = $DetailsArray[0] . "," . $DetailsArray[1] . "," .   $DetailsArray[2] . "," .   $DetailsArray[3] . "," .   $DetailsArray[4] . "," .   $DetailsArray[5] . "," .  $DetailsArray[6] . "," .  $DetailsArray[7] . "," .   $DetailsArray[8] . "," .   $interest . "\n";
            $new_contents .= $new_line;
          } else {
            $new_contents .= $line . "\n";
          }
        }
      }

      $new_contents = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $new_contents);
      file_put_contents("ShoesSale.txt", $new_contents);
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
      <span class="error"><?php echo $nameerr; ?></span><br><br>
      <label>Phone: </label>
      <input type="text" id="Phone" name="phone">
      <span class="error"><?php echo $phoneerr; ?></span><br><br>
      <label>Email: </label>
      <input type="text" id="Email" name="email">
      <span class="error"><?php echo $emailerr; ?></span><br><br>
      <label>Price: </label>
      <input type="text" id="Price" name="price">
      <span class="error"><?php echo $priceerr; ?></span><br><br>


      <button type="submit" value="Submit">Submit</button>
    </div>
  </form>

  <a href="Home_Page.php"><button style="display:block; margin-left:auto; margin-right: auto;">Return to Home Page</button></a>
</body>

</html>