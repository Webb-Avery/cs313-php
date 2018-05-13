<?php

session_start();

$action = htmlspecialchars($_GET['action']);

if ($action === "add") {
    $item = htmlspecialchars($_GET['item']);
    array_push($_SESSION['cart'], $item);
    
    $price = htmlspecialchars($_GET['price']);
    array_push($_SESSION['price'], $price);
}
elseif ($action === "remove") {
    $item = htmlspecialchars($_GET['item']);
    unset($_SESSION['cart'][$item]);
    unset($_SESSION['price'][$item]);
    
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    $_SESSION['price'] = array_values($_SESSION['price']);
}
?>