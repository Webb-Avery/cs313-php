<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">
    <title>Shopping Cart</title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>
    <h2>Shopping Cart</h2>
    <ul> 
    <?php
    $index = 0;
    
    foreach ($_SESSION['cart'] as $item) {
        echo "<li id='$index'><button type='button' class='button' onclick='removeFromCart($index, " . $_SESSION['price'][$index] . ")'>Remove from Cart</button>$item</li>";
        $index++;
    }
    ?>
    <ul>

 <?php
    $total = 0;
    foreach ($_SESSION['price'] as $price) {
        $total += $price;
    }
    echo "</p>Total:  $" . $total ;
    ?>

 <a href='checkout.php'>Checkout</a>
    </body>
</html>
