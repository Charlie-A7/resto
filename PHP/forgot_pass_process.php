<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: http://localhost/resto/PHP/confirm_pass_reset.php");
    } else {
        header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=Email Not Found.");
        exit();
    }

    $conn->close();
}
?>