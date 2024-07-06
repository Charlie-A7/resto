<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT id, username,email, password FROM users WHERE username='$user' OR email = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            session_start();
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: http://localhost/resto/PHP/index.php");
            $conn->close();
            exit();
        } else {
            header("Location: http://localhost/resto/PHP/login.php?passwordError=Invalid password.");
            $conn->close();
            exit();
        }
    } else {
        header("Location: http://localhost/resto/PHP/login.php?usernameError=Invalid username.");
        $conn->close();
        exit();
    }
}
?>