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
         function addToCart(item, price) {
            var httpRequest = new XMLHttpRequest();
            httpRequest.open("GET", "cart.php?action=add&item=" + item + "&price=" + price, true);
            httpRequest.send();
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
        <li><button onclick="addToCart('Strawberries', 5)">Add to Cart</button> Strawberries, $5</li>
        <li><button onclick="addToCart('blueberries', 4)">Add to Cart</button>Blueberries, $4</li>
    </ul> 
    </body>
</html>
