<?php
  session_start();
  require "db.php";

  if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $stmt = $db->prepare("DELETE FROM products where id = ?");
    $stmt->execute([$id]);
  }

  // Check if the user is authenticated
  if (!isAuthenticatedAdmin()) {
    header("Location: index.php?error");
    exit;
  }

  $user = $_SESSION["admin"];
  $products = getMarketProducts($user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #257D90;
            font-family: Arial;
            font-size: 20px;
            text-align: center;
        }
        .main {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Styles for the heading */
.main h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Styles for the table */
.main table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

/* Styles for table rows and cells */
.main table tr {
    border-bottom: 1px solid #ddd;
}

.main table td {
    padding: 10px;
    text-align: left;
    vertical-align: middle;
    color: #555;
    font-size: 16px;
}

/* Styles for the font awesome icons */
.main table td i.fa {
    margin-right: 8px;
    color: #888;
}

/* Styles for the info spans */
.main .info {
    font-weight: bold;
    color: #333;
}

/* Styles for the buttons */
.main div a {
    text-decoration: none;
}

.main div button {
    padding: 10px 15px;
    margin: 5px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.main div button:hover {
    background-color: #0056b3;
}

.main div button i.fa {
    margin-right: 5px;
}

/* Specific button styles for edit and logout */
.main div a:first-child button {
    background-color: #28a745;
}

.main div a:first-child button:hover {
    background-color: #218838;
}

.main div a:last-child button {
    background-color: #dc3545;
}

.main div a:last-child button:hover {
    background-color: #c82333;
}
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .product {
            width: 200px;
            padding: 20px;
            text-align: center;
            background-color: #FFF6DC;
            border-radius: 15px;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product img {
            width: 150px;
            height: auto;
            border-radius: 10px;
        }
        .info {
            font-family: Arial;
            text-align: left;
            width: 100%;
        }
        .edit {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .button[title="add"] {
            background-color: #4CAF50;
        }
        .button[title="edit_user"] {
            background-color: #FF5733;
        }
        .button[title="edit"] {
            background-color: #063EB8;
        }
        .button[title="delete"] {
            background-color: #E10707;
        }
        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="main">
    <h1>Welcome to Profile Page</h1>
    <table>
        <tr>
        <tr>
            <td><i class="fas fa-envelope"></i> <span class="info"><?= htmlspecialchars($user["email"]) ?></span></td>
            <td><i class="fas fa-user"></i> <span class="info"><?= htmlspecialchars($user["market_name"]) ?></span></td>
            <td><i class="fas fa-city"></i> <span class="info"><?= htmlspecialchars($user["city"]) ?></span></td>
            <td><i class="fas fa-map-marker-alt"></i> <span class="info"><?= htmlspecialchars($user["district"]) ?></span></td>
            <td><i class="fas fa-home"></i> <span class="info"><?= htmlspecialchars($user["address"]) ?></span></td>
        </tr>
        </tr>
    </table>
    <div>
    <a href="proCreate.php" class="button" title="add">Add New Product</a>
    <a href="admEdit.php"><button><i class="fa fa-edit"></i> Edit Profile</button></a>
    <a href="admLogout.php"><button><i class="fa fa-door-open"></i> Logout</button></a>
    </div>
</div>
   
    <div class="container">
        <?php foreach($products as $product): ?>
            <div class="product">
                <h1><?=$product['title']?></h1>
                <img class="imgcls" src="images/<?=$product['path']?>" alt="">
                <div class="info">
                    <p>Stock: <?=$product['stock']?></p>
                    <p>Price: <?=$product['price']?></p>
                    <p>Discounted Price: <span><?=$product['discounted_price']?></span></p>
                    <p>Expiration Date: <?=$product['expdate']?></p>
                    <?php
                    $now = date('Y-m-d');
                    $product_expdate = new DateTime($product['expdate']);
                    $current_date = new DateTime($now);

                    if ($product_expdate < $current_date) {
                        echo "<span style='color:red'>Expired</span>";
                    }
                    ?>
                </div>
                <div class="edit">
                    <a class="button" href="proEdit.php?id=<?=$product['id']?>" title="edit">Edit</a>
                    <a class="button" href="?delete=<?=$product['id']?>" title="delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (!empty($error)): ?>
        <p class="error"><?=join("<br><br>", $error)?></p>
    <?php endif; ?>
</body>
</html>
