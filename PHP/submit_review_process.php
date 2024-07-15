<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    $sql = "INSERT INTO reviews (booking_id, rating, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('iis', $booking_id, $rating, $comment);

    if ($stmt->execute()) {
        header("Location: http://localhost/resto/PHP/bookings.php");
        $conn->close();
        exit();
    } else {
        echo "Error submitting rating and comment: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>