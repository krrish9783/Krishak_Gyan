<?php

// Establish a database connection
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = 'Krishna@123';
$dbName = 'users';

$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Sanitize user input (to prevent SQL injection, use prepared statements)
    $user = mysqli_real_escape_string($conn, $user);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Query the database to check if the user exists and the password is correct
    $query = "SELECT * FROM details WHERE user = '$user' AND pass = '$pass'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if a matching user is found
    if (mysqli_num_rows($result) == 1) {
        // User is authenticated; perform the login action (e.g., set session variables)
        session_start();
        $_SESSION['username'] = $user;

        // Redirect to the home.html page
        header("Location: home.html");
        exit; // Ensure script execution stops here
    } else {
        // Authentication failed; display an error message
        echo "<div style=' text-align:center; margin-top:20%; font-size:60px; color:red;'>Invalid username or password. Please try again !!</div>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
