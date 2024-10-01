<?php
session_start();
require "db.php";
$_SESSION['purchase_success'] = false;
// Initialize search variable
$search = $_POST['search'] ?? $_GET['search'] ?? "";
$cnt = $_SESSION['cnt'] ?? 0;

// Check if the user is authenticated
if (!isAuthenticated()) {
    header("Location: custLog.php");
    exit;
}



$now = date('Y-m-d');
$current_date = new DateTime($now);

$user = $_SESSION["user"];
$page = $_GET["page"] ?? 1;
$add = $_GET["id"] ?? -1;
$cartProducts = [];

$allCart = $_SESSION["cart"] ?? [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page = 1;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $cartProduct = getProductByID($add);
    $cnt++;
    if (empty($allCart[$add])) {
        $allCart[$add] = [
            'product' => $cartProduct,
            'quantity' => 1
        ];
    } else if ($allCart[$add]["quantity"] < $cartProduct["stock"]){
        $allCart[$add]["quantity"]++;
        
    } else {
        $cnt--;
        $limit = true;
    }
    $_SESSION["cart"] = $allCart;
    $_SESSION['cnt'] = $cnt;
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?') . "?page=$page");
    exit;
}

$products = getAllProducts();
$filtered = [];
$dis = [];
$city = [];

foreach ($products as $p) {
    $product_expdate = new DateTime($p['expdate']);
    if ($product_expdate > $current_date && $p["stock"] != 0) {
        $market = getAdminByMail($p["market_email"]);
        if ($market["district"] === $user["district"]) {
            array_push($dis, $p);
        } else if ($market["city"] === $user["city"]) {
            array_push($city, $p);
        }
    } 
}


$filtered = array_merge($dis, $city);

