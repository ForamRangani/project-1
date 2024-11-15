<?php
include ("../config/conn.php");

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Product List</title>';
echo '<style>';
echo 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }';
echo 'table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }';
echo 'table, th, td { border: 1px solid #ddd; }';
echo 'th, td { padding: 12px; text-align: left; }';
echo 'th { background-color: #f2f2f2; }';
echo 'img { max-width: 100px; height: auto; }';
echo '.actions a { margin-right: 10px; text-decoration: none; padding: 5px 10px; background-color: #007bff; color: white; border-radius: 4px; }';
echo '.actions a.delete { background-color: #dc3545; }';
echo '.actions a.create-category { background-color: #28a745; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<h1>Product List</h1>';
echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Description</th><th>Image</th><th>Actions</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['product_id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['price'] . '</td>';
    echo '<td>' . $row['stock_quantity'] . '</td>';
    echo '<td>' . $row['description'] . '</td>';
    echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" /></td>';
    echo '<td class="actions">
        <a href="edit_product.php?id=' . $row['product_id'] . '">Edit</a>
        <a class="delete" href="delete_product.php?id=' . $row['product_id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
    </td>';
    echo '</tr>';
}

echo '</table>';
echo '<div class="actions">';
// echo '<a class="create-category" href="create_category.php">Create New Category</a>';
echo '<a href="create_product.php" style="text-decoration:none;padding:10px 20px;background-color:#28a745;color:white;border-radius:4px;">Add New Product</a>';
echo '</div>';
echo '</body>';
echo '</html>';

mysqli_close($conn);
?>
