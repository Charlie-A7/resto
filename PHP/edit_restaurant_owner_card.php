<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $location = $_POST['location'];
    $price_range = $_POST['price_range'];
    $food_types = $_POST['food_types'];
    
    $target_dir = "../Images/Images/";
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $new_image_name = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_image_name;
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "UPDATE restaurants SET image_url = '$target_file', location = '$location', price_range = '$price_range', food_types = '$food_types' WHERE id = $restaurant_id";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        $sql = "UPDATE restaurants SET location = '$location', price_range = '$price_range', food_types = '$food_types' WHERE id = $restaurant_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
    header("Location: restaurant_owner_update_card.php");
    exit();
}
?>