$textfiltered = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        /* General styles for the main container */
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


        .profile {
            width: 100px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-info table {
            width: 100%;
        }

        .profile-info table td {
            padding: 10px;
        }

        .profile-info .info {
            font-weight: bold;
        }

        .profile-info a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .error {
            color: red;
            font-style: italic;
        }

        .protable {
            margin: 0 auto;
            width: 98%;
            border-collapse: collapse;
        }

        .protable th,
        .protable td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .protable th {
            background-color: #f2f2f2;
        }

        .protable tr:hover {
            background-color: #f9f9f9;
        }

        .pages {
            text-align: center;
            margin-top: 20px;
        }

        .pageNo {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .pageNo.active {
            background-color: #ccc;
            color: #fff;
        }

        .old-price {
            text-decoration: line-through;
            color: red;
        }

        .product-image {
            width: 100px;
            height: auto;
        }
    .inputsrch {
        margin: 20px;
        margin-right: 3px;
        margin-top: 0px;
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
        font-size: 16px;
    }
    .srch {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-left: none;
        border-radius: 0 5px 5px 0;
        background-color: #007BFF;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .srch:hover {
        background-color: #0056b3;
    }
    a.cartcls {
    text-decoration: none;
}

a.cartclsdis button {
    margin-left: 20px;
    position: relative;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
}

a.cartcls button {
    margin-left: 20px;
    position: relative;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
}

a.cartcls button:hover {
    background-color: #0056b3;
}

.cart-icon {
    position: relative;
    margin-right: 10px;
    font-size: 18px;
}

.cart-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    font-weight: bold;
}
.button-container {
    text-align: center;
}

.button-container a {
    text-decoration: none;
}

.button-container button[type='submit'] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button-container button[type='submit']:hover {
    background-color: #0056b3;
}
.addTd {
    width: 130px;
}
.protable th,td {text-align: center;}
    </style>
</head>
<body>
   
<div class="main">
    <h1>Welcome to Profile Page</h1>
    <table>
        <tr>
        <tr>
            <td><i class="fas fa-envelope"></i> <span class="info"><?= htmlspecialchars($user["email"]) ?></span></td>
            <td><i class="fas fa-user"></i> <span class="info"><?= htmlspecialchars($user["username"]) ?></span></td>
            <td><i class="fas fa-city"></i> <span class="info"><?= htmlspecialchars($user["city"]) ?></span></td>
            <td><i class="fas fa-map-marker-alt"></i> <span class="info"><?= htmlspecialchars($user["district"]) ?></span></td>
            <td><i class="fas fa-home"></i> <span class="info"><?= htmlspecialchars($user["address"]) ?></span></td>
        </tr>
        </tr>
    </table>
    <div>
    <a href="custEdit.php"><button><i class="fa fa-edit"></i> Edit Profile</button></a>
        <a href="custLogout.php"><button><i class="fa fa-door-open"></i> Logout</button></a>
    </div>
</div>



<h1>List of Products</h1>
<form action="" method="post">
    <div>
        <input type="text" class="inputsrch" name="search" value="<?= htmlspecialchars($search) ?>" required>
        <button type="submit" class="srch">Search</button>
    </div>
    <?php
      if (isset($limit)) {
         echo "<p class='error'>You reached the limit for this product.</p>";
      }
    ?>
    
</form>



<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" || strlen(trim($search)) !== 0) {
    
    $escapedSearch = preg_quote($search, '/');
    $searchPattern = "/$escapedSearch/i";

    foreach ($filtered as $p) {
        if (preg_match($searchPattern, $p["title"])) {
            array_push($textfiltered, $p);
        }
    }

    $size = count($textfiltered) / 4;
    $size = ceil($size);
    $itemsPerPage = 4;

    $offset = ($page - 1) * $itemsPerPage;
    $pagefiltered = array_slice($textfiltered, $offset, $itemsPerPage);

    if (empty($pagefiltered)) {
        echo "<p class='error'>No product is found.</p>";
    } else {
        echo "<table class='protable'>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Price</th>";
        echo "<th>Stock</th>";
        echo "<th>Expiration Date</th>";
        echo "<th>Market Name</th>";
        echo "<th>Image</th>";
        echo "</tr>";

        foreach ($pagefiltered as $p) {
            $status = true;
            if ($p["price"] != $p["discounted_price"]) {
                $status = false;
            }
            $market = getAdminByMail($p["market_email"]);
            echo "<tr>";
            echo "<td>", htmlspecialchars($p["title"]), "</td>";
            echo "<td>";
            if ($status == true) {
                echo htmlspecialchars($p["price"]);
            } else {
                echo "<span class='old-price'>", htmlspecialchars($p["price"]), "₺</span><br>", htmlspecialchars($p["discounted_price"]);
            }
            echo "₺</td>";
            echo "<td>", htmlspecialchars($p["stock"]), "</td>";
            echo "<td>", htmlspecialchars($p["expdate"]), "</td>";
            echo "<td class = 'market'>" , htmlspecialchars($market["market_name"]), "<br>(", htmlspecialchars($market["city"]),",", htmlspecialchars($market["district"]),")</td>";
            echo "<td><img class='product-image' src='images/", htmlspecialchars($p['path']), "'></td>";
            echo "<td class='addTd'>";
            echo "<div class='button-container'>";
            echo "<a href='?page=", $page, "&id=", htmlspecialchars($p["id"]), "'><button type='submit'>Add to Cart</button></a>";
            echo "</div>";
            echo "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
}
else{
    $size = count($filtered) / 4;
    $size = ceil($size);
    $itemsPerPage = 4;

    $offset = ($page - 1) * $itemsPerPage;
    $pagefiltered = array_slice($filtered, $offset, $itemsPerPage);
   
    if (empty($pagefiltered)) {
        echo "<p class='error'>No product is found.</p>";
    } else {
        echo "<table class='protable'>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Price</th>";
        echo "<th>Stock</th>";
        echo "<th>Expiration Date</th>";
        echo "<th>Market Name</th>";
        echo "<th>Image</th>";
        echo "</tr>";

        foreach ($pagefiltered as $p) {
            $status = true;
            if ($p["price"] != $p["discounted_price"]) {
                $status = false;
            }
            $market = getAdminByMail($p["market_email"]);
            echo "<tr>";
            echo "<td>", htmlspecialchars($p["title"]), "</td>";
            echo "<td>";
            if ($status == true) {
                echo htmlspecialchars($p["price"]);
            } else {
                echo "<span class='old-price'>", htmlspecialchars($p["price"]), "₺</span><br>", htmlspecialchars($p["discounted_price"]);
            }
            echo "₺</td>";
            echo "<td>", htmlspecialchars($p["stock"]), "</td>";
            echo "<td>", htmlspecialchars($p["expdate"]), "</td>";
            echo "<td class = 'market'>" , htmlspecialchars($market["market_name"]), "<br>(", htmlspecialchars($market["city"]),",", htmlspecialchars($market["district"]),")</td>";
            echo "<td><img class='product-image' src='images/", htmlspecialchars($p['path']), "'></td>";
            echo "<td class='addTd'>";
            echo "<div class='button-container'>";
            echo "<a href='?page=", $page, "&id=", htmlspecialchars($p["id"]), "'><button type='submit'>Add to Cart</button></a>";
            echo "</div>";
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";

}
}
$_SESSION['cnt'] = $cnt;
?>

<?php if (!empty($textfiltered)): ?>
    <div class="pages">
        <?php for ($p = 1; $p <= $size; $p++): ?>
            <a class="<?= ($page == $p) ? 'pageNo active' : 'pageNo' ?>" href="?page=<?= $p ?>&search=<?= urlencode($search) ?>"><?= $p ?></a>
        <?php endfor; ?>
    </div>
<?php elseif (!empty($filtered)): ?>
   
    <div class="pages">
        <?php for ($p = 1; $p <= $size; $p++): ?>
            <a class="<?= ($page == $p) ? 'pageNo active' : 'pageNo' ?>" href="?page=<?= $p ?>"><?= $p ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION["cart"])): ?>
    <a href="custCart.php" class="cartcls">
        <button>
            <span class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count"><?= $cnt ?></span>
            </span>
            Go to Cart
        </button>
    </a>
<?php else: ?>
    <a class="cartclsdis">
        <button disabled>
            <span class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count">0</span>
            </span>
            Go to Cart
        </button>
    </a>
<?php endif; ?>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
