
<?php
require "db.php" ;

//fetch all products 
$rs = $db->query("select * from products") ;
$products = $rs->fetchAll() ;

//insertion
if ( !empty($_POST)) {
    extract($_POST) ;
    if(isset($add )&& $add=='1')
    {
    // Validate all form data - this part is not implemented for the sake of simplicity
    $stmt = $db->prepare("INSERT INTO products (title, stock, price, discounted_price,expdate, path) VALUES (?,?,?,?,?,?)" ) ;
    $stmt->execute([$title, $stock, $price, $discounted_price, $expdate, $path]) ; 
    header("Location: add.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .main {
            display: flex;
            position: relative; /* Added position relative to .main */
            flex-wrap: wrap;
            gap: 20px; /* Space between product boxes */
            position: relative; /* Added position relative to .main */
            justify-content: center;
        }
        h1{
            color: #257D90;
            font-family: arial;
            font-size: 20px;
        }
        .product {
            width: 200px;
            padding: 10px 20px;
            text-align: center;
            background-color: #FFF6DC;
            border-radius: 15px;
            margin: 10px;
            border: 1px solid black;
        }
        .blob {
            position: absolute;
            width: 600px; /* Adjust blob size as needed */
            top: -100px; /* Adjust top position */
            left: -200px; /* Adjust left position */
            opacity: 0.5;
            z-index: -1;
           
        }
        
       
        .blob2{ 
            position: absolute;
            width: 400px; /* Adjust blob size as needed */
            top: 300px; /* Adjust top position */
            left: 200px; /* Adjust left position */
            opacity: 0.5;
            z-index: -1;
      
        
        }
        .blob3{
            position: absolute;
            width: 500px; /* Adjust blob size as needed */
            top: 100px; /* Adjust top position */
            left: 1000px; /* Adjust left position */
            opacity: 0.5;
            z-index: -1;
    
        }
       
      
  

/* Basic input styling */
input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    outline: none; /* Remove outline when focused */
    width: 120px;
}

/* Hover effect */
input[type="text"]:hover {
    border-color: #999;
}

/* Focus effect */
input[type="text"]:focus {
    border-color: #007bff; /* Change color on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
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
            color: white;
        }
.button[title="edit_user"] {
            background-color: #FF5733;
            color: white;
        }
.button[title="edit"] {
            background-color: #063EB8;
            color: white;
        }
.button[title="delete"] {
            background-color: #E10707;
            color: white;
        }
.product img {
            width: 150px; /* Make image fill the width of the product box */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px; /* Optional: to round image corners */
        }

.info{
    font-family: arial;
    
}
.add{
    font-family: arial;
    justify-content: center;
    text-align: center;
    margin: 20px;
}
.edit{
    display: flex;
}

    </style>
</head>
<body>
<form action="?" method="post">

<div class="add">

                <input type="text" name="title" placeholder="TITLE">
                <input type="text" name="stock" placeholder="STOCK">
                <input type="text" name="price" placeholder="PRICE">
                <input type="text" name="discounted_price" placeholder="DISCOUNTED PRICE">
                <input type="text" name="path" placeholder="PHOTO">

                <label for="expdate">expiration date</label>
                <input type="date" name="expdate">

                  <button type="submit" class="button" title="add">
                    add new product
                  </button>
                  <a href="admedit.php"><button type="submit" class="button" title="edit_user">
                    edit user info
                  </button></a>
    </div>
    <div class="main">
    <?php include 'blob.php'?>
   
    <?php foreach( $products as $product) : ?>
       <div class="product">
       <h1><?=$product['title'] ?></h1>
            <img src="images/<?=$product['path'] ?>" alt="">
            <div class="info">
                <p>stock: <?=$product['stock'] ?></p>
                <p>price: <?=$product['price'] ?></p>
                <p>discounted price: <span><?=$product['price'] ?></span></p>
                <p>expiration date: <?=$product['expdate'] ?></p>
            </div>
            <div class="edit">
            <button type="submit" class="button" title="edit"> edit product </button>
            <button type="submit" class="button" title="delete"> delete product </button>
            </div>
            

       </div> 
        <?php endforeach ?>  
       

    </div>
    </form>
</body>
</html>
