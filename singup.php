<?php
// process_signup.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    
    if ($name == "" || $password == "") {
        die("Name and password are required.");
    }
    
    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user (without the unique_number for now)
    $stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $hashed_password);
    
    if ($stmt->execute()) {
        // Retrieve the last unique number from the database
        $result = $conn->query("SELECT unique_number FROM users WHERE unique_number IS NOT NULL ORDER BY id DESC LIMIT 1");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Extract the numeric part from the unique number (after the dash)
            $lastNumber = intval(substr($row['unique_number'], strpos($row['unique_number'], '-') + 1));
            $newNumber = $lastNumber + 1;
        } else {
            // First user: start at 1001
            $newNumber = 1001;
        }
        // Create the unique number with the custom country code prefix
        $unique_number = "+786-" . $newNumber;
        
        // Update the user record with the generated unique_number
        $user_id = $conn->insert_id;
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
