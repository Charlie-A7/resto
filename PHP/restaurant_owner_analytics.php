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

$restaurant_id = $_SESSION['restaurant_id'];
// Fetch the number of people per rating
$ratingsQuery = "SELECT r.rating, COUNT(*) as count 
                    FROM reviews r
                    JOIN bookings b ON r.booking_id = b.id
                    WHERE b.restaurant_id = {$restaurant_id}
                    GROUP BY r.rating 
                    ORDER BY r.rating DESC";
$ratingsResult = mysqli_query($conn, $ratingsQuery);

// Fetch the overall rating from the restaurants table
$restaurantRatingQuery = "SELECT rating FROM restaurants WHERE id = {$restaurant_id}";
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


$timespan = isset($_POST['bookings-timespan']) ? $_POST['bookings-timespan'] : 'week';
$currentDate = new DateTimeImmutable();
$startDate = '';
$endDate = $currentDate->format('Y-m-d');

switch ($timespan) {
    case 'week':
        $startDate = (new DateTimeImmutable('monday this week'))->format('Y-m-d');
        break;
    case 'month':
        $startDate = $currentDate->format('Y-m-01');
        break;
    case 'year':
        $startDate = $currentDate->format('Y-01-01');
        break;
    default:
        $startDate = $currentDate->format('Y-m-01');
}

$sql = "SELECT COUNT(*) as accepted_bookings_count
        FROM bookings
        WHERE restaurant_id = ? AND status = 'accepted' AND DATE(booking_date) >= ? AND DATE(booking_date) <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $restaurant_id, $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_accepted_bookings_count = $row['accepted_bookings_count'];
?>

<div class="container">
    <?php
    $ratingCounts = [];

    while ($row = mysqli_fetch_assoc($ratingsResult)) {
        $ratingCounts[$row['rating']] = $row['count'];
    }

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

    <div class="row">
        <div class="col-12 col-md-4 d-flex justify-content-center my-3">
            <form method="post" action="">
                <label for="bookings-timespan" class="d-flex align-items-center">Select Timespan: </label>
                <select name="bookings-timespan" id="bookings-timespan" class="ml-2" onchange="this.form.submit()">
                    <option value="week" <?php if ($timespan == 'week')
                        echo 'selected'; ?>>week</option>
                    <option value="month" <?php if ($timespan == 'month')
                        echo 'selected'; ?>>month</option>
                    <option value="year" <?php if ($timespan == 'year')
                        echo 'selected'; ?>>year</option>
                </select>
            </form>
        </div>
        <div class="col-12 col-md-8 d-flex justify-content-center my-3">
            <h3 class="text-center" id="bookings-timespan-text">Total Number of Tables booked in the past
                <?php echo htmlspecialchars($timespan); ?>:
                <?php echo $total_accepted_bookings_count ?>
            </h3>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>