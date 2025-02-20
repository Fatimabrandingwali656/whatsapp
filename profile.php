<?php
// profile.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id = $user_id LIMIT 1");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone - Profile</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .profile-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
        .profile-container img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
        .profile-container h2 { margin: 10px 0; }
        .profile-container p { color: #555; }
        .profile-container button { padding: 10px 20px; background: #075e54; border: none; color: #fff; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="profile.png" alt="Profile Picture">
        <h2><?php echo htmlspecialchars($user['name']); ?></h2>
        <p>Unique Number: <?php echo htmlspecialchars($user['unique_number']); ?></p>
        <button onclick="window.location.href='chat.php'">Back to Chat</button>
    </div>
</body>
</html>
