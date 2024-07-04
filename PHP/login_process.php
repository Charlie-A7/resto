<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            session_start();
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: http://localhost/Webproject/PHP/index.php");
            $conn->close();
            exit();
        } else {
            header("Location: http://localhost/Webproject/PHP/login.php?passwordError=Invalid password.");
            $conn->close();
            exit();
        }
    } else {
        header("Location: http://localhost/Webproject/PHP/login.php?usernameError=Invalid username.");
        $conn->close();
        exit();
    }
}
?>