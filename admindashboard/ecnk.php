<?php
// File: admin/dashboard.php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../authentication/login.php");
    exit();
}

// Fetch counts, Onetsetsani uti mwapanga ma ma tables amene akuoneka apa omwe inuyo mulibe ku Database kwanu
$jobCount = $conn->query("SELECT COUNT(*) FROM vacancy")->fetch_row()[0];
$scholarshipCount = $conn->query("SELECT COUNT(*) FROM scholarship")->fetch_row()[0];
$internshipCount = $conn->query("SELECT COUNT(*) FROM internship")->fetch_row()[0];
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="EUTOVA Admin Dashboard for managing jobs, scholarships, internships, and users.">
    <meta name="keywords" content="EUTOVA, Admin Dashboard, Jobs, Scholarships, Internships, Users">
    <meta name="author" content="Eunice Kaiya, Towera Gundo, Christina Nkawihe & Chimwemwe Zuze">
    <meta name="theme-color" content="#af4c9eff">


    <link rel="icon" href="../images/logo.png">
    <title>Admin Dashboard - EUTOVA</title>
    <link rel="stylesheet" href="../style/admin-style.css">
    

    <!-- JavaScript for Clock and Dark Mode, iyi ndi script imene izionetsa nthawi ku Dashboard kwanu-->
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString();
        }
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
        setInterval(updateClock, 1000);
        window.onload = updateClock;
    </script>

</head>
<body>
    <header>
        <h1>EUTOVA Admin Dashboard</h1>
        <div class="clock" id="clock"></div>
    </header>
    
<!-- Toolbar Section, apa ndipamene pali button loikira mdima komanso chat ya ku future komanso logout-->
    <div class="toolbar">
        <button class="toggle-btn" onclick="toggleDarkMode()">Toggle Dark Mode</button>
        <button class="chat-btn" onclick="window.location.href='chat.php'">Admin Chat</button>
        <button class="logout-btn" onclick="window.location.href='../authentication/logout.php'">Logout</button>
    </div>

<!-- Navigation Section, apa ndi pamene mukhoza kumaonjezera komanso kusankha zochitika ku dashboard zimene mukufuna
 izizi mukuyenera kuti mukhale ndi ma file amene aikidwa kuti muziti mukadina izikupititsani ku file imeneyoyo
 kukapanga zimene mwasankha kuti mukapange pa nthawi imeneyoyo-->
    <nav>
        <select onchange="if (this.value) window.location.href=this.value">
            <option value="">-- Manage Content --</option>
            <option value="manage-jobs.php">Manage Jobs</option>
            <option value="manage-scholarships.php">Manage Scholarships</option>
            <option value="manage-internships.php">Manage Internships</option>
            <option value="manage-users.php">Manage Users</option>
        </select>
    </nav>

<!-- Dashboard Section, apa ndi pamene pazilandira ma figure ochokera ku database motengerana ndi zimene zatumizidwa ndi anthu kapena admin-->
    <div class="dashboard">
        <div class="stats">
            <div class="card">Jobs<br><strong><?= $jobCount ?></strong></div>
            <div class="card">Scholarships<br><strong><?= $scholarshipCount ?></strong></div>
            <div class="card">Internships<br><strong><?= $internshipCount ?></strong></div>
            <div class="card">Users<br><strong><?= $userCount ?></strong></div>
        </div>

<!---- Actions Section , apa ndi posankhira koma poyuza ma button osati drop down menu---->
        <div class="actions">
            <a href="manage-jobs.php">Manage Jobs</a>
            <a href="manage-scholarships.php">Manage Scholarships</a>
            <a href="manage-internships.php">Manage Internships</a>
            <a href="manage-users.php">Manage Users</a>
        </div>
    </div>
<!-- Iyi ndi footer yanu imene mukhoza kumapanga Edit chaka chikakhala kuti chatha komanso mukakhala kuti mukuonjezera zinthu ku footer yanu-->
    <footer>
        &copy; EUTOVA 2025 Admin Dashboard v1.0 | Developed by Eunice Kaiya, Towera Gundo, Christina Nkawihe & Chimwemwe Zuze
    </footer>
</body>
</html>
