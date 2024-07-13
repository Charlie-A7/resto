<!DOCTYPE html>
<html>

<head>
    <title>
        Restaurant Booking
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="http://localhost/resto/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <?php $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    ?>
    <header>
        <div class="container-fluid p-0">
            <div class="navbar p-1 px-3">
                <a href="<?php echo (strpos($currentUrl, 'restaurant_owner_homepage.php') === false) ? 'http://localhost/resto/PHP/index.php' : 'http://localhost/resto/PHP/restaurant_owner_homepage.php'; ?>" class="m-3 text-muted text-decoration-none">
                    <img src="../Images/logo/Restaurant-booking-02.png" id="logo">
                </a>
                <a class="navbar-brand"
                    href="<?php echo (strpos($currentUrl, 'restaurant_owner_homepage.php') === false) ? 'http://localhost/resto/PHP/index.php' : 'http://localhost/resto/PHP/restaurant_owner_homepage.php'; ?>">RestaurantBooking</a>

                <?php
                if (strpos($currentUrl, 'restaurant_owner_homepage.php') == false) { ?>
                    <ul class="nav-links m-0 p-0">
                        <?php
                        if (strpos($currentUrl, 'restaurants.php') == false) { ?>
                            <li class="nav-item p-2 restaurants-btn">
                                <a class="nav-link" href="http://localhost/resto/PHP/restaurants.php">Restaurants</a>
                            </li>
                        <?php }
                        if (strpos($currentUrl, 'bookings.php') == false) { ?>
                            <li class="nav-item p-2 bookings-btn">
                                <a class="nav-link" href="http://localhost/resto/PHP/bookings.php">Bookings</a>
                            </li>
                        <?php }
                        if (strpos($currentUrl, 'contactus.php') == false) { ?>
                            <li class="nav-item p-2 contactus1">
                                <a class="nav-link" href="http://localhost/resto/PHP/contactus.php">Contact Us</a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <button class="navbar-toggler" onclick="toggleNav()"><span class="navbar-toggler-icon"></span></button>
                <?php
                if (!isset($_SESSION['userid'])) {
                    if (strpos($currentUrl, 'login.php') == false) { ?>
                        <button data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-primary btn-block p-2 rounded loginbtn1" type="button" onclick="openLogIn()">Log
                            in</button>
                    <?php }
                } else { ?>
                    <button data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-primary btn-block p-2 rounded loginbtn1" type="button" onclick="openLogout()">Log
                        out</button>
                <?php } ?>

            </div>
        </div>
    </header>

    <div class="header-div-nav-links2">
        <ul class="header-nav-links2 m-0 p-0">

            <?php
            if (strpos($currentUrl, 'restaurant_owner_homepage.php') == false) {
                if (strpos($currentUrl, 'restaurants.php') == false) { ?>
                    <li class="nav-item p-1 restaurants-btn">
                        <a class="nav-link2 p-1 pr-2 " href="http://localhost/resto/PHP/restaurants.php">Restaurants</a>
                    </li>
                <?php }
                if (strpos($currentUrl, 'bookings.php') == false) { ?>
                    <li class="nav-item p-1 bookings-btn">
                        <a class="nav-link2 p-1 pr-2" href="http://localhost/resto/PHP/bookings.php">Bookings</a>
                    </li>
                <?php }
                if (strpos($currentUrl, 'contactus.php') == false) { ?>
                    <li class="nav-item p-1 contactus2">
                        <a class="nav-link2 p-1 pr-2" href="http://localhost/resto/PHP/contactus.php">Contact Us</a>
                    </li>
                <?php }
            }
            if (!isset($_SESSION['userid'])) {
                if (strpos($currentUrl, 'login.php') == false) { ?>
                    <li class="nav-item p-1 loginbtn2">
                        <a class="nav-link2 p-1 pr-2" href="http://localhost/resto/PHP/login.php">Log In</a>
                    </li>
                <?php }
            } else { ?>
                <li class="nav-item p-1 loginbtn2">
                    <a class="nav-link2 p-1 pr-2" href="http://localhost/resto/PHP/logout.php">Log Out</a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <script>

        function openLogIn() {
            window.location.href = "http://localhost/resto/PHP/login.php";
        }

        function openLogout() {
            window.location.href = "http://localhost/resto/PHP/logout.php";
        }

        function toggleNav() {
            var navLinks2 = document.querySelector('.header-div-nav-links2');
            if (navLinks2.classList.contains('show')) {
                navLinks2.classList.remove('show');
                document.body.classList.remove('header-div-nav-links2-open'); // Enable scrolling
                setTimeout(function () {
                    navLinks2.style.display = "none";
                }, 500); // Match this duration with the transition duration in CSS
            } else {
                navLinks2.style.display = "flex";
                setTimeout(function () {
                    navLinks2.classList.add('show');
                }, 0); // Allow the display property to take effect before adding the class
                document.body.classList.add('header-div-nav-links2-open'); // Disable scrolling
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Function to hide div-nav-links2 when the screen size exceeds the mobile view
            function hideNavLinks2OnDesktop() {
                var navLinks2 = document.querySelector('.header-div-nav-links2');
                if (window.innerWidth > 991.2) { // Assuming 991px as the desktop view breakpoint
                    navLinks2.style.display = "none";
                    navLinks2.classList.remove('show');
                    document.body.classList.remove('header-div-nav-links2-open'); // Enable scrolling
                }
            }

            // Hide div-nav-links2 initially on document ready
            hideNavLinks2OnDesktop();

            // Event listener for window resize to hide div-nav-links2 on desktop
            window.addEventListener('resize', hideNavLinks2OnDesktop);
        });


    </script>