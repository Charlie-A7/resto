<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
} elseif (isset($_SESSION['userid']) && $_SESSION['user_type'] !== 'owner') {
    header("Location: http://localhost/resto/PHP/index.php");
    exit();
}

include 'update_booking_status.php';
include 'db_connection.php';
include 'header.php';


$pendingBookings = [];
$acceptedBookings = [];
$declinedBookings = [];

$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT b.id as booking_id, b.restaurant_id, b.customer_id, b.booking_date as date, 
                b.booking_time as time, b.number_of_people as nb_of_people, b.message, b.total_price as total, b.status FROM bookings b
            WHERE restaurant_id = $restaurantId
            ORDER BY b.booking_date DESC, b.booking_time DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'pending') {
            $pendingBookings[] = $row;
        } elseif ($row['status'] == 'accepted') {
            $acceptedBookings[] = $row;
        } elseif ($row['status'] == 'declined') {
            $declinedBookings[] = $row;
        }
    }

    function displayBooking($row, $conn, $status)
    {
        $customer_id = $row['customer_id'];
        $customer_sql = "SELECT username FROM users WHERE id = $customer_id";
        $customer_result = $conn->query($customer_sql);
        $customer_row = $customer_result->fetch_assoc();

        // format time
        $time = $row['time'];
        $dateTime = new DateTime($time);
        $formattedTime = $dateTime->format('h:i A');

        // format date
        $date = $row['date'];
        $dateTime = new DateTime($date);
        $formattedDate = $dateTime->format('l, F j, Y');

        $booking_id = $row['booking_id'];
        $starters_sql = "SELECT ps.quantity, m.item_name as starter_name
                             FROM preordered_starters ps
                             INNER JOIN menu m ON ps.item_id = m.item_id
                             WHERE ps.booking_id = $booking_id";
        $starters_result = $conn->query($starters_sql);
        ?>
        <div class="row m-3">
            <div class="col-12">
                <div class="card p-3">
                    <div class="booked-info">
                        <h3>Customer Username: <?php echo $customer_row['username'] ?></h3>
                        <h4>Date: <?php echo $formattedDate; ?></h4>
                        <h4>Time: <?php echo $formattedTime; ?></h4>
                        <h5>Number of people: <?php echo $row['nb_of_people']; ?></h5>
                        <p>Message: <?php echo ($row['message'] == '') ? 'None' : $row['message']; ?></p>
                        <h5>Pre-ordered Starters:</h5>
                        <?php
                        if ($starters_result->num_rows > 0) {
                            while ($starter_row = $starters_result->fetch_assoc()) {
                                ?>
                                <h6>•<?php echo $starter_row['starter_name']; ?> x<?php echo $starter_row['quantity']; ?></h6>
                                <?php
                            }
                        } else {
                            ?>
                            <h6>None</h6>
                            <?php
                        }
                        ?>
                        <h5>Total: <?php echo $row['total']; ?> $</h5>
                    </div>
                    <?php if ($status == 'accepted') { ?>
                        <h5 class="text-success">Accepted</h5>
                    <?php }
                    if ($status == 'declined') { ?>
                        <h5 class="text-danger">Declined</h5>
                    <?php }
                    if ($status == 'pending') { ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex justify-content-center">
                                    <form action="restaurant_owner_update_booking_status.php" method="POST">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <input type="hidden" name="new_status" value="accepted">
                                        <button type="submit" class="btn btn-success">Accept</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-center">
                                    <form action="restaurant_owner_update_booking_status.php" method="POST">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <input type="hidden" name="new_status" value="declined">
                                        <button type="submit" class="btn btn-danger">Decline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php }
} ?>



<?php
if (count($pendingBookings) > 0) {
    ?>
    <button class="btn btn-toggle btn-toggle-bookings my-3" onclick="togglePenidngBookings()">
        <h2 class="text-center m-0">Pending Bookings <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                height="24">
                <path d="M7 10l5 5 5-5z" />
            </svg></h2>
    </button>
    <div class="container my-3 shown-bookings" id="pending-bookings">
        <?php
        foreach ($pendingBookings as $row) {
            displayBooking($row, $conn, 'pending');
        }
        ?>
    </div>
<?php } ?>


<?php
if (count($acceptedBookings) > 0) {
    ?>
    <button class="btn btn-toggle btn-toggle-bookings my-3" onclick="toggleAcceptedBookings()">
        <h2 class="text-center m-0">Accepted Bookings <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                height="24">
                <path d="M7 10l5 5 5-5z" />
            </svg></h2>
    </button>
    <div class="container my-3 shown-bookings" id="accepted-bookings">
        <?php
        foreach ($acceptedBookings as $row) {
            displayBooking($row, $conn, 'accepted');
        }
        ?>
    </div>
<?php } ?>


<?php
if (count($declinedBookings) > 0) {
    ?>
    <button class="btn btn-toggle btn-toggle-bookings my-3" onclick="toggleDeclinedBookings()">
        <h2 class="text-center m-0">Declined Bookings <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                height="24">
                <path d="M7 10l5 5 5-5z" />
            </svg></h2>
    </button>

    <div class="container my-3 shown-bookings" id="declined-bookings">
        <?php
        foreach ($declinedBookings as $row) {
            displayBooking($row, $conn, 'declined');
        }
        ?>
    </div>
<?php } ?>


<script>

    document.querySelectorAll('.btn-toggle-bookings').forEach(button => {
        button.addEventListener('focus', event => {
            event.target.style.outline = 'none';
            event.target.style.border = 'none';
            event.target.style.boxShadow = 'none';
        });
    });

    function togglePenidngBookings() {
        const upcomingBookingsContainer = document.getElementById('pending-bookings');

        // Check if the container is currently hidden
        const isHidden = upcomingBookingsContainer.classList.contains('hidden-bookings');

        // Toggle classes based on current state
        if (isHidden) {
            upcomingBookingsContainer.classList.remove('hidden-bookings');
            upcomingBookingsContainer.classList.add('shown-bookings');
        } else {
            upcomingBookingsContainer.classList.remove('shown-bookings');
            upcomingBookingsContainer.classList.add('hidden-bookings');
        }
    }

    function toggleAcceptedBookings() {
        const pastBookingsContainer = document.getElementById('accepted-bookings');
        const isHidden = pastBookingsContainer.classList.contains('hidden-bookings');

        // Toggle classes based on current state
        if (isHidden) {
            pastBookingsContainer.classList.remove('hidden-bookings');
            pastBookingsContainer.classList.add('shown-bookings');
        } else {
            pastBookingsContainer.classList.remove('shown-bookings');
            pastBookingsContainer.classList.add('hidden-bookings');
        }
    }

    function toggleDeclinedBookings() {
        const pastBookingsContainer = document.getElementById('declined-bookings');
        const isHidden = pastBookingsContainer.classList.contains('hidden-bookings');

        // Toggle classes based on current state
        if (isHidden) {
            pastBookingsContainer.classList.remove('hidden-bookings');
            pastBookingsContainer.classList.add('shown-bookings');
        } else {
            pastBookingsContainer.classList.remove('shown-bookings');
            pastBookingsContainer.classList.add('hidden-bookings');
        }
    }
</script>

<?php
include 'footer.php';
?>