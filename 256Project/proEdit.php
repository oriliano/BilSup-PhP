<?php
session_start();
require "db.php";

$user = $_SESSION["admin"];
$id = $_GET["id"];

$product = getProductByID($id);

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST)) {

    $error[] = "Post Max Error";
} else {
    extract($_POST);

    if (empty($expdate)) {
        $error[] = "Expiration Date must be entered";
    }
    foreach ($_FILES as $fb => $file) {
        if ($file["size"] == 0) {
            if (empty($file["name"])) {
                updateProduct($id, $title, $stock, $price, $discounted_price, $expdate, $product["path"]);
            } else {
                $error[] = "{$file['name']} is greater than max upload size in '<b>$fb</b>'";
            }
        } else {
            move_uploaded_file($file["tmp_name"], "./images/" . $file["name"]);
            updateProduct($id, $title, $stock, $price, $discounted_price, $expdate, $file["name"]);
        }
    }
}

$upload_max_filesize = ini_get("upload_max_filesize");
$post_max_size = ini_get("post_max_size");
$product = getProductByID($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        form {
            background-color: #DCF1F9;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="file"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        a.button {
            width: 100%;
            text-align: center;
            display: inline-block;
            padding: 10px 0px;
            background-color: #063EB8;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        a.button:hover {
            background-color: #042c7a;
        }
    </style>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
<?php include 'blob.php'; ?>
    <p><label for="title">Title:</label> <input type="text" name="title" id="title" value="<?= htmlspecialchars($product['title']) ?>" placeholder="Title"></p>
    <p><label for="stock">Stock:</label> <input type="text" name="stock" id="stock" value="<?= htmlspecialchars($product['stock']) ?>" placeholder="Stock"></p>
    <p><label for="price">Price:</label> <input type="text" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" placeholder="Price"></p>
    <p><label for="discounted_price">Discounted Price:</label> <input type="text" name="discounted_price" id="discounted_price" value="<?= htmlspecialchars($product['discounted_price']) ?>" placeholder="Discounted Price"></p>
    <p><label for="file">Image:</label> <input type="file" name="file" id="file"></p>
    <p><label for="expdate">Expiration Date:</label> <input type="date" name="expdate" id="expdate" value="<?= htmlspecialchars($product['expdate']) ?>"></p>

    <button type="submit" class="button" title="update">Update Product</button>
    <a class="button" href="admMain.php">Back</a>
</form>


</body>
</html>
