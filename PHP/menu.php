<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
}

include 'header.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f9f9f9;
    }

    .tabs {
        display: flex;
        justify-content: center;
        margin: 20px 0;
        gap: 30px;
    }

    .tab {
        position: relative;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 1em;
        color: #555;
    }

    .tab.active {
        font-weight: bold;
        color: #d32f2f;
    }

    .tab::after {
        content: '';
        display: block;
        margin: auto;
        height: 2px;
        width: 0;
        background: transparent;
        transition: width 0.3s, background-color 0.3s;
    }

    .tab:hover::after {
        width: 100%;
        background: #d32f2f;
    }

    .tab.active::after {
        width: 100%;
        background: #d32f2f;
    }

    h1 {
        margin-top: 20px;
        font-size: 2.5em;
        color: #d32f2f;
    }

    .menu {
        display: none;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
    }

    .menu.active {
        display: flex;
    }

    .item {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    .item img {
        width: 100%;
        height: auto;
    }

    .item h2 {
        font-size: 1.5em;
        margin: 10px 0;
    }

    .item p {
        color: #888;
        font-size: 0.9em;
    }

    .item .price {
        font-size: 1.2em;
        color: #d32f2f;
        margin: 10px 0;
    }
</style>
</head>

<body>
    <div class="tabs">
        <div class="tab active" onclick="showMenu('starters')">Starters</div>
        <div class="tab" onclick="showMenu('breakfast')">Breakfast</div>
        <div class="tab" onclick="showMenu('lunch')">Lunch</div>
        <div class="tab" onclick="showMenu('dinner')">Dinner</div>
    </div>

    <h1>Menu</h1>
    <div id="starters" class="menu active">
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Magnam Tiste">
            <h2>Magnam Tiste</h2>
            <p>Lorem, deren, trataro, filede, nerada</p>
            <div class="price">$5.95</div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Aut Luia">
            <h2>Aut Luia</h2>
            <p>Lorem, deren, trataro, filede, nerada</p>
            <div class="price">$14.95</div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Est Eligendi">
            <h2>Est Eligendi</h2>
            <p>Lorem, deren, trataro, filede, nerada</p>
            <div class="price">$8.95</div>
        </div>
    </div>

    <div id="breakfast" class="menu">
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Breakfast Item 1">
            <h2>Breakfast Item 1</h2>
            <p>Description of Breakfast Item 1</p>
            <div class="price">$9.95</div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Breakfast Item 2">
            <h2>Breakfast Item 2</h2>
            <p>Description of Breakfast Item 2</p>
            <div class="price">$12.95</div>
        </div>
    </div>

    <div id="lunch" class="menu">
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Lunch Item 1">
            <h2>Lunch Item 1</h2>
            <p>Description of Lunch Item 1</p>
            <div class="price">$11.95</div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Lunch Item 2">
            <h2>Lunch Item 2</h2>
            <p>Description of Lunch Item 2</p>
            <div class="price">$13.95</div>
        </div>
    </div>

    <div id="dinner" class="menu">
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Dinner Item 1">
            <h2>Dinner Item 1</h2>
            <p>Description of Dinner Item 1</p>
            <div class="price">$15.95</div>
        </div>
        <div class="item">
            <img src="https://via.placeholder.com/300" alt="Dinner Item 2">
            <h2>Dinner Item 2</h2>
            <p>Description of Dinner Item 2</p>
            <div class="price">$18.95</div>
        </div>
    </div>

</body>

<script>
    function showMenu(menuId) {
        // Hide all menus
        var menus = document.querySelectorAll('.menu');
        menus.forEach(function (menu) {
            menu.classList.remove('active');
        });

        // Remove active class from all tabs
        var tabs = document.querySelectorAll('.tab');
        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });

        // Show the selected menu
        document.getElementById(menuId).classList.add('active');

        // Add active class to the clicked tab
        event.target.classList.add('active');
    }
</script>


<?php include 'footer.php'; ?>