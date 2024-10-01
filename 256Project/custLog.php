<?php
session_start();
require "db.php";

if (!empty($_POST)) {
    extract($_POST);
    if (checkUser($email, $pass, $user)) {
        // now, you are authenticated
        
        // remember me part
        if (isset($remember)) {
            $token = sha1(uniqid() . "Private Key is Here" . time()); // generate a random text
            setcookie("access_token", $token, time() + 60*60*24*365*10); // for 10 years
            setTokenByEmail($email, $token);
        }

        $_SESSION["user"] = $user;
        header("Location: custMain.php");
        exit;
    } else {
        $fail = true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_COOKIE["access_token"])) {
    $user = getUserByToken($_COOKIE["access_token"]);
    if ($user) {
        $_SESSION["user"] = $user; 
        header("Location: custMain.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isAuthenticated()) {
    header("Location: custMain.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
    <style>
       
        .main {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
        h1 {
            color: #257D90;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }
        .midBox {
            width: 400px;
            padding: 30px;
            text-align: left;
            background-color: #FFF6DC;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        a {
            text-decoration: none;
        }
        .sign {
            padding: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
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
            margin: 5px;
        }
        .button[title="edit"] {
            background-color: #063EB8;
        }
        .form-group {
            margin-bottom: 15px;
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
        }
    </style>
</head>
<body>
    <div class="main">
        <?php include 'blob.php'; ?>
        <div class="midBox">
            <form action="?" method="post">
                <h1>Customer Login</h1>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="pass">Password: </label>
                    <input type="password" id="pass" name="pass" value="<?= htmlspecialchars($_POST['pass'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="remember">Remember: </label>
                    <input type="checkbox" id="remember" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
                </div>
                <div class="form-group">
                    <a href="custReg.php" class="button" title="edit">Register</a>
                    <button class="button" type="submit">Login</button>
                </div>
            </form>
            <?php
      if (isset($fail)) {
         echo "<p class='error'>Wrong email or password</p>";
      }
      
      if (isset($_GET["error"])) {  
        echo "<p class='error'>You tried to access main.php directly</p>";
      }
    ?>
        </div>
    </div>
    
    
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<hr><p>POST Data : (Sticky Web Form)</p>";
    
}
?>
