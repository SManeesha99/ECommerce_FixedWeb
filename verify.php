<?php
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

include 'config.php';

$username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_EMAIL);
$password = $_POST["pwd"];

if ($username === false || empty($password)) {
    // Handle invalid input data gracefully, e.g., redirect to an error page
    redirectWithError("Invalid input data.");
}

// Use a prepared statement to prevent SQL injection.
$stmt = $mysqli->prepare("SELECT id, email, password, fname, type FROM users WHERE email = ?");

if ($stmt) {
    // Bind parameters.
    $stmt->bind_param("s", $username);
    
    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $email, $hashedPwd, $fname, $type);
            $stmt->fetch();

            if (password_verify($password, $hashedPwd)) {
                // Authentication successful
                $_SESSION['username'] = $email;
                $_SESSION['type'] = $type;
                $_SESSION['id'] = $id;
                $_SESSION['fname'] = $fname;
                header("location:index.php");
            } else {
                // Password doesn't match
                redirectWithError("Invalid login credentials.");
            }
        } else {
            // User not found
            redirectWithError("User not found.");
        }
    } else {
        // Handle database query error gracefully, e.g., log the error
        redirectWithError("Database query error.");
    }

    $stmt->close();
}

function redirectWithError($errorMessage) {
    $_SESSION['error_message'] = $errorMessage;
    header("location:error.php");
    exit;
}
?>
