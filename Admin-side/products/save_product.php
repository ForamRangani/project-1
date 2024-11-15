<?php
include ("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d H:i:s');

    // Handling the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($image['name']);

        // Ensure the uploads directory exists
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $imageData = addslashes(file_get_contents($targetFile));
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        echo "Image is required.";
        exit;
    }

    $sql = "INSERT INTO products (name, price, stock_quantity, description, image, created_at)
            VALUES ('$name', '$price', '$stock_quantity', '$description', '$imageData', '$created_at')";

    if (mysqli_query($conn, $sql)) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    header('Location: product_list.php');
}
?>
