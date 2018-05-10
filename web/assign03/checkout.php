<?php
session_start();
if(isset($_SESSION["counter"]))
{
$_SESSION["counter"]++;
}
else 
{
$_SESSION["counter"] = 1;
}

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
        <p>You have visted this page 
            <?php 
            echo $_SESSION["counter"];
            ?>
            times<p> 
    </body>
</html>
