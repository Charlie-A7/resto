<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
} elseif (isset($_SESSION['userid']) && $_SESSION['user_type'] !== 'owner') {
    header("Location: http://localhost/resto/PHP/restaurant_owner_homepage.php");
    exit();
}

include 'db_connection.php';
include 'header.php';


$restaurant_id = $_SESSION['restaurant_id'];
$sql = "SELECT * FROM restaurants WHERE restaurants.id = $restaurant_id";
$result = $conn->query($sql);
?>

<style>
    body {
        background-color: #cd9c6b !important;
    }
</style>

<?php
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div class="container px-5 text-white" id="container-restaurants">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-xl-6">
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
                                <button class="btn btn-book">
                                    <div class="button-content"><i class="fas fa-utensils"></i> Menu </div>
                                </button>
                            </div>
                            <div class="col-12 col-lg-7 px-lg-0">
                                <button class="btn btn-book">
                                    <div class="button-content"> <i class="fas fa-utensils"></i> Book Now
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-6 col-md-3 d-flex justify-content-center">
                <button class="btn-primary rounded">Edit Image</button>
            </div>
            <div class="col-6 col-md-3 d-flex justify-content-center">
                <button class="btn-primary rounded">Edit Location</button>
            </div>
            <div class="col-6 col-md-3 d-flex justify-content-center">
                <button class="btn-primary rounded">Edit Price Range</button>
            </div>
            <div class="col-6 col-md-3 d-flex justify-content-center">
                <button class="btn-primary rounded">Edit Food Types</button>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "0 results";
}
$conn->close();
?>


<?php include 'footer.php'; ?>