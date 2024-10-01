

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
            font-family: Arial, sans-serif;
        }
        h1{
            color: #257D90;
            font-family: arial;
        }
        .midBox {
            margin-left: 25%;
            width: 50%;
            padding-bottom: 30px;
            text-align: center;
            background-color: #FFF6DC;
            border-radius: 15px;
            margin-top: 10%;
        }
        .blob {
            position: absolute;
            width: 600px; /* Adjust blob size as needed */
            top: -100px; /* Adjust top position */
            left: -200px; /* Adjust left position */
            opacity: 0.5;
            z-index: -1;
           
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; /* Adjust margin as needed */
        }
        button {
            width: 150px; /* Adjust button width */
            height: 50px; /* Adjust button height */
            margin: 0 10px; /* Adjust margin between buttons */
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
            bottom: -400px; /* Adjust top position */
            right: 100px; /* Adjust left position */
            opacity: 0.5;
            z-index: -1;
    
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

.button:hover {
  background-color: #45a049;
}


    </style>
</head>
<body>
    <div class="main">
    <?php 
    include 'blob.php';
    require "db.php" ;
    ?>
        <div class="midBox">
            <h1>Select one</h1>
            <div class="button-container">
                <a href="custLog.php" class="button">Customer</a>
                <a href="admLog.php" class="button"> Market</a>
            </div>
        </div>   
        </div>   
        </div> 
       
    </div>
</body>
</html>
