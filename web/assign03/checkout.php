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

        <form method="post" action="confirmation.php">
       <p>Street:     <input type="text" class="input" id="street"><br></p>
       <p>City:       <input type="text" class="input" id="city"><br></p>
       <p>State:      <input type="text" class="input" id="state"><br></p>
       <p>Zip Code:   <input type="text" class="input" id="zip"><br></p>

     <input type='submit' value='Purchase Items' class='checkout'>
     </form>
    </body>
</html>
