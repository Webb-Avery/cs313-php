<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">

     <script>
        function removeFromCart(index, price) {
            document.getElementById(index).style.display = 'none';
            var total = document.getElementById("total").innerText;
            total -= price;
            document.getElementById("total").innerHTML = total;
    
            var httpRequest = new XMLHttpRequest();
            httpRequest.open("GET", "cart.php?action=remove&item=" + index, true);
            httpRequest.send();
    }
    </script>
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
        echo "<li id='$index'><button type='button' class='button' onclick='removeFromCart($index, " . $_SESSION['price'][$index] . ")'>Remove from Cart</button>$item</li><br>";
        $index++;
    }
    ?>
    <ul>

 <?php
    $total = 0;
    foreach ($_SESSION['price'] as $price) {
        $total += $price;
    }
    echo "<p id='total'>Total:  $" . $total;
    ?>
</p>
 <a href='checkout.php' class="checkout" >Checkout Items </a>
    </body>
</html>
