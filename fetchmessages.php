<?php
// fetch_messages.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    die("Unauthorized");
}
if(isset($_GET['contact_id'])){
    $contact_id = intval($_GET['contact_id']);
    $user_id = $_SESSION['user_id'];
    
    // Retrieve messages between the two users, ordered chronologically
    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY id ASC");
    $stmt->bind_param("iiii", $user_id, $contact_id, $contact_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()){
        $class = ($row['sender_id'] == $user_id) ? "sent" : "received";
        echo '<div class="message ' . $class . '">'. htmlspecialchars($row['message']) .'</div>';
    }
    $stmt->close();
} else {
    echo "No contact selected.";
}
?>
