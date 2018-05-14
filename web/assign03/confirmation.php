<?php
session_start();

$checkout = htmlspecialchars($_POST['checkout']);
?>

$street = htmlspecialchars($_POST['street']);
$city = htmlspecialchars($_POST['city']); 
$state = htmlspecialchars($_POST['state']);
$zip = htmlspecialchars($_POST['zip']);


<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="assign03.css">
    <title>Confirmation Page</title>
</head>

<body>
    <header id="top"> 
    <?php include 'nav.php'; ?>
    </header>
        <h2>Thank you for your purchase!</h2>

        <p>We are sending the following items to you!</p>
        <ul>
        <?php
        foreach ($_SESSION['cart'] as $item) {
            echo "<li>$item</li>";
        }
        ?>
        </ul>
        <p>We are shipping your purchase to 
        <?php 
        echo $street . "," . $city . "," . $state . "," . $zip;
        ?>
        </p>


    </body>
</html>
