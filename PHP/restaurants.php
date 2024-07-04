<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/Webproject/PHP/login.php");
    exit();
}

include 'header.php';
?>


<body>
    <div class="container-fluid px-5 text-white" id="container-restaurants">
        <h1 class="text-center m-4">Choose Your Restaurant</h1>

        <div class="row d-flex justify-content-center mb-5">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" id="restaurants-search-bar" />
                    <span class="input-group-text border-0" id="restaurants-search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/SUD.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">SUD</h5>
                        <p class="card-text">
                            $$$ · French, Salads, Italian
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/Bartartine.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Bartartine - Dbayeh</h5>
                        <p class="card-text">
                            $$$ · Coffee, Salads, Healthy
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/Roadster.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Roadster Diner - Antelias</h5>
                        <p class="card-text">
                            $$$ · Fast Food, Burgers, Salads
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/Miniguette.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Miniguette - Jal El Dib</h5>
                        <p class="card-text">
                            $$$ · Fast Food, Burgers, Breakfast
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/TheWok.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">The Wok - Dbayeh</h5>
                        <p class="card-text">
                            $$$ · Asian - Chinese
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/DeekDuke.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Deek Duke - Dbayeh</h5>
                        <p class="card-text">
                            $$$ · Chicken - Burgers
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/Dominos.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Domino's - Sin El Fil</h5>
                        <p class="card-text">
                            $$$ · Pizza - Fast Food
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/SandwichWnoss.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Sandwich W Noss - Jal El Dib</h5>
                        <p class="card-text">
                            $$$ · Burgers, Fast Food, Lebanese
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/KaakehSquare.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">Kaakeh Square - Beirut</h5>
                        <p class="card-text">
                            $$$ · Bakeries, Breakfast
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingFormPage() {
            const bookingLink = "http://localhost/Webproject/PHP/bookings-form.php"; // Replace with your actual booking form URL

            // Redirect to the booking form link
            window.location.href = bookingLink;
        }

        // Hiding the 2 contact us buttons in the header
        document.addEventListener('DOMContentLoaded', function () {
            // Hide login buttons
            document.querySelectorAll('header ul li.restaurants-btn, div.header-div-nav-links2 li.restaurants-btn').forEach(btn => {
                btn.style.display = 'none';
            });
        });
    </script>

    <?php include 'footer.php'; ?>