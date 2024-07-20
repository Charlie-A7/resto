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

?>

<body>
    <?php
    $restaurant_id = $_SESSION['restaurant_id'];
    $sql = "SELECT r.name as resto_name, m.item_id, m.item_name, m.item_description, m.item_price ,m.item_type
                FROM restaurants r 
                JOIN menu m ON r.id = m.restaurant_id
                WHERE r.id = $restaurant_id";
    $result = $conn->query($sql);
    $result1 = $conn->query($sql);
    $result2 = $conn->query($sql);
    if ($result->num_rows > 0) {
        $main_row = $result->fetch_assoc();
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-lg-10 col-xl-8" id="container-bookingForm">
                    <h1 class="text-center mt-5"><?php echo $main_row['resto_name']; ?></h1>
                    <h2 class="text-center mt-5">RESERVATION</h2>
                    <h3 class="text-center mb-4">Book a Table</h3>

                    <form method="POST" action="bookings_form_process.php">
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                <input type="date" class="form-control bookings-form-form-control" id="bookings-form-date"
                                    name="booking_date" required onchange="checkDate()" />
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <input type="time" class="form-control bookings-form-form-control" id="bookings-form-time"
                                    name="booking_time" required onchange="checkDate()" />
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <input type="number" class="form-control bookings-form-form-control" id="people"
                                    placeholder="# of people" name="num_people" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 form-group">
                                <textarea class="form-control bookings-form-form-control" id="message" rows="3"
                                    placeholder="Message" name="message"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id ?>">
                        <?php
                        while ($row2 = $result2->fetch_assoc()) {
                            if ($row2['item_type'] == 'starter') {
                                ?>
                                <input type="hidden" name="starter_ids[]" id="starterId_<?php echo $row2['item_id']; ?>" value="">
                                <input type="hidden" name="starter_quantities[]" id="starterQty_<?php echo $row2['item_id']; ?>"
                                    value="">
                                <?php
                            }
                        }
                        ?>
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="0.00">

                        <button type="button" class="btn btn-preorder show-modal" id="preorderStarters-btn">
                            Preorder Starters
                        </button>

                        <button type="submit" class="btn btn-book" id="bookAtable-btn">
                            Book a Table
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-1 hidden">
            <div class="container preorder-container">
                <button class="close-modal">&times;</button>
                <div class="row">
                    <div class="col-12 preorder-info">
                        <div class="col-12">
                            <h1 class="mb-3">Starters</h1>
                        </div>
                        <?php
                        while ($row1 = $result1->fetch_assoc()) {
                            if ($row1['item_type'] == 'starter') {
                                ?>
                                <div class="row my-2 justify-content-center">
                                    <div class="col-9 col-md-7">
                                        <h3><?php echo $row1['item_name']; ?></h3>
                                        <h6><?php echo $row1['item_description']; ?></h6>
                                    </div>
                                    <div class="col-3 col-md-2 col-lg-1 price1 m-0 d-flex align-items-center">
                                        <h5 class="m-0"><?php echo $row1['item_price']; ?>$</h5>
                                    </div>
                                    <div class="col-12 col-md-2 number-input justify-content-center">
                                        <button class="rounded"
                                            onclick="decrement(<?php echo $row1['item_id']; ?>,<?php echo $row1['item_price']; ?>)">-</button>
                                        <input type="number" id="numberField-<?php echo $row1['item_id']; ?>" value="0" disabled />
                                        <button class="rounded"
                                            onclick="increment(<?php echo $row1['item_id']; ?>,<?php echo $row1['item_price']; ?>)">+</button>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-3">
                        <h3>Total: <span id="modalTotalAmount">0.00</span>$</h3>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-10 col-md-4 d-flex justify-content-center">
                        <button type="button" class="rounded" id="confirm-starters">Confirm Starters</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="overlay-1 hidden"></div>

        <?php
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

    <?php include 'footer.php'; ?>

    <script>
        // disable/enable book a table button based on date
        function checkDate() {
            const bookingDateInput = document.getElementById('bookings-form-date');
            const bookingTimeInput = document.getElementById('bookings-form-time');
            const bookButton = document.getElementById('bookAtable-btn');

            const selectedDate = new Date(bookingDateInput.value);
            const selectedTimeParts = bookingTimeInput.value.split(':');
            const selectedDateTime = new Date(selectedDate);

            selectedDateTime.setHours(selectedTimeParts[0], selectedTimeParts[1]);

            const now = new Date();

            if (selectedDateTime < now) {
                bookButton.disabled = true;
            } else {
                bookButton.disabled = false;
            }
        }


        // modal functionality

        const modal = document.querySelector('.modal-1');
        const overlay = document.querySelector('.overlay-1');
        const btnCloseModal = document.querySelector('.close-modal');
        const btnsOpenModal = document.querySelectorAll('.show-modal');

        const openModal = function () {
            modal.classList.remove('hidden');
            overlay.classList.remove('hidden');
        };

        const closeModal = function () {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
        };

        for (let i = 0; i < btnsOpenModal.length; i++)
            btnsOpenModal[i].addEventListener('click', openModal);

        btnCloseModal.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        // modal functionality end

        let modalTotal = 0;
        let starterQuantities = {};

        function increment(id, price) {
            let numberField = document.getElementById(`numberField-${id}`);
            let currentValue = parseInt(numberField.value);
            if (currentValue < 9) {
                numberField.value = currentValue + 1;
                modalTotal += parseFloat(price);
                updateModalTotal();

                starterQuantities[id] = currentValue + 1;
            }
        }

        function decrement(id, price) {
            let numberField = document.getElementById(`numberField-${id}`);
            let currentValue = parseInt(numberField.value);
            if (currentValue > 0) {
                numberField.value = currentValue - 1;
                modalTotal -= parseFloat(price);
                if (modalTotal < 0) modalTotal = 0;
                updateModalTotal();

                starterQuantities[id] = currentValue - 1;
            }
        }

        function updateModalTotal() {
            document.getElementById('modalTotalAmount').innerText = modalTotal.toFixed(2);
        }


        // confirm starters

        document.getElementById('confirm-starters').addEventListener('click', function () {
            for (let id in starterQuantities) {
                document.getElementById(`starterId_${id}`).value = id;
                document.getElementById(`starterQty_${id}`).value = starterQuantities[id];
            };
            document.getElementById('totalAmountInput').value = modalTotal.toFixed(2);
            closeModal();
        });

        // end confirm starters
    </script>