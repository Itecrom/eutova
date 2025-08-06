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
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

 if (!$error) {
    // Check if username or email already exists
    $checkStmt = $conn->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $error = "Username or email is already registered.";
    } else {
        // Proceed to insert
        $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.php?success=1");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $checkStmt->close();
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin register</title>
    <link rel="icon" type="image/png" href="../images/logo.png">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to left, #000000ff, #f126f8ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #ffffff;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .box {
            background: #f126f8ff;
            padding: 30px;
            width: 400px;
            border-radius: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            text-align: center;
        }
        .box img {
            width: 70px;
            margin-bottom: 15px;
        }
        .box h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #e9e9e9;
            font-size: 15px;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        button.btn {
            background: #ffffffff;
            color: #f126f8ff; 
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #000000ff;
        }
        .login-link {
            font-size: 14px;
        }
        .login-link a {
            color: #000000ff;
            text-decoration: none;
        }
        footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
    </style>
</head>
<body>
<div class="box">
    <img src="../images/logo.png" alt="logo">
    <h2>Admin Register</h2>

    <?php
    // Display error message if exists 
    if (!empty($error)): ?>
        <p style="color: #000000ff;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>        
        <div class="btn-row">
            <button class="btn" type="submit">Register</button>
            <span class="login-link">Already have an account? <a href="login.php">Login</a></span>
        </div>
    </form>
</div>
</body>
</html>
