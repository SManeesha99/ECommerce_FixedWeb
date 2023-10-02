<?php

include 'config.php';

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address"];
$city = $_POST["city"];
$pin = $_POST["pin"];
$email = $_POST["email"];
$pwd = $_POST["pwd"];

// Input validation: Allow only safe characters for each input field.
if (!preg_match('/^[A-Za-z\' -]+$/', $fname) ||
    !preg_match('/^[A-Za-z\' -]+$/', $lname) ||
    !preg_match('/^[A-Za-z0-9\s\']+$/i', $address) ||
    !preg_match('/^[A-Za-z\s\']+$/i', $city) ||
    !ctype_digit($pin) ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid input data.");
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
        echo 'Error inserting data.';
        echo '<br/>';
    }

    $stmt->close();
} else {
    echo 'Error preparing statement.';
    echo '<br/>';
}

header("location:login.php");
?>
