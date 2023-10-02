<?php
include 'config.php';

$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$pin = filter_input(INPUT_POST, 'pin', FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd = $_POST["pwd"];

// Check if any input is invalid or empty
if (
    empty($fname) || empty($lname) || empty($address) ||
    empty($city) || $pin === false || $email === false
) {
    // Handle invalid input data gracefully, e.g., redirect to an error page
    header("location:error.php");
    exit;
}

// Hash the password securely before storing it.
$hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);

// Use prepared statements to prevent SQL injection.
$stmt = $mysqli->prepare("INSERT INTO users (fname, lname, address, city, pin, email, password) VALUES(?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
    // Bind parameters with types.
    $stmt->bind_param("ssssiss", $fname, $lname, $address, $city, $pin, $email, $hashedPwd);

    if ($stmt->execute()) {
        echo 'Data inserted';
        echo '<br/>';
    } else {
        // Handle database error gracefully, e.g., log the error
        header("location:error.php");
        exit;
    }

    $stmt->close();
} else {
    // Handle statement preparation error gracefully, e.g., log the error
    header("location:error.php");
    exit;
}

// Set the CSP and X-Frame-Options headers to protect against Clickjacking
header("Content-Security-Policy: frame-ancestors 'self';");
header("X-Frame-Options: DENY;");

header("location:login.php");
?>
