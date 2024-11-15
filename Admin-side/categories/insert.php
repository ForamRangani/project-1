<?php

    include("../config/conn.php");

    $name = $_POST['name'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Step 3: Insert the Data into the Database
            $sql = "INSERT INTO categories (name) VALUES ('$name')";
            $result = $conn->query($sql);

            header("location:index.php");

            // if ($conn->query($sql) === TRUE) {
             // echo "New record created successfully";
             
        }
        
        // Step 4: Close the Database Connection
        $conn->close();
        ?>
        
