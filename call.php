<?php
// call.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone - Call</title>
    <style>
        body { font-family: Arial, sans-serif; background: #075e54; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .call-container { text-align: center; }
        .call-container button { padding: 10px 20px; background: #25d366; border: none; color: #fff; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="call-container">
        <h2>Calling...</h2>
        <p>Simulated call in progress.</p>
        <button onclick="window.location.href='chat.php'">End Call</button>
    </div>
</body>
</html>
