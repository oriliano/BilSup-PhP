<?php
session_start();
require "db.php";

$_SESSION['purchase_success'] = false;
$all_card = $_SESSION["cart"];


if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete"])) {
    $id = $_GET["delete"] ;
    $_SESSION["cnt"] = $_SESSION["cnt"] - $all_card[$id]["quantity"]; 

    unset($all_card[$id]);
  
    
    
}

if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["sum"])) {

    $id = $_GET["sum"] ;
    

    $cartProduct = getProductByID($id);
   
    if ($all_card[$id]["quantity"] < $cartProduct["stock"]){
        $all_card[$id]["quantity"]++;
        $_SESSION["cnt"] = $_SESSION["cnt"] + 1; 
    } else {
        $limit = true;
    }

    
   
    
}
if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["sub"])) {

    $id = $_GET["sub"] ;


    if ($all_card[$id]["quantity"] > 1){
        $all_card[$id]["quantity"]--;
        $_SESSION["cnt"] = $_SESSION["cnt"] - 1; 
    } else {
        $limit = true;
    }
     
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy_button'])) {
    foreach ($all_card as $p) {
        buyProduct($p);
    }
    $all_card = [];
    $_SESSION["cnt"] = 0;

    $_SESSION['purchase_success'] = true;
    
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .imgcls {
            width: 50px;
        }

        .disc {
            text-decoration: line-through;
            color: red;
        }
        p button {
            font-size: 17px;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button-container {
            display: flex;
            align-items: center;
        }

        .button-container span {
            margin: 0 10px;
        }

        .total-price {
            font-weight: bold;
        }

        .actions {
            text-align: center;
        }

        .actions a {
            margin: 0 10px;
        }
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            text-align: center;
            width: 300px;
            margin: 20px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
<?php if ($_SESSION['purchase_success'] == false): ?>
    <h1>Shopping Cart</h1>
    <?php endif; ?>
    <?php

if (!empty($all_card)) {
    

    echo "<table class='protable'>";
    echo "<thead><tr>";
    echo "<th>Title</th>";
    echo "<th>Price</th>";
    echo "<th>Expiration Date</th>";
    echo "<th>Image</th>";
    echo "<th>quantity</th>";
    echo "</tr></thead>";

    

$totalprice = 0;

    foreach ($all_card as $p) {
        
            $status = true;
            if ($p["product"]["price"] != $p["product"]["discounted_price"]) {
                $status = false;
            }
            echo "<tr>";
            echo "<td>", $p["product"]["title"], "</td>";
            echo "<td>";
            if ($status == true) {
                echo $p["product"]["price"] * $p["quantity"];
            } else {
                echo "<span class='disc'>", $p["product"]["price"] * $p["quantity"], "₺</span><br>", $p["product"]["discounted_price"] * $p["quantity"];
            }
            echo "₺(",$p["quantity"],")</td>";
            echo "<td>", $p["product"]["expdate"], "</td>";
            echo "<td><img class='imgcls' src='images/", $p["product"]['path'], "'></td>";

           
            echo "<td>
            <div class='button-container'>
                <a href='?sub=", $p["product"]["id"] ,"' class='button'>-</a>
                <span>", $p["quantity"],"</span>
                <a href='?sum=", $p["product"]["id"] ,"'class='button'>+</a>
            </div>
        </td>";
     
            
              echo '<td><a href="?delete=' . $p["product"]["id"] . '" class="button" title="Delete">Delete</a></td>';
            


           
            echo "</tr>";
            $totalprice = $totalprice + $p["product"]["discounted_price"] * $p["quantity"] ;
    }
    echo  "<tr><td colspan='5' class='total-price'>Total Price:</td><td class='total-price'>", $totalprice ,"₺</td></tr>";
    echo "</table>";
  
}
    $_SESSION["cart"] = $all_card;

    
   
  
?>
<form action="" method="post" enctype="multipart/form-data">
<?php if ($_SESSION['purchase_success'] == false): ?>
    <p><a class="button" href="custMain">Back</a><span><button class="button" type="submit" name="buy_button">Buy</button></span></p>
    <?php endif; ?>
</form>



</body>
<div>
    <?php if (isset($_SESSION['purchase_success']) && $_SESSION['purchase_success']): ?>
        <div class="success-message">
            <p>Successfully bought!</p>
        </div>
        <script>
        setTimeout(function() {
            window.location.href = 'custMain.php';
        }, 2000);
    </script>
    <?php endif; ?>

    
</div>
</html>
