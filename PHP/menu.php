<?php
session_start();

include 'db_connection.php';
include 'header.php';
?>

<body>
    <div class="menu-container">
        <?php
        $restaurant_id = $_GET['id'];
        $sql = "SELECT r.name as resto_name, r.phone_nb, r.website, m.item_name, m.item_description, m.item_price ,m.item_type
                FROM restaurants r 
                JOIN menu m ON r.id = m.restaurant_id
                WHERE r.id = $restaurant_id";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $result2 = $conn->query($sql);
        $result3 = $conn->query($sql);
        $result4 = $conn->query($sql);
        if ($result->num_rows > 0) {


            $main_row = $result->fetch_assoc();
            ?>

            <div class="row">
                <h1 class="resto-name"><?php echo $main_row['resto_name']; ?></h1>
            </div>

            <div class="type1 row">
                <div class="col-12 col-md-4 type1-img">
                    <img src="..\Images\Images\starter1.jpg">
                </div>
                <div class="col-10 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Starters</h2>
                    </div>

                    <?php
                    while ($row1 = $result1->fetch_assoc()) {
                        if ($row1['item_type'] == 'starter') {
                            ?>
                            <div class=" row">
                                <div class="col-7">
                                    <h3><?php echo $row1['item_name']; ?></h3>
                                    <h6><?php echo $row1['item_description']; ?> </h6>
                                </div>
                                <div class="col-1 price1">
                                    <h5><?php echo $row1['item_price']; ?>$</h5>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="type2 row">
                <div class="col-10 col-md-7 description2">
                    <div>
                        <h2 class="menu2-h2">Meal</h2>
                    </div>

                    <?php
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row2['item_type'] == 'meal') {
                            ?>
                            <div class="row">
                                <div class="col-1 price2 order-2 order-md-1">
                                    <h5><?php echo $row2['item_price']; ?>$</h5>
                                </div>
                                <div class="col-7 order-1 order-md-2">
                                    <h3><?php echo $row2['item_name']; ?></h3>
                                    <h6><?php echo $row2['item_description']; ?></h6>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-12 col-md-4 type2-img">
                    <img src="..\Images\Images\meal1.jpg">
                </div>
            </div>

            <div class="type1 row">
                <div class="col-12 col-md-4 type1-img">
                    <img src="..\Images\Images\dessert1.jpg">
                </div>
                <div class="col-10 col-md-7 description1">
                    <div>
                        <h2 class="menu-h2">Dessert</h2>
                    </div>

                    <?php
                    while ($row3 = $result3->fetch_assoc()) {
                        if ($row3['item_type'] == 'dessert') {
                            ?>
                            <div class="row">
                                <div class="col-7">
                                    <h3><?php echo $row3['item_name']; ?></h3>
                                    <h6><?php echo $row3['item_description']; ?> </h6>
                                </div>
                                <div class="col-1 price1">
                                    <h5><?php echo $row3['item_price']; ?>$</h5>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>



            <div class="type2 row">
                <div class="col-10 col-md-7 description2">
                    <div>
                        <h2 class="menu2-h2">Drinks</h2>
                    </div>

                    <?php
                    while ($row4 = $result4->fetch_assoc()) {
                        if ($row4['item_type'] == 'drinks') {
                            ?>
                            <div class="row">
                                <div class="col-1 price2 order-2 order-md-1">
                                    <h5><?php echo $row4['item_price']; ?>$</h5>
                                </div>
                                <div class="col-7 order-1 order-md-2">
                                    <h3><?php echo $row4['item_name']; ?></h3>
                                    <h6><?php echo $row4['item_description']; ?></h6>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-12 col-md-4 type2-img">
                    <img src="..\Images\Images\drink1.jpg">
                </div>
            </div>

            <div class="contact-info row">
                <h5> <a href="tel:01256487"> 📞 <?php echo $main_row['phone_nb']; ?> </a></h5>
                <h5> <a href="www.sud.com"> 🌐 <?php echo $main_row['website']; ?> </a></h5>
            </div>

            <?php
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>

</body>

<?php include 'footer.php'; ?>