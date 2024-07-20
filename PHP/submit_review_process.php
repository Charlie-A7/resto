<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $rating = (int) $_POST['rating']; // Ensure rating is an integer
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Insert review into the reviews table
    $insertReviewQuery = "INSERT INTO reviews (booking_id, rating, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertReviewQuery);
    $stmt->bind_param('iis', $booking_id, $rating, $comment);

    if ($stmt->execute()) {
        // Get the restaurant ID associated with the booking
        $getRestaurantIdQuery = "SELECT restaurant_id FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($getRestaurantIdQuery);
        $stmt->bind_param('i', $booking_id);
        $stmt->execute();
        $stmt->bind_result($restaurant_id);
        $stmt->fetch();
        $stmt->close();

        // Calculate the average rating for the restaurant and round it to the nearest integer
        $calculateAverageRatingQuery = "SELECT ROUND(AVG(rating)) AS avg_rating FROM reviews WHERE booking_id IN (SELECT id FROM bookings WHERE restaurant_id = ?)";
        $stmt = $conn->prepare($calculateAverageRatingQuery);
        $stmt->bind_param('i', $restaurant_id);
        $stmt->execute();
        $stmt->bind_result($avg_rating);
        $stmt->fetch();
        $stmt->close();

        // Update the restaurant rating in the restaurants table
        $updateRestaurantRatingQuery = "UPDATE restaurants SET rating = ? WHERE id = ?";
        $stmt = $conn->prepare($updateRestaurantRatingQuery);
        $stmt->bind_param('ii', $avg_rating, $restaurant_id); // Ensure the rating and restaurant ID are integers

        if ($stmt->execute()) {
            header("Location: http://localhost/resto/PHP/bookings.php");
            $conn->close();
            exit();
        } else {
            echo "Error updating restaurant rating: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error submitting rating and comment: " . $conn->error;
    }

    $conn->close();
}
?>