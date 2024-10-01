<?php

const DSN = "mysql:host=localhost;dbname=test;charset=utf8mb4" ;
const USER = "root" ;
const PASSWORD = "" ;

try {
   $db = new PDO(DSN, USER, PASSWORD) ; 
} catch(PDOException $e) {
     echo "Set username and password in 'db.php' appropriately" ;
     exit ;
}

function checkUser($email, $pass, &$user) {
    global $db ;

    $stmt = $db->prepare("select * from users where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;    

    if ( $user) {
        return password_verify($pass, $user["password"]) ;
    }
    return false ;
}

function doUserExist($email) {
    global $db ;

    $stmt = $db->prepare("select * from users where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;    

    if ($user) {
        return true ;
    }
    return false ;
}

function doAdminExist($email) {
    global $db ;

    $stmt = $db->prepare("select * from admin where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;    

    if ($user) {
        return true ;
    }
    return false ;
}

function checkAdmin($email, $pass, &$admin) {
    global $db ;

    $stmt = $db->prepare("select * from admin where email=?") ;
    $stmt->execute([$email]) ;
    $admin = $stmt->fetch() ;
    
    if ( $admin) {
        return password_verify($pass, $admin["password"]) ;
    }
    return false ;
}

function checkUserPassword($email, $pass) {
    global $db ;

    $stmt = $db->prepare("select * from users where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;
    
    return password_verify($pass, $user["password"]) ;
}

function checkAdminPassword($email, $pass) {
    global $db ;

    $stmt = $db->prepare("select * from admin where email=?") ;
    $stmt->execute([$email]) ;
    $admin = $stmt->fetch() ;
    
    return password_verify($pass, $admin["password"]) ;
}

function admin_register($email,$username,$password,$city,$district,$address){
    $hash = password_hash($password, PASSWORD_BCRYPT) ;
    global $db ;
    $stmt = $db->prepare("INSERT INTO admin VALUES (?, ?, ?, ?, ?, ?, NULL);") ;
    $stmt->execute([$email,$username,$hash,$city,$district,$address]);
}

function user_register($email, $username, $password,$city,$district,$address){
    $hash = password_hash($password, PASSWORD_BCRYPT) ; 
    global $db ;
    $stmt = $db->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, NULL);") ;
    $stmt->execute([$email,$username,$hash,$city,$district,$address]);
   
}

function isAuthenticated() {
    return isset($_SESSION["user"]) ;
}

function isAuthenticatedAdmin() {
    return isset($_SESSION["admin"]) ;
}

function getAdminByMail($email) {
    global $db ;
    $stmt = $db->prepare("select * from admin where email = ?") ;
    $stmt->execute([$email]) ;
    return $stmt->fetch() ;
 }


 function getUserByToken($token) {
   global $db ;
   $stmt = $db->prepare("select * from users where remember = ?") ;
   $stmt->execute([$token]) ;
   return $stmt->fetch() ;
}

function getAdminByToken($token) {
    global $db ;
    $stmt = $db->prepare("select * from admin where remember = ?") ;
    $stmt->execute([$token]) ;
    return $stmt->fetch() ;
 }

 function setTokenByEmail($email, $token) {
   global $db ;
   $stmt = $db->prepare("update users set remember = ? where email = ?") ;
   $stmt->execute([$token, $email]) ;
}

function setTokenByEmailAdmin($email, $token) {
    global $db ;
    $stmt = $db->prepare("update admin set remember = ? where email = ?") ;
    $stmt->execute([$token, $email]) ;
}

function setAdminPassword($user, $newPass){
    global $db ;
    $hash = password_hash($newPass, PASSWORD_BCRYPT) ; 
    $email = $user["email"];
    $stmt = $db->prepare("update admin set password = ? where email = ?") ;
    $stmt->execute([$hash, $email]);
}

function setUserPassword($user, $newPass){
    global $db ;
    $hash = password_hash($newPass, PASSWORD_BCRYPT) ; 
    $email = $user["email"];
    $stmt = $db->prepare("update users set password = ? where email = ?") ;
    $stmt->execute([$hash, $email]);
}

function getAdminPassword($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT password FROM admin WHERE email = ?;") ;
    $stmt->execute([$email]);
    return $stmt->fetch() ;
}

function getUserPassword($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT password FROM users WHERE email = ?;") ;
    $stmt->execute([$email]);
    return $stmt->fetch() ;
}

function getAllProducts(){
    global $db;
    $stmt = $db->prepare("SELECT * FROM products") ;
    $stmt->execute() ;
    return $stmt->fetchAll();
}

function getAdminProducts($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT * FROM products WHERE market_email = ?") ;
    $stmt->execute([$email]);
    return $stmt->fetchAll() ;
}

function updateAdmin($email, $market_name, $city, $district, $address){
    
    global $db ;
    $stmt = $db->prepare("UPDATE admin set market_name = ?, city=?, district=?, address=? where email = ?") ;
    $stmt->execute([$market_name,$city,$district,$address,$email]);
}

function updateUser($email, $username, $city, $district, $address){
    
    global $db ;
    $stmt = $db->prepare("UPDATE users set username = ?, city=?, district=?, address=? where email = ?") ;
    $stmt->execute([$username,$city,$district,$address,$email]);
}

function updateProduct($id, $title, $stock, $price,$discounted_price, $expdate, $path){
    global $db ;
    $stmt = $db->prepare(
    "UPDATE products 
    SET 
        title = ?,
        stock = ?, 
        price = ?, 
        discounted_price = ?,
        expdate = ?,
        path =?
    WHERE products.id = ?");

    $stmt->execute([$title, $stock, $price,$discounted_price, $expdate, $path, $id]);
}

function getProductByID($id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM products where id =?;") ;
    $stmt->execute([$id]);
    return $stmt->fetch() ;
}

function createProduct($market_email, $title, $stock, $price,$discounted_price, $expdate, $path){
    global $db;
    $stmt = $db->prepare("insert into products (market_email, title, stock, price, discounted_price, expdate, path)
     values(?,?,?,?,?,?,?)");
     $stmt->execute([$market_email, $title, $stock, $price, $discounted_price, $expdate, $path]);
}

function getMarketProducts($user){
    global $db;
    $email = $user["email"];
    $stmt = $db->prepare("SELECT * FROM products WHERE market_email = ? order by expdate") ;
    $stmt->execute([$email]);
    return $stmt->fetchAll() ;
}

function buyProduct($cart) {
    $id = $cart["product"]["id"];
    $quan = $cart["quantity"];
    $product = getProductByID($id);
    global $db ;
    
    if ($quan == $product["stock"]) {
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    } else {
    $newStock = $product["stock"] - $quan;    
    $stmt = $db->prepare(
    "UPDATE products 
    SET 
        stock = ? 
    WHERE products.id = ?");
    $stmt->execute([$newStock ,$id]);
    }   
}