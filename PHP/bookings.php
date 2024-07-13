<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
}

include 'header.php';
?>

<body>
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


    <div class="booking-card row">
        <div class="image-container col-12 col-md-5">
            <img src="..\Images\Images\SUD.jpg">
        </div>
        <div class="content-container col-12 col-md-6">
            <h2 class="title">Restaurant Name</h2>
            <div class="booked-info">
                <h4>Date:16/7/2024</h4>
                <h4>Time: 13:20p.m.</h4>
                <h5>Number of people booked for: 3</h5>
                <span>
                    <h5>Your Message:</h5>
                </span>
                <span>
                    <h5>Pre-booked Starters:</h5>
                </span>
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
    </div>


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