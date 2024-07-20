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

        <div id="noResultsMessage" class="row text-center" style="display: none;">
            No restaurants found matching your search criteria.
        </div>


        <div class="row">
            <?php
            $sql = "SELECT * FROM restaurants";
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



                                <div class="row">
                                    <div
                                        class="col-12 <?php echo ($row['rating'] > 0) ? 'col-md-4' : ''; ?> d-flex align-items-center justify-content-center">
                                        <h6 class="d-flex justify-content-center">
                                            <?php
                                            if ($row['rating'] > 0) {
                                                echo "Rating:";
                                            } else {
                                                echo "No Ratings Yet";
                                            }
                                            ?>
                                        </h6>
                                    </div>
                                    <?php
                                    if ($row['rating'] > 0) { ?>
                                        <div class="static-rating col-12 col-md-8 justify-content-center">
                                            <?php
                                            for ($i = 5; $i >= 1; $i--) {
                                                $isActive = $i <= $row['rating'] ? 'filled' : '';
                                                ?>
                                                <label class="star <?php echo $isActive; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>



                                <div class="restaurant-card-buttons">
                                    <div class="col-12 col-lg-5 px-lg-0">
                                        <button class="btn btn-book" onclick="menuPage(<?php echo $row['id']; ?>)">
                                            <div class="button-content"><i class="fas fa-utensils"></i> Menu </div>
                                        </button>
                                    </div>
                                    <div class="col-12 col-lg-7 px-lg-0">
                                        <button class="btn btn-book" onclick="bookingFormPage(<?php echo $row['id']; ?>)">
                                            <div class="button-content"> <i class="fas fa-utensils"></i> Book Now
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        function redirectToPage(restaurantId, page) {
            const redirectUrl = `http://localhost/resto/PHP/redirect_restaurant.php?id=${restaurantId}&page=${page}`;
            window.location.href = redirectUrl;
        }

        function bookingFormPage(restaurantId) {
            redirectToPage(restaurantId, "http://localhost/resto/PHP/bookings-form.php");
        }

        function menuPage(restaurantId) {
            redirectToPage(restaurantId, "http://localhost/resto/PHP/menu.php");
        }



        // function bookingFormPage(restaurantId) {
        //     const bookingLink = "http://localhost/resto/PHP/bookings-form.php?id=" + restaurantId;
        //     window.location.href = bookingLink;
        // }

        // function menuPage(restaurantId) {
        //     const menuLink = "http://localhost/resto/PHP/menu.php?id=" + restaurantId;
        //     window.location.href = menuLink;
        // }


        let restaurantsData = <?php echo json_encode($clone_result); ?>;
        let searchBar = document.getElementById('searchBar');

        function filterRestaurants() {
            const search = searchBar.value.trim().toLowerCase();

            let visibleCount = 0;

            for (let restaurant of restaurantsData) {
                const matchesSearch = restaurant.name.toLowerCase().startsWith(search) ||
                    restaurant.location.toLowerCase().startsWith(search) ||
                    restaurant.food_types.toLowerCase().includes(search);

                const restaurantCard = document.getElementById(`restaurant-card-${restaurant.id}`);
                if (restaurantCard) {
                    restaurantCard.style.display = matchesSearch ? 'block' : 'none';
                    if (matchesSearch) {
                        visibleCount++;
                    }
                }
            }


            const noResultsMessage = document.getElementById('noResultsMessage');
            // Check if no cards are visible
            if (visibleCount === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        }

        searchBar.addEventListener('input', filterRestaurants);
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>