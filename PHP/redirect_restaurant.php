<?php
session_start();

if (isset($_GET['id']) && isset($_GET['page'])) {
    $_SESSION['restaurant_id'] = $_GET['id'];
    $page = $_GET['page'];
    header("Location: $page");
    exit();
} else {
    echo "Error: Missing parameters.";
}
?>