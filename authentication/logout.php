<?php
session_start();
// Include DB config
$configFile = '../includes/config.php';
if (!file_exists($configFile)) {
    die("Required configuration file missing.");
}
include($configFile);
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: login.php?logout=1"); // Redirect to login page with logout message
exit(); // Ensure no further code is executed
// Note: The above code assumes that the login.php file handles the 'logout' query parameter to display a logout success message.
// If you want to display a message after logout, you can handle it in login.php
// For example, you can check if 'logout' is set in the query string and display a message accordingly.
// This code will log out the user by destroying the session and redirecting them to the login page.
// The session_start() at the beginning is necessary to access session variables.
// The config file is included to ensure the database connection is available if needed in the future.
// The session_unset() function clears all session variables, and session_destroy() deletes the session
// The header function is used to redirect the user to the login page after logging out.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="icon" type="image/png" href="../images/logo.png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to left, #000000ff, #f578acff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .message {
            color: #fff;
            font-size: 24px;
        }
    </style>    

</head>
<body>
    <div class="message">
        You have been logged out successfully. Redirecting to login page...
    </div>
    <script>
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000); // Redirect after 2 seconds
    </script>
</body>
</html>