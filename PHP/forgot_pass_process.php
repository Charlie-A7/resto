<!-- <?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    } else {
        header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=Email Not Found.");
        $conn->close();
        exit();
    }
}
?> -->


<?php
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file here if not already included
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(16)); // Generate a random token

        // Update the token in the database for password reset
        $sql_update = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
        if ($conn->query($sql_update) === TRUE) {
            // Send email with password reset instructions
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; // SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'charlieaintablian@gmail.com'; // SMTP username
                $mail->Password = 'your_password'; // SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('your_email@example.com', 'Your Name');
                $mail->addAddress($email, $user['name']); // Add recipient email and name

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Instructions';
                $mail->Body = 'Please click the following link to reset your password: <a href="http://localhost/resto/PHP/resetPassword.php?token=' . $token . '">Reset Password</a>';

                $mail->send();
                echo 'Password reset instructions have been sent to your email.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $conn->close();
            exit();
        } else {
            // Error updating token in database
            header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=Error Updating Token.");
            $conn->close();
            exit();
        }
    } else {
        // Email not found in database
        header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=Email Not Found.");
        $conn->close();
        exit();
    }
}
?>