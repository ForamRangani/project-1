<?php
// Include the database connection file
include ("../config/conn.php");

// Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the category
    $sql = "DELETE FROM categories WHERE id = $id";

    // Execute the query and check if the deletion was successful
    if ($conn->query($sql) === TRUE) {
        echo "Category deleted successfully";
    } else {
        echo "Error deleting category: " . $conn->error;
    }

    $conn->close();

    // Redirect back to the main page
    header("Location: index.php");
    exit();
}
// else {
//     echo "No ID provided.";
//     exit();
// }
?>
