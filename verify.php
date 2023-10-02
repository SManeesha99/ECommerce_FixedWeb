<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (session_id() == '' || !isset($_SESSION)) {
    session_start();
}

include 'config.php';

$username = $_POST["username"];
$password = $_POST["pwd"];
$flag = 'true';

// Use a prepared statement to prevent SQL injection.
$stmt = $mysqli->prepare("SELECT id, email, password, fname, type FROM users WHERE email = ? AND password = ?");

if ($stmt) {
    // Bind parameters.
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $email, $hashedPwd, $fname, $type);
            $stmt->fetch();

            $_SESSION['username'] = $email;
            $_SESSION['type'] = $type;
            $_SESSION['id'] = $id;
            $_SESSION['fname'] = $fname;
            header("location:index.php");
        } else {
            if ($flag === 'true') {
                redirect();
                $flag = 'false';
            }
        }
    } else {
        die("Database query error: " . $stmt->error);
    }

    $stmt->close();
}

function redirect() {
    echo '<h1>Invalid Login! Redirecting...</h1>';
    header("Refresh: 3; url=index.php");
}

?>
