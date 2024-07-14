<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $sql = "SELECT id, username, email, password, user_type, restaurant_id FROM users WHERE TRIM(username)='$user' OR TRIM(email)='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['user_type'] == 'owner') {
            // For restaurant owners, passwords are unhashed
            if (password_verify($pass, $row['password'])) {
                session_start();
                $_SESSION['userid'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['restaurant_id'] = $row['restaurant_id'];
                header("Location: http://localhost/resto/PHP/restaurant_owner_homepage.php");
                $conn->close();
                exit();
            } else {
                header("Location: http://localhost/resto/PHP/login.php?passwordError=Invalid password.");
                $conn->close();
                exit();
            }
        } else {
            // For customers, passwords are hashed
            if (password_verify($pass, $row['password'])) {
                session_start();
                $_SESSION['userid'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];
                header("Location: http://localhost/resto/PHP/index.php");
                $conn->close();
                exit();
            } else {
                header("Location: http://localhost/resto/PHP/login.php?passwordError=Invalid password.");
                $conn->close();
                exit();
            }
        }
    } else {
        header("Location: http://localhost/resto/PHP/login.php?usernameError=Invalid username.");
        $conn->close();
        exit();
    }
}
?>