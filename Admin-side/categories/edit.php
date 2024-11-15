<?php
// Include the database connection file
include ("../config/conn.php");

// Initialize variables
$name = "";
$id = 0;

// Check if an ID was passed in the URL to load the form with existing data
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the category data
    $sql = "SELECT * FROM categories WHERE id = $id";
    $result = $conn->query($sql);

    // Check if the category exists
    if ($result->num_rows > 0) {
        // Get the data
        $row = $result->fetch_assoc();
        $name = $row['name'];
    } else {
        echo "No category found with this ID.";
        exit();
    }
}

// Check if the form has been submitted to update the category
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get the ID from the hidden input field
    $name = $_POST['name']; // Get the new name from the form input

    // Update the category name in the database
    $sql = "UPDATE categories SET name = '$name' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Category updated successfully";
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>

    <h1>Edit Category</h1>

    <!-- Form to edit the category -->
    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        <input type="submit" value="Update">
    </form>

</body>
</html>
