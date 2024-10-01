<?php
session_start();
require "db.php";

// Process Login Form
if (!empty($_POST)) {
    extract($_POST);

    if (checkAdmin($email, $pass, $admin)) {
        // now, you are authenticated
        // remember me part
        if (isset($remember)) {
            $token = sha1(uniqid() . "Private Key is Here" . time()); // generate a random text
            setcookie("access_token", $token, time() + 60 * 60 * 24 * 365 * 10); // for 10 years
            setTokenByEmailAdmin($email, $token);
        }

        // login as $admin
        $_SESSION["admin"] = $admin;
        header("Location: admMain.php");
        exit;
    } else {
        $fail = true;
    }
}

// Remember-me part
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_COOKIE["access_token"])) {
    $admin = getAdminByToken($_COOKIE["access_token"]);
    if ($admin) {
        $_SESSION["admin"] = $admin; // auto login
        header("Location: admMain.php");
        exit;
    }
}

// if the admin has already logged in, don't show login form
if ($_SERVER["REQUEST_METHOD"] == "GET" && isAuthenticatedAdmin()) {
    header("Location: admMain.php"); // auto login
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
    <title>Admin Login</title>
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
            text-align: center;
            color: #257D90;
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
        .form-group {
            margin-bottom: 15px;
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
            <h1>Admin Login</h1>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="pass">Password :</label>
                <input type="password" name="pass" value="<?= htmlspecialchars($_POST['pass'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="remember">Remember :</label>
                <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
            </div>
            
            <div class="form-group">    
            <a href="admReg.php" class="button" title="edit">Register</a>
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
    // Display Post Data after web form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<hr><p>POST Data : (Sticky Web Form)</p>";
       
    }
?>
