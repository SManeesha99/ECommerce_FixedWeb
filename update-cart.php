<?php
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

include 'config.php';

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

if ($product_id === false || $action === null) {
    die("Invalid input data.");
}

if ($action === 'empty') {
    unset($_SESSION['cart']);
}

$result = $mysqli->query("SELECT qty FROM products WHERE id = " . $product_id);

if ($result) {
    if ($obj = $result->fetch_object()) {
        switch ($action) {
            case "add":
                if ($_SESSION['cart'][$product_id] + 1 <= $obj->qty) {
                    $_SESSION['cart'][$product_id]++;
                }
                break;

            case "remove":
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] == 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
        }
    }
}

header("location:cart.php");
?>
