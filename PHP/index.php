<?php
session_start();

include 'header.php';

?>
<div class="container">

    <section class="hero">
        <div class="hero-content p-4 p-lg-5 px-lg-4">
            <h1>Discover the Best Dining Experiences</h1>
            <p>Explore our diverse selection of top-rated restaurants and book your unforgettable culinary adventure
                today.
            </p>
            <div class="button-container index-btn-container d-flex justify-content-center text-center">
                <button class="btn btn-primary p-2" id="index-btn" onclick="bookRestaurant()">Book a Table</button>
            </div>
        </div>
        <div class="hero-image">
        </div>
    </section>
</div>

<script>

    function bookRestaurant() {
        const restaurantsPageLink = "http://localhost/resto/PHP/restaurants.php";
        // Redirect to the booking link
        window.location.href = restaurantsPageLink;
    }

</script>

<?php include 'footer.php'; ?>