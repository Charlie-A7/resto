<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_GET['id'];
    $customer_id = $_SESSION['userid'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $num_people = $_POST['num_people'];
    $message = $_POST['message'];

    $starters = $_POST['item']; // Array of item_id => quantity
    $total_price = $_POST['total_amount'];

    // Process booking and starter quantities
    foreach ($starters as $item_id => $quantity) {
        if ($quantity > 0) {
            // Process each starter item
            // Example: Insert into database or perform other actions
        }
    }

    // Continue with other booking process logic
}
?>