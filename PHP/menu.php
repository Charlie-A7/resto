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

$restaurant_id = $_SESSION['restaurant_id'];
$stmt = $conn->prepare("SELECT m.item_name, m.item_description, m.item_price, m.item_type
                        FROM restaurants r 
                        JOIN menu m ON r.id = m.restaurant_id
                        WHERE r.id = ? AND m.status = 'active'");
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

$menuItems = [
    'starter' => [],
    'meal' => [],
    'dessert' => [],
    'drinks' => []
];

while ($row = $result->fetch_assoc()) {
    $menuItems[$row['item_type']][] = $row;
}

$stmt = $conn->prepare("SELECT phone_nb, website, name as restaurant_name 
                        FROM restaurants 
                        WHERE id = ?");
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$restaurantDetails = $stmt->get_result()->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>

<body>
    <div class="menu-container container">
        <div class="row mt-2 my-4">
            <h1 class="resto-name"><?php echo htmlspecialchars($restaurantDetails['restaurant_name']); ?></h1>
        </div>

        <?php if ($menuItems['starter']) { ?>
            <div class="type1 row justify-content-center">
                <!-- <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\starter1.jpg" alt="Starters">
            </div> -->
                <div class="col-11 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Starters</h2>
                    </div>
                    <?php foreach ($menuItems['starter'] as $item): ?>
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                            </div>
                            <div class="col-3 price1">
                                <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php }

        if ($menuItems['meal']) { ?>
            <div class="type1 row justify-content-center">
                <div class="col-11 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Meal</h2>
                    </div>
                    <?php foreach ($menuItems['meal'] as $item): ?>
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                            </div>
                            <div class="col-3 price1">
                                <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\meal1.jpg" alt="Meals">
            </div> -->
            </div>
        <?php }

        if ($menuItems['dessert']) {
            ?>
            <div class="type1 row justify-content-center">
                <!-- <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\dessert1.jpg" alt="Desserts">
            </div> -->
                <div class="col-11 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Dessert</h2>
                    </div>
                    <?php foreach ($menuItems['dessert'] as $item): ?>
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                            </div>
                            <div class="col-3 price1">
                                <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        <?php }

        if ($menuItems['drinks']) {
            ?>
            <div class="type1 row justify-content-center">
                <div class="col-11 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Drinks</h2>
                    </div>
                    <?php foreach ($menuItems['drinks'] as $item): ?>
                        <div class="row justify-content-center">
                            <div class="col-7">
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                            </div>
                            <div class="col-3 price1">
                                <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\drinks1.jpg" alt="Drinks">
            </div> -->
            </div>
        <?php } ?>

        <div class="contact-info row">
            <h5><a href="tel:01256487"> 📞 <?php echo htmlspecialchars($restaurantDetails['phone_nb']); ?> </a>
            </h5>
            <h5><a href="http://www.sud.com"> 🌐 <?php echo htmlspecialchars($restaurantDetails['website']); ?>
                </a></h5>
        </div>
    </div>
</body>

</html>

<?php include 'footer.php'; ?>