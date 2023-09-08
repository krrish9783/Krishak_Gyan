<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include the PHPMailer library
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Start a PHP session
session_start();

// Database connection
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = 'Krishna@123';
$dbName = 'users';

$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$email = '';
$newPassword = '';
$confirmPassword = '';
$otp = '';

// Step 1: Display the form to enter the email address
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>

    <!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="email"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="reset"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="reset"]:hover {
            background-color: red;
        }

        input[type="submit"]:hover {
            background-color: lime;
        }
         div {
         margin-top:15%;
         }
    </style>
</head>
<body>
<div>
    <h1>Forgot Password</h1>
    <form method="post">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <br>
        <input type="reset" value="clean">
        <input type="submit" value="Send OTP">
    </form></div>
</body>
</html>


    <?php
}

// Step 2: Handle form submission (when user submits their email)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's email from the form
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM details WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Email exists in the database
        // Generate and save OTP to a variable
        $otp = rand(100000, 999999);

        // Store OTP in a session variable for later verification
        $_SESSION['otp'] = $otp;

        // Send OTP via email
        $mail = new PHPMailer(true);

        try {
            // Server settings (use your email provider's settings)
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kishnuyadav783@gmail.com'; // Replace with your email address
            $mail->Password = 'yourpass'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('from@example.com', 'krishna');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #007bff;
                color: #fff;
                text-align: center;
                padding: 20px;
                border-radius: 10px 10px 0 0;
            }
            .content {
                padding: 20px;
            }
            .footer {
                background-color: #f5f5f5;
                padding: 20px;
                text-align: center;
                border-radius: 0 0 10px 10px;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            h3 {
                font-size: 28px;
                color: #007bff;
            }
            p {
                font-size: 16px;
                line-height: 1.5;
            }
            .team {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>OTP Notification</h2>
            </div>
            <div class="content">
                <p>Dear User,</p>
                <p>Your security is of utmost importance to us. Please do not share this OTP with anyone for security reasons:</p>
                <h3>Your OTP: ' . $otp . '</h3>
                <p>If you did not request this OTP, please disregard this message.</p>
                <p>Thank you for Connecting with Project KrishakGyan</p>
                <p>CS & IT, Jain University Bengaluru</p>
            </div>
            <div class="footer">
                <p>&copy; ' . date("Y") . ' Project KrishakGyan Jain University</p>
                <p class="team">Our Team: Kishnu Kumar, Bidhata Regmi, Syed Riyan, Ahmed Ali</p>
                <p>Mentor: Dr. Kavitha</p>
            </div>
        </div>
    </body>
    </html>
';
            $mail->send();
            echo "<br>An OTP has been sent to your email address. Please check your inbox.";

            // Display a form to reset the password
            ?>

           <!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Reset Password</h1>
    <form method="post">
        <input type="hidden" name="email" value="<?= $email ?>">
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required>
        <br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" required>
        <br>
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" required>
        <br>
        <input type="submit" name="reset" value="Reset Password">
    </form>
</body>
</html>


            <?php
        } catch (Exception $e) {
            echo "Error: OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "User data not found. Please check your email address.";
    }
}

// Step 3: Handle password reset (when user submits the new password and OTP)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    // Get the user's email, new password, and OTP from the form
    $email = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userOTP = $_POST['otp'];

    // Verify the OTP against the stored OTP in the session
    if (isset($_SESSION['otp']) && $userOTP == $_SESSION['otp']) {
        // OTP is correct, check if passwords match
        if ($newPassword == $confirmPassword) {
            // Passwords match, update the password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE details SET pass = '$hashedPassword' WHERE email = '$email'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                echo "Password reset successfully. <a href='index.html'>Click here to login</a>";
                // Clear the OTP from the session
                unset($_SESSION['otp']);
            } else {
                echo "Error updating password. Please try again later.";
            }
        } else {
            echo "Passwords do not match. Please try again.";
        }
    } else {
        echo "<br>Invalid OTP. Please try again.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

