<?php
session_start();

date_default_timezone_set('Asia/Beirut');

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique reset key
        $reset_key = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insert the reset key into the database
        $sql = "INSERT INTO password_resets (email, reset_key, expires) VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE reset_key = ?, expires = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $email, $reset_key, $expires, $reset_key, $expires);
        $stmt->execute();

        // Prepare the email
        $subject = "Password Reset Request";// Format the expiration date
        $formatted_expires = date('l, F j, Y g:i A', strtotime($expires));
        
        // Update the email message to include the expiration date
        $email_message = "You requested a password reset. Use the key below to reset your password:\n\n" . 
                         "Reset Key: " . $reset_key . "\n" .
                         "This key will expire on: " . $formatted_expires . "\n\n" . 
                         "Please use the key to reset your password within the given time frame.";
        
        $headers = 'From: charlieaintablian@gmail.com';

        // Send the email
        if (mail($email, $subject, $email_message, $headers)) {
            header("Location: http://localhost/resto/PHP/confirm_pass_reset.php");
        } else {
            header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=" . urlencode("Failed to send reset link. Please try again."));
        }

    } else {
        header("Location: http://localhost/resto/PHP/forgotPass.php?forgotPass=" . urlencode("Email Not Found."));
    }

    $conn->close();
}
?>