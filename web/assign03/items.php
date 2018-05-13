<?php
session_start();


$_SESSION["cart"] = array();


array_push($_SESSION["cart"], "item");

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">
     <script>
         function addToCart() {
            
         }
     </script>
    <title>Items for sale</title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>
    
    <h1>Berries for sale!</h1>
    <ul>
        <li><button onclick="addToCart()">Add to Cart</button> Strawberries</li>
        <li><button onclick="addToCart()">Add to Cart</button>Blueberries</li>
    </ul> 
    </body>
</html>
