<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
}

include 'db_connection.php';
include 'header.php';
?>

<body>
    <?php
    $customer_id = $_SESSION['userid'];
    $sql = "SELECT b.id as booking_id, b.restaurant_id, r.name as restaurant_name, b.customer_id, b.booking_date as date, 
                b.booking_time as time, b.number_of_people as nb_of_people, b.message, b.total_price as total ,r.image_url as image
            FROM bookings b
            INNER JOIN restaurants r ON b.restaurant_id = r.id
            WHERE b.customer_id = $customer_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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

                        <h5>Rating:</h5>
                    </div>

                    <div class="book-and-review">
                        <div class="rating col-8 col-md-5">
                            <input type="radio" id="star-1" name="star-radio" value="star-1">
                            <label for="star-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-2" name="star-radio" value="star-1">
                            <label for="star-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-3" name="star-radio" value="star-1">
                            <label for="star-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-4" name="star-radio" value="star-1">
                            <label for="star-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                            <input type="radio" id="star-5" name="star-radio" value="star-1">
                            <label for="star-5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path pathLength="360"
                                        d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                    </path>
                                </svg>
                            </label>
                        </div>
                        <div class="col-12 col-md-5 " id="rebook">
                            <button class="btn btn-book" onclick="">
                                <div class="button-content"> <i class="fas fa-utensils"></i>
                                    Rebook
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
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
        function bookRestaurant() {
            const restaurantsPageLink = "http://localhost/resto/PHP/restaurants.php";
            // Redirect to the booking link
            window.location.href = restaurantsPageLink;
        }

        // Hiding the 2 contact us buttons in the header
        document.addEventListener('DOMContentLoaded', function () {
            // Hide login buttons
            document.querySelectorAll('header ul li.bookings-btn, div.header-div-nav-links2 li.bookings-btn').forEach(btn => {
                btn.style.display = 'none';
            });
        });

    </script>

    <?php include 'footer.php'; ?>