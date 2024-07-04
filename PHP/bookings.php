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