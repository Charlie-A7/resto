<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
} elseif (isset($_SESSION['userid']) && $_SESSION['user_type'] !== 'owner') {
    header("Location: http://localhost/resto/PHP/index.php");
    exit();
}

include 'db_connection.php';
include 'header.php';

// Fetch the number of people per rating
$ratingsQuery = "SELECT rating, COUNT(*) as count FROM reviews GROUP BY rating ORDER BY rating DESC";
$ratingsResult = mysqli_query($conn, $ratingsQuery);

// Fetch the overall rating from the restaurants table
$restaurantRatingQuery = "SELECT rating FROM restaurants WHERE id = {$_SESSION['restaurant_id']}";
$restaurantRatingResult = mysqli_query($conn, $restaurantRatingQuery);

if ($restaurantRatingResult && mysqli_num_rows($restaurantRatingResult) > 0) {
    $restaurantRating = mysqli_fetch_assoc($restaurantRatingResult)['rating'];
    // Check if the rating is NULL and set a default value
    if ($restaurantRating === NULL) {
        $restaurantRating = 0; // or any default value you prefer
    }
} else {
    $restaurantRating = 0; // Default value if no rating is found
}
?>
<div class="container">
    <?php
    // Initialize an array to store ratings data
    $ratingCounts = [];

    // Fetch ratings data
    while ($row = mysqli_fetch_assoc($ratingsResult)) {
        $ratingCounts[$row['rating']] = $row['count'];
    }

    // Display number of people for each rating
    for ($ratingValue = 5; $ratingValue >= 1; $ratingValue--) {
        $count = isset($ratingCounts[$ratingValue]) ? $ratingCounts[$ratingValue] : 0;
        ?>
        <div class="row my-3">
            <div class="col-12 col-md-4">
                <h3 class="d-flex justify-content-center">Nb of people: <?php echo $count; ?></h3>
            </div>
            <div class="static-rating col-12 col-md-8 justify-content-center">
                <?php
                for ($i = 5; $i >= 1; $i--) {
                    $isActive = $i <= $ratingValue ? 'filled' : '';
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
        </div>
    <?php } ?>

    <div class="row my-5">
        <div class="col-12 col-md-4">
            <h3 class="d-flex justify-content-center"><?php
            if ($restaurantRating > 0) {
                echo "Overall Rating:";
            } else {
                echo "No Ratings Yet";
            }
            ?></h3>
        </div>
        <div class="static-rating col-12 col-md-8 justify-content-center">
            <?php
            for ($i = 5; $i >= 1; $i--) {
                $isActive = $i <= $restaurantRating ? 'filled' : '';
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
    </div>
</div>

<?php include 'footer.php'; ?>