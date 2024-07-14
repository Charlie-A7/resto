<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
} elseif (isset($_SESSION['userid']) && $_SESSION['user_type'] !== 'customer') {
    header("Location: http://localhost/resto/PHP/restaurant_owner_homepage.php");
    exit();
}

include 'db_connection.php';
include 'header.php';
?>


<?php
$customer_id = $_SESSION['userid'];
$sql = "SELECT b.id as booking_id, b.restaurant_id, r.name as restaurant_name, b.customer_id, b.booking_date as date, 
                b.booking_time as time, b.number_of_people as nb_of_people, b.message, b.total_price as total, r.image_url as image
            FROM bookings b
            INNER JOIN restaurants r ON b.restaurant_id = r.id
            WHERE b.customer_id = $customer_id
            ORDER BY b.booking_date DESC, b.booking_time DESC";
$result = $conn->query($sql);
$pastBookings = [];
$futureBookings = [];
date_default_timezone_set('Asia/Beirut');
$currentDate = new DateTimeImmutable();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookingDate = new DateTime($row['date']);
        $bookingTime = new DateTime($row['time']);
        $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $bookingDate->format('Y-m-d') . ' ' . $bookingTime->format('H:i:s'));
        if ($bookingDateTime <= $currentDate) {
            $pastBookings[] = $row;
        } else {
            $futureBookings[] = $row;
        }
    }
}

function displayBooking($row, $conn, $isPastBooking)
{
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
    <div class="booking-card row">
        <div class="image-container col-12 col-md-5">
            <img src="<?php echo $row['image']; ?>">
        </div>
        <div class="content-container col-12 col-md-6">
            <h2 class="title"><?php echo $row['restaurant_name']; ?></h2>
            <div class="booked-info">
                <h4>Date: <?php echo $formattedDate; ?></h4>
                <h4>Time: <?php echo $formattedTime; ?></h4>
                <h5>Number of people: <?php echo $row['nb_of_people']; ?></h5>
                <h5>Message: <?php echo ($row['message'] == '') ? 'None' : $row['message']; ?></h5>
                <h5>Pre-ordered Starters:</h5>
                <?php
                if ($starters_result->num_rows > 0) {
                    while ($starter_row = $starters_result->fetch_assoc()) {
                        ?>
                        <h6><?php echo $starter_row['starter_name']; ?> x<?php echo $starter_row['quantity']; ?></h6>
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
            <?php if ($isPastBooking) { ?>
                <div class="book-and-review">
                    <div class="col-12 col-md-5 " id="rebook">
                        <button class="btn btn-book" onclick="NewBooking(<?php echo $row['restaurant_id']; ?>)">
                            <div class="button-content"> <i class="fas fa-utensils"></i>
                                Add Review
                            </div>
                        </button>
                        <button class="btn btn-book" onclick="NewBooking(<?php echo $row['restaurant_id']; ?>)">
                            <div class="button-content"> <i class="fas fa-utensils"></i>
                                New Booking
                            </div>
                        </button>
                    </div>
                </div>
                <form action="">
                    <!-- <h5>Rating:</h5>
                         <div class="rating col-8 col-md-5">
                            <input type="radio" id="star-1-<?php echo $row['booking_id']; ?>"
                                name="star-radio-<?php echo $row['booking_id']; ?>" value="1">
                            <label for="star-1-<?php echo $row['booking_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-2-<?php echo $row['booking_id']; ?>"
                                name="star-radio-<?php echo $row['booking_id']; ?>" value="2">
                            <label for="star-2-<?php echo $row['booking_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-3-<?php echo $row['booking_id']; ?>"
                                name="star-radio-<?php echo $row['booking_id']; ?>" value="3">
                            <label for="star-3-<?php echo $row['booking_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-4-<?php echo $row['booking_id']; ?>"
                                name="star-radio-<?php echo $row['booking_id']; ?>" value="4">
                            <label for="star-4-<?php echo $row['booking_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-5-<?php echo $row['booking_id']; ?>"
                                name="star-radio-<?php echo $row['booking_id']; ?>" value="5">
                            <label for="star-5-<?php echo $row['booking_id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                        </div> -->
                </form>
            <?php } ?>
        </div>
    </div>
    <?php
}

if (count($futureBookings) > 0) {
    ?>
    <button class="btn btn-toggle btn-toggle-bookings my-3" onclick="toggleUpcomingBookings()">
        <h2 class="text-center m-0">Upcoming Bookings <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                height="24">
                <path d="M7 10l5 5 5-5z" />
            </svg></h2>
    </button>
    <div id="upcoming-bookings-container" class="shown-bookings">
        <?php
        foreach ($futureBookings as $row) {
            displayBooking($row, $conn, false);
        }
        ?>
    </div>
    <?php
}

if (count($pastBookings) > 0) {
    ?>
    <button class="btn btn-toggle btn-toggle-bookings my-3" onclick="togglePastBookings()">
        <h2 class="text-center m-0">Past Bookings <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                height="24">
                <path d="M7 10l5 5 5-5z" />
            </svg></h2>
    </button>
    <div id="past-bookings-container" class="shown-bookings">
        <?php
        foreach ($pastBookings as $row) {
            displayBooking($row, $conn, true);
        }
        ?>
    </div>
    <?php
}

if (count($futureBookings) === 0 && count($pastBookings) === 0) {
    ?>
    <div class="container text-white" id="bookings-container">
        <div class="message-box" id="bookings-message-box">
            <h2>No Bookings Yet</h2>
            <p>
                You haven't made any restaurant reservations. Time to explore and find
                your perfect dining experience!
            </p>
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger rounded"
                id="bookNow" onclick="bookRestaurant()">Book now</button>
        </div>
    </div>
    <?php
}

$conn->close();
?>

<script>

    document.querySelectorAll('.btn-toggle-bookings').forEach(button => {
        button.addEventListener('focus', event => {
            event.target.style.outline = 'none';
            event.target.style.border = 'none';
            event.target.style.boxShadow = 'none';
        });
    });


    function NewBooking(restaurant_id) {
        const Link = `http://localhost/resto/PHP/bookings-form.php?id=${restaurant_id}`;
        // Redirect to the booking link
        window.location.href = Link;
    }

    function bookRestaurant() {
        const restaurantsPageLink = "http://localhost/resto/PHP/restaurants.php";
        // Redirect to the booking link
        window.location.href = restaurantsPageLink;
    }

    function toggleUpcomingBookings() {
        const upcomingBookingsContainer = document.getElementById('upcoming-bookings-container');

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

    function togglePastBookings() {
        const pastBookingsContainer = document.getElementById('past-bookings-container');
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

<?php include 'footer.php'; ?>