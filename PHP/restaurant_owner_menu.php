<?php
session_start();

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'owner') {
    header("Location: http://localhost/resto/PHP/login.php");
    exit();
}

include 'db_connection.php';

$restaurant_id = $_SESSION['restaurant_id'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        // Update item
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_description = $_POST['item_description'];
        $item_price = $_POST['item_price'];
        $item_type = $_POST['item_type'];

        $stmt = $conn->prepare("UPDATE menu SET item_name = ?, item_description = ?, item_price = ?, item_type = ? WHERE item_id = ?");
        $stmt->bind_param("ssdsi", $item_name, $item_description, $item_price, $item_type, $item_id);
        if ($stmt->execute()) {
            header("Location: http://localhost/resto/PHP/restaurant_owner_menu.php");
            exit();
        } else {
            echo "Error updating item.";
        }
        $stmt->close();
    } elseif (isset($_POST['add'])) {
        // Add new item
        $item_name = $_POST['item_name'];
        $item_description = $_POST['item_description'];
        $item_price = $_POST['item_price'];
        $item_type = $_POST['item_type'];

        $stmt = $conn->prepare("INSERT INTO menu (item_name, item_description, item_price, item_type, restaurant_id, status) VALUES (?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param("ssdsi", $item_name, $item_description, $item_price, $item_type, $restaurant_id);
        if ($stmt->execute()) {
            header("Location: http://localhost/resto/PHP/restaurant_owner_menu.php");
            exit();
        } else {
            echo "Error adding item.";
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $item_id = $_POST['item_id'];

        $stmt = $conn->prepare("UPDATE menu SET status = 'disabled' WHERE item_id = ?");
        $stmt->bind_param("i", $item_id);
        if ($stmt->execute()) {
            header("Location: http://localhost/resto/PHP/restaurant_owner_menu.php");
            exit();
        } else {
            echo "Error updating item status.";
        }
        $stmt->close();

    }
}


include 'header.php';

// Fetch menu items
$stmt = $conn->prepare("SELECT m.item_id, m.item_name, m.item_description, m.item_price, m.item_type
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


$stmt = $conn->prepare("SELECT phone_nb, website, name as restaurant_name FROM restaurants WHERE id = ?");
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$restaurantDetails = $stmt->get_result()->fetch_assoc();
$stmt->close();

$editItem = null;
if (isset($_POST['edit_form'])) {
    $item_id = $_POST['item_id'];

    $stmt = $conn->prepare("SELECT item_name, item_description, item_price, item_type FROM menu WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $editItem = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<div class="menu-container container">
    <div class="row mt-2 my-4">
        <h1 class="resto-name">
            <?php echo !empty($menuItems['starter']) ? htmlspecialchars($restaurantDetails['restaurant_name']) : ''; ?>
        </h1>
    </div>

    <?php foreach (['starter', 'meal', 'dessert', 'drinks'] as $type): ?>
        <div class="type1 row justify-content-center">
            <!-- <div class="col-12 col-md-4 type1-img">
                <img src="..\Images\Images\<?php echo $type; ?>1.jpg">
            </div> -->
            <div class="col-10 col-md-7 description1">
                <div>
                    <h2 class="menu-h2"><?php echo ucfirst($type); ?></h2>
                </div>
                <?php foreach ($menuItems[$type] as $item): ?>
                    <div class="row my-2 justify-content-center">
                        <div class="col-7 p-0">
                            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                            <h6><?php echo htmlspecialchars($item['item_description']); ?></h6>
                        </div>
                        <div class="col-3 price1">
                            <h5><?php echo htmlspecialchars($item['item_price']); ?>$</h5>
                        </div>
                        <!-- Edit and Delete Buttons -->
                        <div class="col-10 d-flex justify-content-center">
                            <div class="mx-2">
                                <form action="restaurant_owner_menu.php" method="post" style="display:inline;">
                                    <input type="hidden" name="item_id"
                                        value="<?php echo htmlspecialchars($item['item_id']); ?>">
                                    <button type="submit" name="edit_form" class="btn btn-warning">Edit</button>
                                </form>
                            </div>

                            <form id="deleteForm<?php echo $item['item_id']; ?>" method="post"
                                action="restaurant_owner_menu.php" style="display:inline;">
                                <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                <input type="submit" name="delete" value="Delete" class="btn btn-danger"
                                    onclick="confirmDelete(<?php echo $item['item_id']; ?>);">
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="contact-info row">
        <h5><a href="tel:<?php echo htmlspecialchars($restaurantDetails['phone_nb']); ?>"> 📞
                <?php echo htmlspecialchars($restaurantDetails['phone_nb']); ?> </a></h5>
        <h5><a href="http://<?php echo htmlspecialchars($restaurantDetails['website']); ?>"> 🌐
                <?php echo htmlspecialchars($restaurantDetails['website']); ?> </a></h5>
    </div>

</div>

<div class="button-wrapper d-flex justify-content-end mx-3 mx-md-5 my-1">
    <button type="button" class="show-modal-add-menu-item">+</button>
</div>


<!-- Add Item Form -->
<div class="container modal-add-menu-item hidden">
    <button class="close-modal-add-menu-item">&times;</button>
    <h2 class="text-center">Add New Item</h2>
    <div class="d-flex justify-content-center m-3">
        <form action="" method="post">
            <div class="form-group">
                <input type="text" id="item_name" name="item_name" placeholder="Item Name" required>
            </div>
            <div class="form-group">
                <textarea id="menu_item_description" name="item_description" placeholder="Item Description"
                    required></textarea>
            </div>
            <div class="form-group">
                <input type="number" id="item_price" name="item_price" step="0.01" placeholder="Item Price" required>
            </div>
            <div class="form-group">
                <select id="item_type" name="item_type" required>
                    <option value="starter">Starter</option>
                    <option value="meal">Meal</option>
                    <option value="dessert">Dessert</option>
                    <option value="drinks">Drinks</option>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-primary btn-add-menu-item">Add Item</button>
        </form>
    </div>
</div>

<div class="overlay-add-menu-item hidden"></div>

<!-- Edit Item Form -->
<?php if ($editItem): ?>
    <div class="container modal-edit-menu-item">
        <button class="close-modal">&times;</button>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Edit Item</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-10 col-md-5">
                <form action="restaurant_owner_menu.php" method="post">
                    <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($_POST['item_id']); ?>">
                    <div class="form-group">
                        <label for="item_name">Item Name:</label>
                        <input type="text" id="item_name" name="item_name"
                            value="<?php echo htmlspecialchars($editItem['item_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="item_description">Item Description:</label>
                        <textarea id="menu_item_description" name="item_description"
                            required><?php echo htmlspecialchars($editItem['item_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="item_price">Item Price:</label>
                        <input type="number" id="item_price" name="item_price" step="0.01"
                            value="<?php echo htmlspecialchars($editItem['item_price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="item_type">Item Type:</label>
                        <select id="item_type" name="item_type" required>
                            <option value="starter" <?php echo isset($editItem['item_type']) && $editItem['item_type'] === 'starter' ? 'selected' : ''; ?>>
                                Starter
                            </option>
                            <option value="meal" <?php echo isset($editItem['item_type']) && $editItem['item_type'] === 'meal' ? 'selected' : ''; ?>>
                                Meal
                            </option>
                            <option value="dessert" <?php echo isset($editItem['item_type']) && $editItem['item_type'] === 'dessert' ? 'selected' : ''; ?>>
                                Dessert
                            </option>
                            <option value="drinks" <?php echo isset($editItem['item_type']) && $editItem['item_type'] === 'drinks' ? 'selected' : ''; ?>>
                                Drinks
                            </option>
                        </select>
                    </div>
                    <button type="submit" name="edit" class="btn btn-warning">Update Item</button>
                </form>
            </div>
        </div>
    </div>

    <div class="overlay-edit-menu-item"></div>
<?php endif; ?>

<script>
    // modal for edit

    <?php if ($editItem): ?>
        document.body.style.overflow = 'hidden';
        const modalEdit = document.querySelector('.modal-edit-menu-item');
        const overlayEdit = document.querySelector('.overlay-edit-menu-item');
        const btnCloseModalEdit = document.querySelector('.close-modal');

        const closeModalEdit = function () {
            modalEdit.classList.add('hidden');
            overlayEdit.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };

        btnCloseModalEdit.addEventListener('click', closeModalEdit);
        overlayEdit.addEventListener('click', closeModalEdit);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modalEdit.classList.contains('hidden')) {
                closeModalEdit();
            }
        });

    <?php endif; ?>
    // modal for add

    const modalAdd = document.querySelector('.modal-add-menu-item');
    const overlayAdd = document.querySelector('.overlay-add-menu-item');
    const btnCloseModalAdd = document.querySelector('.close-modal-add-menu-item');
    const btnOpenModalAdd = document.querySelectorAll('.show-modal-add-menu-item');


    const openModalAdd = function () {
        modalAdd.classList.remove('hidden');
        overlayAdd.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeModalAdd = function () {
        modalAdd.classList.add('hidden');
        overlayAdd.classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    btnOpenModalAdd.forEach(btn => {
        btn.addEventListener('click', openModalAdd);
    });

    btnCloseModalAdd.addEventListener('click', closeModalAdd);
    overlayAdd.addEventListener('click', closeModalAdd);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modalAdd.classList.contains('hidden')) {
            closeModalAdd();
        }
    });

    // 
    function confirmDelete(itemId) {
        if (!confirm("Are you sure you want to delete this item?")) {
            event.preventDefault();
        }
    }
</script>


<?php include 'footer.php'; ?>