<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            if (isset($_SESSION['reset_email'])) {
                $email = $_SESSION['reset_email'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";

                if ($conn->query($sql) === TRUE) {
                    echo "Password updated successfully.";
                    // You can redirect the user to a success page or login page
                    header("Location: http://localhost/resto/PHP/password_reset_success_fail.php?password_reset_success_fail_message=Password Reset was a Success!");
                    exit();
                } else {
                    //error updating pass
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "Email not found in session.";
            }
        } else {
            //passwords do not match
            header("Location: http://localhost/resto/PHP/confirm_pass_reset.php?confirm_pass_reset_message=Passwords do not match");
        }
    }
    $conn->close();
}
?>