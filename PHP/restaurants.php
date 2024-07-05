<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
}

include 'db_connection.php';
include 'header.php';
$clone_result = array();
?>

<style>
    body {
        background-color: #cd9c6b !important;
    }
</style>

<body>
    <div class="container-fluid px-5 text-white" id="container-restaurants">
        <h1 class="text-center m-4">Choose Your Restaurant</h1>

        <div class="row d-flex justify-content-center mb-5">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="input-group">
                    <input type="search" class="form-control rounded" id="searchBar" placeholder="Search"
                        aria-label="Search" aria-describedby="search-addon" id="restaurants-search-bar" />
                </div>
            </div>
        </div>

        <div class="row">
 resto-backend
            <?php
            $sql = "SELECT id, name, location, price_range, food_types, image_url FROM restaurants";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $clone_result[] = $row;
                    ?>
                    <div id="restaurant-card-<?php echo $row['id']; ?>" class="col-12 col-sm-6 col-md-4 col-xl-3">
                        <div class="restaurant-card">
                            <img src="<?php echo $row['image_url']; ?>" class="card-img-top" />
                            <div class="card-body restaurants-card-body">
                                <h5 class="card-title restaurants-card-title">
                                    <?php echo $row['name'] . ' - ' . $row['location']; ?>
                                </h5>
                                <p class="card-text"><?php echo $row['price_range'] . ' · ' . $row['food_types']; ?></p>
                                <button class="btn btn-book" onclick="menuPage()">
                                    <i class="fas fa-utensils"></i> Menu
                                </button>
                                <button class="btn btn-book" onclick="bookingFormPage()">
                                    <i class="fas fa-utensils"></i> Book Now
                                </button>
                            </div>
                        </div>

            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="restaurant-card">
                    <img src="../Images/Images/SUD.jpg" class="card-img-top" />
                    <div class="card-body restaurants-card-body">
                        <h5 class="card-title restaurants-card-title">SUD</h5>
                        <p class="card-text">
                            $$$ · French, Salads, Italian
                        </p>
                        <button class="btn btn-book" onclick="bookingFormPage()">
                            <i class="fas fa-utensils"></i> Menu
                        </button>
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
 main
                    </div>
                <?php }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script>
        function bookingFormPage() {
 resto-backend
            const bookingLink = "http://localhost/resto/PHP/bookings-form.php";

            const bookingLink = "http://localhost/resto/PHP/bookings-form.php"; // Replace with your actual booking form URL

            // Redirect to the booking form link
 main
            window.location.href = bookingLink;
        }

        // Hiding the 2 contact us buttons in the header
        document.addEventListener('DOMContentLoaded', function () {
            // Hide login buttons
            document.querySelectorAll('header ul li.restaurants-btn, div.header-div-nav-links2 li.restaurants-btn').forEach(btn => {
                btn.style.display = 'none';
            });
        });


        let restaurantsData = <?php echo json_encode($clone_result); ?>;

        let searchBar = document.getElementById('searchBar');
        let search = "";

        function filterRestaurants() {
            const search = searchBar.value.trim().toLowerCase();

            for (let restaurant of restaurantsData) {
                const matchesSearch = restaurant.name.toLowerCase().startsWith(search) ||
                    restaurant.location.toLowerCase().startsWith(search) ||
                    restaurant.food_types.toLowerCase().includes(search);

                document.getElementById(`restaurant-card-${restaurant.id}`).style.display = matchesSearch ? 'block' : 'none';
            }
        }

        searchBar.addEventListener('input', filterRestaurants);


    </script>

    <?php include 'footer.php'; ?>
</body>

</html>