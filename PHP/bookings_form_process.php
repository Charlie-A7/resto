<?php

session_start();
include 'db_connection.php';

date_default_timezone_set('Asia/Beirut');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $customer_id = $_SESSION['userid'];
    $restaurant_id = $_POST['restaurant_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $num_people = $_POST['num_people'];
    $message = $_POST['message'];
    $total_price = $_POST['total_amount'];

    // Insert into bookings table
    $sql_booking = "INSERT INTO bookings (restaurant_id, customer_id, booking_date, booking_time, number_of_people, message, total_price)
                    VALUES ('$restaurant_id', '$customer_id', '$booking_date', '$booking_time', '$num_people', '$message', '$total_price')";

    if ($conn->query($sql_booking) === TRUE) {
        $booking_id = $conn->insert_id; // Get the ID of the inserted booking
    } else {
        echo "Error: " . $sql_booking . "<br>" . $conn->error;
    }

    // Handle preordered starters
    $starter_ids = $_POST['starter_ids'];
    $starter_quantities = $_POST['starter_quantities'];

    // Insert into preordered_starters table
    for ($i = 0; $i < count($starter_ids); $i++) {
        $item_id = $starter_ids[$i];
        $quantity = $starter_quantities[$i];

        if ($quantity > 0) {
            $sql_preordered = "INSERT INTO preordered_starters (booking_id, item_id, quantity)
                               VALUES ('$booking_id', '$item_id', '$quantity')";

            if ($conn->query($sql_preordered) !== TRUE) {
                echo "Error: " . $sql_preordered . "<br>" . $conn->error;
            }
        }
    }

    header("Location: http://localhost/resto/PHP/bookings.php");

    $conn->close();
}
?>