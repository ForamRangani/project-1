<?php
include ("../config/conn.php");

session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Registration process
    if (isset($_POST['register'])) {
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $query = "SELECT * FROM admin_login WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $message = "Email already exists. Please use a different email.";
        } else {
            $query = "INSERT INTO admin_login (email, password) VALUES ('$email', '$password')";
            if (mysqli_query($conn, $query)) {
                $message = "Admin registered successfully! You can now log in.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        }
    } 
    
    // Login process
    elseif (isset($_POST['login'])) {
        $query = "SELECT * FROM admin_login WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Debugging output to check what's being returned
            echo "<pre>";
            print_r($row);
            echo "</pre>";

            if (password_verify($password, $row['password'])) {
                echo "Password verification successful!";
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_email'] = $row['email'];
                // header("Location: admin_dashboard.php");
                exit;
            } else {
                echo "Password verification failed.";
                var_dump($password);
                var_dump($row['password']);
                $message = "Invalid password.";
            }
        } else {
            $message = "Invalid email.";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login and Registration</title>
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
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Login and Registration</h1>
        <div class="message"><?php echo $message; ?></div>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="register">Register</button>
            </div>
            <div class="form-group">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
