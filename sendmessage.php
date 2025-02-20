<?php
// send_message.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sender_id = $_SESSION['user_id'];
    $receiver_id = intval($_POST['receiver_id']);
    $message = trim($_POST['message']);
    
    if($message == ""){
        die("Empty message");
    }
    
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    if($stmt->execute()){
        echo "Message sent";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
