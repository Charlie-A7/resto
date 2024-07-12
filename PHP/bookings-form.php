<?php
session_start();

include 'db_connection.php';
include 'header.php';

?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-lg-10 col-xl-8" id="container-bookingForm">
                <h1 class="text-center mt-5">SUD</h1>
                <h2 class="text-center mt-5">RESERVATION</h2>
                <h3 class="text-center mb-4">Book a Table</h3>

                <form>
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <input type="date" class="form-control bookings-form-form-control"
                                id="bookings-form-date" />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="time" class="form-control bookings-form-form-control"
                                id="bookings-form-time" />
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <input type="number" class="form-control bookings-form-form-control" id="people"
                                placeholder="# of people" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <textarea class="form-control bookings-form-form-control" id="message" rows="3"
                                placeholder="Message"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-preorder" id="preorderStarters-btn">
                        Preorder Starters
                    </button>

                    <button type="submit" class="btn btn-book" id="bookAtable-btn">
                        Book a Table
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="container preorder-container">
        <div class="row">
            <div class="col-12 col-md-4 preorder-image ">
                <img src="..\Images\Images\Caesar-Salad.jpg" class="fit-image">
            </div>
            <div class="col-8 col-md-5 preorder-info">
                <h1>Starters</h1>
                <h3>Caesar Salad</h3>
                <h5>Fresh romaine lettuce with Caesar dressing</h5>
            </div>
            <div class="number-input col-2">
                <button onclick="decrement()">-</button>
                <input type="number" id="numberField" value="0" disabled />
                <button onclick="increment()">+</button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function increment() {
            let numberField = document.getElementById('numberField');
            let currentValue = parseInt(numberField.value) + 1;
            if (currentValue < 10) {
                numberField.value = currentValue + 1;
            }
        }

        function decrement() {
            let numberField = document.getElementById('numberField');
            let currentValue = parseInt(numberField.value);
            if (currentValue > 0) {
                numberField.value = currentValue - 1;
            }
        }
    </script>