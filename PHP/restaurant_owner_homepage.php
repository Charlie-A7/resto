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

$restaurantId = $_SESSION['restaurant_id'];
$sql = "SELECT name as restaurant_name FROM restaurants WHERE id = $restaurantId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc()
        ?>
    <div class="container">
        <section class="dashboard">
            <div class="dashboard-content p-4 p-lg-5 px-lg-4">
                <h1>Welcome, Restaurant (<?php echo $row['restaurant_name']; ?>) Owner</h1>
                <p>Manage your restaurant efficiently with our comprehensive tools and insights.</p>

                <div class="dashboard-cards d-flex justify-content-center text-center flex-wrap">
                    <div class="card restaurant-owner-card m-2 p-3" onclick="navigateTo('reservations')">
                        <div class="card-icon restaurant-owner-card-icon">
                            <img src="..\Images\Images\reserved.png">
                        </div>
                        <h3>Reservations</h3>
                        <p>View and manage table reservations</p>
                    </div>
                    <div class=" card restaurant-owner-card m-2 p-3" onclick="navigateTo('menu')">
                        <div class="card-icon restaurant-owner-card-icon">
                            <img src="..\Images\Images\menu.png">
                        </div>
                        <h3>Menu</h3>
                        <p>Check your menu</p>
                    </div>
                    <div class="card restaurant-owner-card m-2 p-3" onclick="navigateTo('analytics')">
                        <div class="card-icon restaurant-owner-card-icon">
                            <img src="..\Images\Images\analytics.png">
                        </div>
                        <h3>Analytics</h3>
                        <p>Track your restaurant's performance</p>
                    </div>
                    <div class="card restaurant-owner-card m-2 p-3" onclick="navigateTo('contact')">
                        <div class="card-icon restaurant-owner-card-icon">
                            <img src="..\Images\Images\contact-us.png">
                        </div>
                        <h3>Contact Us</h3>
                        <p>For any inquiries or help don't hesitate to contact us</p>
                    </div>
                    <div class="card restaurant-owner-card m-2 p-3" onclick="navigateTo('card')">
                        <div class="card-icon restaurant-owner-card-icon">
                            <img src="..\Images\Images\restaurant-card.png">
                        </div>
                        <h3>Card</h3>
                        <p>Check you restaurant's card</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php } ?>

<script>
    function navigateTo(page) {
        const pages = {
            reservations: "http://localhost/resto/PHP/restaurant_owner_bookings.php",
            menu: "http://localhost/resto/PHP/restaurant_owner_menu.php",
            analytics: "http://localhost/resto/PHP/restaurant_owner_analytics.php",
            contact: "http://localhost/resto/PHP/contactus.php",
            card: "http://localhost/resto/PHP/restaurant_owner_update_card.php"
        };
        window.location.href = pages[page];
    }
</script>

<?php include 'footer.php'; ?>