<?php
include 'db_connection.php';

$sqlSelect = "SELECT * FROM bookings WHERE status = 'pending'";
$result = $conn->query($sqlSelect);

// Get the current time
date_default_timezone_set('Asia/Beirut');
$currentDate = new DateTimeImmutable();

if ($result->num_rows > 0) {
    $idsToUpdate = []; // Array to hold IDs of bookings to be updated

    while ($row = $result->fetch_assoc()) {
        $bookingDate = new DateTime($row['booking_date']);
        $bookingTime = new DateTime($row['booking_time']);
        $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $bookingDate->format('Y-m-d') . ' ' . $bookingTime->format('H:i:s'));

        if ($bookingDateTime <= $currentDate) {
            // Collect IDs of bookings that need to be updated
            $idsToUpdate[] = $row['id'];
        }
    }

    if (!empty($idsToUpdate)) {
        // Update the status of pending bookings whose booking time has passed
        $idsToUpdateStr = implode(',', $idsToUpdate);
        $sqlUpdate = "UPDATE bookings 
            SET status = 'declined' 
            WHERE id IN ($idsToUpdateStr)";
        $conn->query($sqlUpdate);
    }
}

$conn->close();
?>