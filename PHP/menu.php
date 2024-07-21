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
$stmt = $conn->prepare("SELECT r.name as resto_name, r.phone_nb, r.website, m.item_name, m.item_description, m.item_price, m.item_type
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
    <div class="menu-container">
        <div class="row">
            <h1 class="resto-name"><?php echo htmlspecialchars($menuItems['starter'][0]['resto_name']); ?></h1>
        </div>

        <div class="type1 row">
            <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\starter1.jpg" alt="Starters">
            </div>
            <div class="col-10 col-md-7 description1">
                <div>
                    <h2 class="menu-h2">Starters</h2>
                </div>
                <?php foreach ($menuItems['starter'] as $item): ?>
                    <div class="row">
                        <div class="col-7">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                        </div>
                        <div class="col-1 price1">
                            <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="type2 row">
            <div class="col-10 col-md-7 description2">
                <div>
                    <h2 class="menu2-h2">Meal</h2>
                </div>
                <?php foreach ($menuItems['meal'] as $item): ?>
                    <div class="row">
                        <div class="col-1 price2 order-2 order-md-1">
                            <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                        </div>
                        <div class="col-7 order-1 order-md-2">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\meal1.jpg" alt="Meals">
            </div>
        </div>

        <div class="type1 row">
            <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\dessert1.jpg" alt="Desserts">
            </div>
            <div class="col-10 col-md-7 description1">
                <div>
                    <h2 class="menu-h2">Dessert</h2>
                </div>
                <?php foreach ($menuItems['dessert'] as $item): ?>
                    <div class="row">
                        <div class="col-7">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                        </div>
                        <div class="col-1 price1">
                            <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="type2 row">
            <div class="col-10 col-md-7 description2">
                <div>
                    <h2 class="menu2-h2">Drinks</h2>
                </div>
                <?php foreach ($menuItems['drinks'] as $item): ?>
                    <div class="row">
                        <div class="col-1 price2 order-2 order-md-1">
                            <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                        </div>
                        <div class="col-7 order-1 order-md-2">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\drinks1.jpg" alt="Drinks">
            </div>
        </div>

        <div class="contact-info row">
            <h5><a href="tel:01256487"> 📞 <?php echo htmlspecialchars($menuItems['starter'][0]['phone_nb']); ?> </a>
            </h5>
            <h5><a href="http://www.sud.com"> 🌐 <?php echo htmlspecialchars($menuItems['starter'][0]['website']); ?>
                </a></h5>
        </div>
    </div>
</body>

</html>

<?php include 'footer.php'; ?>