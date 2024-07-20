<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
} elseif (isset($_SESSION['userid']) && $_SESSION['user_type'] !== 'owner') {
    header("Location: http://localhost/resto/PHP/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $new_status = $_POST['new_status'];

    if (in_array($new_status, ['accepted', 'declined'])) {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $new_status, $booking_id);

        if ($stmt->execute()) {
            header("Location: http://localhost/resto/PHP/restaurant_owner_bookings.php");
            exit();
        } else {
            echo "Error updating booking status.";
        }
    } else {
        echo "Invalid status.";
    }
} else {
    echo "Invalid request.";
}
?>