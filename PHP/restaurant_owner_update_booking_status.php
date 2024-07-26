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
            // Retrieve booking information and customer email
            $sql_booking_info = "SELECT b.booking_date, b.booking_time, b.number_of_people, b.message, b.total_price, u.email
                                 FROM bookings b
                                 JOIN users u ON b.customer_id = u.id
                                 WHERE b.id = ?";
            $stmt_booking_info = $conn->prepare($sql_booking_info);
            $stmt_booking_info->bind_param('i', $booking_id);
            $stmt_booking_info->execute();
            $result_booking_info = $stmt_booking_info->get_result();

            if ($result_booking_info->num_rows > 0) {
                $row_booking_info = $result_booking_info->fetch_assoc();
                $customer_email = 'charlieaintablian@gmail.com';//$row_booking_info['email'];
                $booking_date = $row_booking_info['booking_date'];
                $booking_time = $row_booking_info['booking_time'];
                $number_of_people = $row_booking_info['number_of_people'];
                $customer_message = $row_booking_info['message'];
                $total_price = $row_booking_info['total_price'];

                // Retrieve preordered starters information
                $sql_starters = "SELECT m.item_name, p.quantity
                                 FROM preordered_starters p
                                 JOIN menu m ON p.item_id = m.item_id
                                 WHERE p.booking_id = ?";
                $stmt_starters = $conn->prepare($sql_starters);
                $stmt_starters->bind_param('i', $booking_id);
                $stmt_starters->execute();
                $result_starters = $stmt_starters->get_result();

                $starters_details = "";
                while ($row_starters = $result_starters->fetch_assoc()) {
                    $starters_details .= $row_starters['item_name'] . " (Quantity: " . $row_starters['quantity'] . ")\n";
                }
                $starters_details = $starters_details ? $starters_details : "None";
                $customer_message = $customer_message ? $customer_message : "None";

                // Prepare the email
                $subject = "Booking Status Update: Your Booking is " . ucfirst($new_status);
                $email_message = "Your booking has been " . $new_status . ".\n\n"
                    . "Booking Details:\n"
                    . "Date: $booking_date\n"
                    . "Time: $booking_time\n"
                    . "Number of People: $number_of_people\n"
                    . "Message: $customer_message\n"
                    . "Total Price: $total_price$\n"
                    . "Preordered Starters:\n"
                    . "$starters_details";
                $headers = 'From: charlieaintablian@gmail.com';

                // Send the email
                if (mail($customer_email, $subject, $email_message, $headers)) {
                } else {
                    echo 'Failed to send email.';
                }
            } else {
                echo "Error: Booking not found.";
            }

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