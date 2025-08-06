<?php
session_start();

// Include DB config
$configFile = '../includes/config.php';
if (!file_exists($configFile)) {
    die("Required configuration file missing.");
}
include($configFile);
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashedPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['admin_id'] = $id;
                header("Location: ../admin/ecnk.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
  <link rel="icon" type="image/png" href="../images/logo.png">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to left, #000000ff, #f578acff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        keyframes fadeIn {
            from { opacity: 0;transform : translateY(-20px); }
            to { opacity: 1;transform : translateY(0); }
        }
        .box {
            width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .box img {
            width: 70pxpx;
            height: 20px;
        }
        .box h2 {
            margin-bottom: 20px;
        }
        .box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .box button {
            width: 100%;
            padding: 10px;
            background-color: #f578acff;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>  
</head>
<body>
<div class="box">
    <img src="../images/logo.png" alt="Logo">
    <h2>Admin Login</h2>
    <?php
    if (isset($_GET['error'])) {
        echo '<p style="color:red ;">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <div class="btn-row">
        <p class="login-link">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>