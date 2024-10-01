<?php
session_start();
require_once "db.php";
require_once './vendor/autoload.php';
require_once './Mail.php';

$status = false;
$error = false;
$mailerror = false;
$err = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';

    if (empty($err)) {
        extract($_POST);
        if (doUserExist($email)) {
            $mailerror = true;
        } else {
            if (isset($_POST['code'])) {
                // Handling the verification code
                $random = $_SESSION["random"];
                $code = intval($_POST['code']);
                
                if ($random == $code) {
                    // Verification successful
                    $post = $_SESSION["post"];
                    extract($post);
                    
                    user_register($email, $username, $pass, $city, $district, $address);
                    
                    if (checkUser($email, $pass, $user)) {
                        $_SESSION["user"] = $user; // Creating an active session
                        header("Location: custMain.php");
                        exit;
                    } else {
                        // Handle registration failure
                        $status = true;
                    }
                } else {
                    // Verification failed
                    $error = true;
                    $status = true;
                }
            } else {
                // Handling initial registration data submission
                $_SESSION["post"] = $_POST;
                
                $subject = "Customer Mail Verification";
                $random = rand(100000, 999999);
                
                Mail::send($email, $subject, $random);
                
                $_SESSION["random"] = $random;
                $status = true;
                $error = false;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .main {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #DCF1F9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #257D90;
            margin-bottom: 20px;
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
            width: 100%;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-style: italic;
        }
        .message {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="main">
    <?php include 'blob.php'; ?>
        <h2>Customer Registration</h2>
        <?php if (!empty($status)): ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="code">CODE:</label>
                    <input type='text' name='code' id='code'>
                    <?php if ($error): ?>
                        <p class="error">Invalid verification code.</p>
                    <?php endif; ?>
                </div>
                <button type='submit' class="button">Register</button>
            </form>
            <?= exit; ?>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type='text' name='email' id='email' value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>">
                <?php if (!empty($err)): ?>
                        <?php foreach ($err as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php endforeach; ?>

                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type='text' name='username' id='username' value="<?= isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type='password' name='pass' id='pass'>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type='text' name='city' id='city' value="<?= isset($city) ? htmlspecialchars($city) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="district">District:</label>
                <input type='text' name='district' id='district' value="<?= isset($district) ? htmlspecialchars($district) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type='text' name='address' id='address' value="<?= isset($address) ? htmlspecialchars($address) : ''; ?>">
            </div>
            <button type='submit' class="button">Register</button>
            <?php if ($mailerror): ?>
                <p class="error">Email is being used by another user.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
