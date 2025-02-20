<?php
// process_signup.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    
    if($name == "" || $password == ""){
        die("Name and password are required.");
    }
    
    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user (unique_number will be added next)
    $stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $hashed_password);
    if($stmt->execute()){
        $user_id = $conn->insert_id;
        // Generate unique number: first user gets +786-1001, second +786-1002, etc.
        $unique_number = "+786-" . (1000 + $user_id);
        
        // Update the user record with the generated unique_number
        $stmt2 = $conn->prepare("UPDATE users SET unique_number = ? WHERE id = ?");
        $stmt2->bind_param("si", $unique_number, $user_id);
        $stmt2->execute();
        $stmt2->close();
        
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
