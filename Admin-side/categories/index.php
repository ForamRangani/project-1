<?php
// include ("../layouts/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 50%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .buttons {
            margin-bottom: 20px;
        }
        .buttons a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 8px 12px;
            border-radius: 5px;
            /* margin-right: 10px; */
        }
        .buttons a.edit {
            background-color: #FFA500;
        }
        .buttons a.delete {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <h1>Category Management</h1>

    <!-- Buttons for Create, Edit, Delete -->
    <div class="buttons">
        <a href="create.php" class="create">Create New Category</a>
    </div>

    <!-- Displaying data from the database -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>Actions</th>
        </tr>

        <?php
        // Include the database connection file
        include ("../config/conn.php");

        // Fetch data from the categories table
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['create_at'] . "</td>";
                echo "<td>" . $row['update_at'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='edit'>Edit</a>";
                echo " ";
                echo "<a href='delete.php?id=" . $row['id'] . "' class='delete'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        //  else {
        //     echo "<tr><td colspan='3'>No categories found</td></tr>";
        // }

        $conn->close();
        ?>

    </table>

</body>
</html>

