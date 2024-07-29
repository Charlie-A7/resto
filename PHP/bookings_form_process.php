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
    $user_message = $_POST['message'];
    $total_price = $_POST['total_amount'];

    // Insert into bookings table
    $sql_booking = "INSERT INTO bookings (restaurant_id, customer_id, booking_date, booking_time, number_of_people, message, total_price)
                    VALUES ('$restaurant_id', '$customer_id', '$booking_date', '$booking_time', '$num_people', '$user_message', '$total_price')";

    if ($conn->query($sql_booking) === TRUE) {
        $booking_id = $conn->insert_id; // Get the ID of the inserted booking
    } else {
        echo "Error: " . $sql_booking . "<br>" . $conn->error;
    }

    // Handle preordered starters
    $starter_ids = $_POST['starter_ids'];
    $starter_quantities = $_POST['starter_quantities'];
    $starters_details = "";

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

            $sql_starter_name = "SELECT item_name FROM menu WHERE item_id = '$item_id'";
            $result_starter_name = $conn->query($sql_starter_name);

            if ($result_starter_name->num_rows > 0) {
                $row_starter_name = $result_starter_name->fetch_assoc();
                $item_name = $row_starter_name['item_name'];
                $starters_details .= "$item_name (Quantity: $quantity)\n";
            }

        }
    }

    $starters_details = $starters_details ? $starters_details : "None";
    $user_message = $user_message ? $user_message : "None";
    // Retrieve restaurant owner's email
    $sql_owner = "SELECT u.email FROM users u
                JOIN restaurants r ON u.restaurant_id = r.id
                WHERE r.id = '$restaurant_id'";
    $result_owner = $conn->query($sql_owner);

    if ($result_owner->num_rows > 0) {
        $row_owner = $result_owner->fetch_assoc();
        $owner_email = 'charlieaintablian@gmail.com';//$row_owner['email'];

        // Prepare the email
        $to = $owner_email;
        $subject = 'New Booking Was Made';
        $message = "A new booking has been made for your restaurant.\n\n"
            . "Booking Details:\n"
            . "Date: $booking_date\n"
            . "Time: $booking_time\n"
            . "Number of People: $num_people\n"
            . "Message: $user_message\n"
            . "Total Price: $total_price$\n"
            . "Preordered Starters:\n"
            . "$starters_details";
        $headers = 'From: charlieaintablian@gmail.com';

        // Send the email
        if (mail($to, $subject, $message, $headers)) {
        } else {
            echo 'Failed to send email.';
        }
    } else {
        echo "Error: Unable to find the restaurant owner's email.";
    }

    header("Location: http://localhost/resto/PHP/bookings.php");

    $conn->close();
}
?>