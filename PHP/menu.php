<?php
session_start();

include 'header.php';
?>

<body>
    <div class="menu-container">

        <div class="row">
            <h1 class="resto-name">SUD</h1>
        </div>

        <div class="type1 row">
            <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\starter1.jpg">
            </div>
            <div class="col-10 col-md-5 description1">
                <div>
                    <h2 class="menu-h2">Starters</h2>
                </div>
                <div>
                    <h3>SUD's Special</h3>
                    <h5>Fries, onion rings, wings, garlic bread </h5>
                </div>
            </div>
            <div class="col-1 price1">
                <h5>$10</h5>
            </div>
        </div>

        <div class="type2 row">
            <div class="col-1 price2">
                <h5>$20</h5>
            </div>
            <div class="col-10 col-md-5 description2">
                <div>
                    <h2 class="menu-h2">Meal</h2>
                </div>
                <div>
                    <h3>Barbecue platter</h3>
                    <h5>Taouk, kafta, salad</h>
                </div>
            </div>
            <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\meal1.jpg">
            </div>
        </div>

        <div class="type1 row">
            <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\dessert1.jpg">
            </div>
            <div class="col-10 col-md-5 description1">
                <div>
                    <h2 class="menu-h2">Dessert</h2>
                </div>
                <div>
                    <h3>Waffle</h3>
                    <h5>3 perfectly made waffles with strawberry, and a syrup or chocolate of your choice</h5>
                </div>
            </div>
            <div class="col-1 price1">
                <h5>$7</h5>
            </div>
        </div>

        <div class="type2 row">
            <div class="col-1 price2">
                <h5>$5</h5>
            </div>
            <div class="col-10 col-md-5 description2">
                <div>
                    <h2 class="menu-h2">Drink</h2>
                </div>
                <div>
                    <h3>spicy marguerita</h3>
                    <h5>Tequila, triple sec, lime juice, and a spicy kick</h>
                </div>
            </div>
            <div class="col-12 col-md-4 type2-img">
                <img src="..\Images\Images\drink1.jpg">
            </div>
        </div>

        <div class="contact-info row">
            <h5> <a href="tel:01256487"> 📞 01 256 487 </a></h5>
            <h5> <a href="www.sud.com"> 🌐 SUD.com </a></h5>
        </div>

    </div>

</body>

<?php include 'footer.php'; ?>