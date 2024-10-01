<?php
session_start();
require "db.php";

function message($message){
  $msg = "<div class='alert'>
  <span class='closebtn' onclick='this.parentElement.style.display=none;'>&times;</span> 
  $message.</div>";
  echo $msg;
}

if(!isset($_SESSION["admin"])){
    header("location: admMain.php");
    exit;
}
$admin = $_SESSION["admin"];

if(!empty($_POST)){
  extract($_POST);
}

if(!empty($_POST) && isset($_POST["oldPass"]) && isset($_POST["newPass"])){
  echo "<h1>READS PASSWORDS</h1>";
  

  if(checkAdminPassword($admin["email"], $oldPass)){
    echo "<h1>True PASSWORDS</h1>";
    //password verified
    setAdminPassword($admin, $newPass);
    $message="password updated";
    header("location: admLogout.php");
  }else{
    $message="Password does not match with old password";
    header("location: ?message=$message");
  }
}

// change account information
if(!empty($_POST) && isset($email) && isset($market_name) && isset($city) && isset($district) && isset($address)){
  updateAdmin($email, $market_name, $city, $district, $address);
  
  checkAdmin($email, $admin["password"], $admin);
  $_SESSION["admin"] = $admin;

  if(isset($admin["remember"]) && isset($_POST["remember"]));
  if(isset($admin["remember"]) && !isset($_POST["remember"])){
    //destroy cookie
    setTokenByEmailAdmin($_SESSION["admin"]["email"], null);
    setcookie("access_token", "", 1);
    setcookie("PHPSESSID", "", 1 , "/");
  }
  if(!isset($admin["remember"]) && isset($_POST["remember"])){
    //create cookie
    $token = sha1(uniqid()."PRIVATE KEY IS HERE" . time());
    setcookie("access_token", $token, time() + 60*60*2, '/');
    setTokenByEmailAdmin($email, $token);
  }
  if(!isset($admin["remember"]) && !isset($_POST["remember"]));
//   $message="Admin Information Updated";
  // header("location: logout.php");
}

if(isset($_GET["message"])){
  message($_GET["message"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 50px;
        }
        h1 {
            text-align: center;
            color: #257D90;
            margin-bottom: 20px;
        }
        .midBox {
            width: 400px;
            padding: 30px;
            background-color: #FFF6DC;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .blob {
            position: absolute;
            width: 600px;
            top: -100px;
            left: -200px;
            opacity: 0.5;
            z-index: -1;
        }
        .blob2 {
            position: absolute;
            width: 400px;
            top: 300px;
            left: 200px;
            opacity: 0.5;
            z-index: -1;
        }
        .blob3 {
            position: absolute;
            width: 500px;
            top: 100px;
            left: 1000px;
            opacity: 0.5;
            z-index: -1;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:hover,
        input[type="password"]:hover {
            border-color: #999;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: calc(50% - 10px);
            box-sizing: border-box;
            margin: 5px 5px 5px 0;
        }
        .button[title="edit"] {
            background-color: #063EB8;
        }
        .error {
            color: red;
            font-style: italic;
        }
        .message {
            text-align: center;
            margin-top: 10px;
        }
        a {
            text-decoration: none;
            display: inline-block;
            width: calc(50% - 10px);
            box-sizing: border-box;
            margin: 5px 5px 5px 0;
            text-align: center;
        }
    </style>
</head>
<body>
  <div class="main">
  <?php include 'blob.php'; ?>
    <div class="midBox">
      <h1>Update Profile</h1>
      <form action="" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="<?= htmlspecialchars($admin['email']) ?>" readonly>
        </div>

        <div class="form-group">
          <label for="market_name">Market Name</label>
          <input type="text" name="market_name" id="market_name" value="<?= htmlspecialchars($admin['market_name']) ?>">
        </div>

        <div class="form-group">
          <label for="city">City</label>
          <input type="text" name="city" id="city" value="<?= htmlspecialchars($admin['city']) ?>">
        </div>

        <div class="form-group">
          <label for="district">District</label>
          <input type="text" name="district" id="district" value="<?= htmlspecialchars($admin['district']) ?>">
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" name="address" id="address" value="<?= htmlspecialchars($admin['address']) ?>">
        </div>

        <div class="form-group">
          <label for="remember">Remember Me</label>
          <input type="checkbox" name="remember" id="remember" <?= isset($admin["remember"]) ? "checked" : "" ?>>
        </div>

        <div class="form-group" style="display: flex; justify-content: space-between;">
          <button class="button" type="submit">Submit</button>
          <a href="admMain.php" class="button" title="edit">Back</a>
        </div>
      </form>
    </div>

    <!-- PASSWORD FORM BEGINS -->
    <div class="midBox">
      <h1>Change Password</h1>
      <form action="" method="post">
        <div class="form-group">
          <label for="oldPass">Enter Old Password</label>
          <input type="password" name="oldPass" id="">
        </div>

        <div class="form-group">
          <label for="newPass">Enter New Password</label>
          <input type="password" name="newPass" id="">
        </div>

        <div class="form-group" style="display: flex; justify-content: center;">
          <button class="button" type="submit">Change Password</button>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($fail)) {
      echo "<p class='error'>Wrong email or password</p>";
  }

  if (isset($_GET["message"])) {  
      echo "<p class='error'>" . htmlspecialchars($_GET["message"]) . "</p>";
  }
  ?>
</body>
</html>
