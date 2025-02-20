<?php
// video_call.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone - Video Call</title>
    <style>
        body { font-family: Arial, sans-serif; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .video-call-container { text-align: center; }
        .video-call-container button { padding: 10px 20px; background: #25d366; border: none; color: #fff; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="video-call-container">
        <h2>Video Calling...</h2>
        <p>This is a simulated video call.</p>
        <button onclick="window.location.href='chat.php'">End Video Call</button>
    </div>
</body>
</html>
