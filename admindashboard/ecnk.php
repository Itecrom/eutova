<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../authentication/login.php");
    exit();
}

// Include database config
include '../includes/config.php';

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT username FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($admin_name);
$stmt->fetch();
$stmt->close();

// Fetch some dashboard stats
$job_count = $conn->query("SELECT COUNT(*) AS total FROM vacancy")->fetch_assoc()['total'];
$scholarship_count = $conn->query("SELECT COUNT(*) AS total FROM scholarship")->fetch_assoc()['total'];
$user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | EUTOVA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .dashboard {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .welcome {
            background: #f578acff;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 1;
        }
        .card h2 {
            font-size: 30px;
            margin: 0 0 10px;
        }
        .card p {
            font-size: 16px;
            color: #555;
        }
        .logout {
            float: right;
            margin-top: -40px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="welcome">
            <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h1>
            <a class="logout" href="../authentication/logout.php" style="color:white; text-decoration: underline;">Logout</a>
            <p>Here's a quick overview of the EUTOVA platform.</p>
        </div>

        <div class="stats">
            <div class="card">
                <h2><?php echo $job_count; ?></h2>
                <p>Total Job Listings</p>
            </div>
            <div class="card">
                <h2><?php echo $scholarship_count; ?></h2>
                <p>Total Scholarships</p>
            </div>
            <div class="card">
                <h2><?php echo $user_count; ?></h2>
                <p>Registered Users</p>
            </div>
        </div>
    </div>
</body>
</html>
