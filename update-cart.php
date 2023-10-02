<?php
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

include 'config.php';

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Check if product_id and action are valid
if ($product_id === false || $action === null) {
    // Handle invalid input gracefully, e.g., redirect to an error page
    header("location:error.php");
    exit; // Terminate the script
}

$result = $mysqli->query("SELECT qty FROM products WHERE id = " . $product_id);

if ($result) {
    if ($obj = $result->fetch_object()) {
        switch ($action) {
            case "add":
                if ($_SESSION['cart'][$product_id] + 1 <= $obj->qty) {
                    $_SESSION['cart'][$product_id]++;
                } else {
                    // Handle the case when the product quantity is insufficient
                    header("location:insufficient_quantity.php");
                    exit;
                }
                break;

            case "remove":
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] == 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;

            default:
                // Handle unknown action gracefully, e.g., redirect to an error page
                header("location:error.php");
                exit;
        }
    }
}

header("location:cart.php");
?>
