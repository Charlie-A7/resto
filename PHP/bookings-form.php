<?php
session_start();

include 'db_connection.php';
include 'header.php';

?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-lg-10 col-xl-8" id="container-bookingForm">
                <h1 class="text-center mt-5">RESERVATION</h1>
                <h2 class="text-center mb-4">Book a Table</h2>

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
                    <button type="submit" class="btn btn-book" id="bookAtable-btn">
                        Book a Table
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>