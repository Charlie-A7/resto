<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['key'])) {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $key = $_POST['key'];

        if ($password === $confirm_password) {
            // Validate reset key and email
            $sql = "SELECT email FROM password_resets WHERE reset_key = ? AND expires > NOW()";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $key);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];

                // Hash the new password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Update the user's password
                $sql = "UPDATE users SET password = ? WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $hashed_password, $email);

                if ($stmt->execute()) {
                    // Delete the reset key after successful password reset
                    $sql = "DELETE FROM password_resets WHERE reset_key = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $key);
                    $stmt->execute();

                    header("Location: http://localhost/resto/PHP/password_reset_success_fail.php?password_reset_success_fail_message=" . urlencode("Password reset successful."));
                    exit();
                } else {
                    header("Location: http://localhost/resto/PHP/confirm_pass_reset.php?confirm_pass_reset_message=" . urlencode("Error updating password."));
                }
            } else {
                header("Location: http://localhost/resto/PHP/confirm_pass_reset.php?confirm_pass_reset_message=" . urlencode("Invalid or expired reset key."));
            }
        } else {
            header("Location: http://localhost/resto/PHP/confirm_pass_reset.php?confirm_pass_reset_message=" . urlencode("Passwords do not match."));
        }
    } else {
        header("Location: http://localhost/resto/PHP/confirm_pass_reset.php?confirm_pass_reset_message=" . urlencode("Missing fields."));
    }
    $conn->close();
}
?>