<?php
// Database Configuration
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = 'Krishna@123';
$dbName = 'users';

// Establish a database connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // Insert user registration data into the database
    $query = "INSERT INTO details (name, email, phone, user, pass) VALUES ('$name', '$email', '$phone', '$user', '$pass')";

    if (mysqli_query($conn, $query)) {
        // Registration successful
 echo "<div style='text-align:center; font-size:60px; margin-top:10%; color: #4CAF50;'>Registration successful. You can now <a style='color:red;' href='index.html' style='color: white;'>&#9733; log in</a>.</div>";
        
        // Add the image below the message
        echo "<div style='text-align:center;'><img src='cong2.gif' alt='Congratulations Image'></div>";
    } else {
        // Registration failed
        echo "<div style='background-color: #FF5733; color: white; padding: 10px;'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

