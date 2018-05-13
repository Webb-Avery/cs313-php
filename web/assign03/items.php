<?php
session_start();

if(!isset($_SESSION['cart']])){
    $_SESSION["cart"] = array();
    $_SESSION["price"] = array();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">
     <script>
         function addToCart(item, price) {
            var httpRequest = new XMLHttpRequest();
            httpRequest.open("GET", "cartEdit.php?action=add&item=" + item + "&price=" + price, true);
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
        <li><button onclick="addToCart('Strawberries', 5)">Add to Cart</button> Strawberries, $5.00</li>
        <li><button onclick="addToCart('blueberries', 4)">Add to Cart</button>Blueberries, $4</li>
    </ul> 
    </body>
</html>
