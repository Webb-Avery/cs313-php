<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">
    <title>Checkout </title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>
       <h2>Shipping Address</h2>

       Street:     <input type="text" class="input" id="street"><br>
       City:       <input type="text" class="input" id="city"><br>
       State:      <input type="text" class="input" id="state"><br>
       Zip Code:   <input type="text" class="input" id="zip"><br>

    </body>
</html>
