<?php
include ("../config/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $description = $_POST['description'];

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
            $sql = "UPDATE products SET
                    name='$name',
                    price='$price',
                    stock_quantity='$stock_quantity',
                    description='$description',
                    image='$imageData'
                    WHERE product_id='$product_id'";
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        $sql = "UPDATE products SET
                name='$name',
                price='$price',
                stock_quantity='$stock_quantity',
                description='$description'
                WHERE product_id='$product_id'";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header('Location: product_list.php');
} else {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea,
        .form-group button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo $row['price']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity:</label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo $row['stock_quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" id="image" name="image">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" height="50" />
            </div>
            <div class="form-group">
                <button type="submit">Update Product</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
}
?>
