<?php
// File: admin/chat.php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: authentication/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    $sender = $_SESSION['admin_username'];
    $stmt = $conn->prepare("INSERT INTO chat_messages (sender, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $sender, $message);
    $stmt->execute();
    exit();
}

$messages = $conn->query("SELECT * FROM chat_messages ORDER BY created_at DESC LIMIT 50");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="EUTOVA Admin Chat for real-time communication among administrators.">
    <meta name="keywords" content="EUTOVA, Admin Chat, Real-time Communication, Messages">
    <meta name="author" content="Eunice Kaiya, Towera Gundo, Christina Nkawihe & Chimwemwe Zuze">
    <link rel="icon" href="../images/logo.png">
    <link rel="stylesheet" href="../style/chat.css">


    <title>Admin Chat - EUTOVA</title>

    <script>
        function sendMessage(event) {
            event.preventDefault();
            const form = event.target;
            const input = form.message;

            if (!input.value.trim()) return;

            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'message=' + encodeURIComponent(input.value.trim())
            }).then(() => {
                input.value = '';
                location.reload();
            });
        }
    </script>
</head>
<body>
    <div class="chat-box">
        <div class="chat-header">Admin Chat - EUTOVA</div>
        <div class="messages">
            <?php while ($row = $messages->fetch_assoc()): ?>
                <div class="message">
                    <div class="sender"><?= htmlspecialchars($row['sender']) ?>:</div>
                    <div><?= htmlspecialchars($row['message']) ?></div>
                    <small><?= date('M d, H:i', strtotime($row['created_at'])) ?></small>
                </div>
            <?php endwhile; ?>
        </div>
        <form class="form-area" onsubmit="sendMessage(event)">
            <input type="text" name="message" placeholder="Type your message here...">
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
