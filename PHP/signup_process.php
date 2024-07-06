<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username exists
    $userCheckQuery = "SELECT * FROM users WHERE username = '$user'";
    $userCheckResult = $conn->query($userCheckQuery);

    // Check if email exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if ($userCheckResult->num_rows > 0) {
        header("Location: http://localhost/resto/PHP/login.php?usernameErrorSignUp=Username already exists.");
        $conn->close();
        exit();

    } elseif ($emailCheckResult->num_rows > 0) {
        header("Location: http://localhost/resto/PHP/login.php?EmailErrorSignUp=Email already in use.");
        $conn->close();
        exit();

    } else {
        $sql = "INSERT INTO users (username, phone, email, password) VALUES ('$user', '$phone', '$email', '$pass')";
        if ($conn->query($sql) === TRUE) {
            session_start();

            $last_id = $conn->insert_id;
            $_SESSION['userid'] = $last_id;
            $_SESSION['username'] = $user;

            header("Location: http://localhost/resto/PHP/index.php");
            $conn->close();
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>