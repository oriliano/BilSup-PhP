<?php
session_start();
require "db.php";

$user = $_SESSION["admin"];

$upload_max_filesize = ini_get("upload_max_filesize");
$post_max_size = ini_get("post_max_size");

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);

    // Validate stock as integer
    if (!filter_var($stock, FILTER_VALIDATE_INT)) {
        $error[] = "Stock must be an integer";
    }

    // Validate price as float
    if (!filter_var($price, FILTER_VALIDATE_FLOAT)) {
        $error[] = "Price must be a float";
    }

    // Validate discounted price as float
    if (!filter_var($discounted_price, FILTER_VALIDATE_FLOAT)) {
        $error[] = "Discounted Price must be a float";
    }
    $expdate = $_POST["expdate"];
    if (empty($expdate)) {
        $error[] = "Expiration Date must be entered";
    } // Assuming the date is submitted via a form

// Validate date format
$dateObj = DateTime::createFromFormat('d-m-Y', $expdate);



    foreach ($_FILES as $fb => $file) {
        if ($file["size"] == 0) {
            if (empty($file["name"])) {
                $error[] = "No file selected for filebox '<b>$fb</b>'";
            } else {
                $error[] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'";
            }
        } else if (!empty($expdate)){
            move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]);
            createProduct($user["email"], $title, $stock, $price, $discounted_price, $expdate, $file["name"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload App</title>
    <style>
        
 body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        h1 {
            color: #257D90;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-top: 20px;
            width: 400px;
            background-color: #FFF6DC;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="file"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button[title="Add New Product"] {
            background-color: #007bff;
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

        .error {
            color: red;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php if (!empty($_POST)): ?>
    <form action="" method="post" enctype="multipart/form-data">
    <?php include 'blob.php'; ?>
    <h1>File Upload App</h1>
    <p><input type="text" name="title" placeholder="Title" value="<?php echo htmlspecialchars($title); ?>"></p>
    <p><input type="text" name="stock" placeholder="Stock" value="<?php echo htmlspecialchars($stock); ?>"></p>
    <p><input type="text" name="price" placeholder="Price" value="<?php echo htmlspecialchars($price); ?>"></p>
    <p><input type="text" name="discounted_price" placeholder="Discounted Price" value="<?php echo htmlspecialchars($discounted_price); ?>"></p>
    <p><input type="file" name="file" placeholder="Photo"></p>
    <p>Expiration Date: <input type="date" name="expdate" placeholder="Expiration Date" value="<?php echo htmlspecialchars($expdate); ?>"></p>

    <button type="submit" title="Add New Product">Add New Product</button>
   
    <a href="admMain.php"><button type="button" >Back to Main</button></a>
    <a href="admLogout.php"><button type="button">Logout</button></a>

    <p class="error">
        <?php
        if (!empty($error)) {
            echo join("<br><br>", $error);
        }
        ?>
    </p>
</form>
<?php elseif (empty($_POST)): ?>
    <form action="" method="post" enctype="multipart/form-data">
    <?php include 'blob.php'; ?>
    <h1>File Upload App</h1>
    <p><input type="text" name="title" placeholder="Title"></p>
    <p><input type="text" name="stock" placeholder="Stock"></p>
    <p><input type="text" name="price" placeholder="Price"></p>
    <p><input type="text" name="discounted_price" placeholder="Discounted Price"></p>
    <p><input type="file" name="file" placeholder="Photo"></p>
    <p>Expiration Date: <input type="date" name="expdate" placeholder="Expiration Date"></p>

    <button type="submit" title="Add New Product">Add New Product</button>
   
    <a href="admMain.php"><button type="button" >Back to Main</button></a>
    <a href="admLogout.php"><button type="button">Logout</button></a>

    <p class="error">
        <?php
        if (!empty($error)) {
            echo join("<br><br>", $error);
        }
        ?>
    </p>
</form>
    
<?php endif; ?>



</body>
</html>
