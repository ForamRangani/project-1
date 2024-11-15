<?php
include ("../config/conn.php");

$product_id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id='$product_id'";

if (mysqli_query($conn, $sql)) {
    echo "Product deleted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
header('Location: product_list.php');
?>
