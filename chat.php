<?php
// chat.php
include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Retrieve contacts (all users except the current user)
$user_id = $_SESSION['user_id'];
$contacts = [];
$result = $conn->query("SELECT id, name, unique_number FROM users WHERE id != $user_id");
while($row = $result->fetch_assoc()){
    $contacts[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone - Chat</title>
    <style>
        /* Overall page styling */
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f0f0f0; }
        .container { display: flex; height: calc(100vh - 120px); }

        /* Header styling */
        .header {
            background: #075e54;
            color: #fff;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        .header-text {
            display: flex;
            flex-direction: column;
        }
        .chat-title {
            font-size: 18px;
            font-weight: bold;
        }
        .unique-number {
            font-size: 12px;
        }
        .header-right {
            display: flex;
            align-items: center;
        }
        .header-btn {
            background: transparent;
            border: none;
            margin-left: 10px;
            cursor: pointer;
            padding: 5px;
            transition: transform 0.2s;
        }
        .header-btn:hover {
            transform: scale(1.1);
        }
        .header-btn svg { display: block; }
        .profile-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        /* Contacts list styling */
        .contacts {
            width: 30%;
            background: #fff;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }
        .contact {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background 0.3s;
        }
        .contact:hover { background: #f5f5f5; }
        .search-box { padding: 10px; border-bottom: 1px solid #ddd; }
        .search-box input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 20px; }
        
        /* Chat window styling */
        .chat-window {
            width: 70%;
            display: flex;
            flex-direction: column;
        }
        .messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #e5ddd5;
        }
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            max-width: 60%;
            word-wrap: break-word;
        }
        .sent { background: #dcf8c6; margin-left: auto; }
        .received { background: #fff; margin-right: auto; }
        .input-area {
            padding: 10px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
        }
        .input-area input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        .input-area button {
            padding: 10px 15px;
            margin-left: 10px;
            background: #075e54;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .input-area button:hover { background: #064d48; }
    </style>
</head>
<body>
    <!-- New Header with WhatsApp Logo, Call/Video/Profile Buttons -->
    <div class="header">
        <div class="header-left">
            <!-- WhatsApp logo embedded via base64 (replace with your own if desired) -->
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB+0lEQVR4nO2YsU3DMBBF2xEWELcBPQUW0A3QDtQBPQLFA3QDtQDPoRTQlKXxvYISkG7FfjTmzKy4MJ6M7m+HeSG8J4u1HH+vvO52ZoAWqj9V1ttjXwL32WW7AqVX+6V1nzjyae/kaDuY5F/7VghlPOZjtWXeXYSmyCX8hWyxOErwD3zEFoGfkxBL0M3hDoLObwkuIF8DO04EcIZ+QBnoTHAicUR6Ax4DxAB3IR6LPIBWAxF3oTBC1ICvI2YBpQUPkAH6PxF0GvoBdaG+xGvslOhz1I8hCOA3+1S05Rf4EpC8vMZtVgWDxGxsEGNPRmoSChlKKSJZHpCOgH7CdqFyN4jhQgqTkEkHL48wQ9Rir0a3pFPClGmNwL6Gr7eAP6hD8U35lSGZRV8BVXfCZcHfgpH9Jdgp1f8gZcHfh5z1I8g7a2YDpDfsXkD6gPfGLlN8Dr8Bu42BtyEc/GM0DrkHmJZ4g5QK+u+X0g0a3EdV1DwHR62bDRp3l9it5nUJvtP0frYBj6BuK9m/C6wNj28J1vM6C6QH9IxN0TvW2BOsF0p9L2zSg+hvlfUT3IVrso1flNVxj+yxbwK9Mf8ez2m4f0j3hOsJf53EDtdRfxFG7TH2Rpx0QpJ7Sf2iC7Qb+EZ+RveCkPnAv6e5qLwG6/QAAAABJRU5ErkJggg==" alt="WhatsApp Logo" class="logo">
            <div class="header-text">
                <span class="chat-title">WhatsApp Clone</span>
                <span class="unique-number"><?php echo $_SESSION['unique_number']; ?></span>
            </div>
        </div>
        <div class="header-right">
            <!-- Call Button -->
            <button class="header-btn" id="call-btn" title="Call" onclick="window.location.href='call.php'">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#fff" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.68,14.91 16.06,14.82 16.41,14.94C17.55,15.3 18.75,15.5 20,15.5C20.55,15.5 21,15.95 21,16.5V20C21,20.55 20.55,21 20,21C10.61,21 2,12.39 2,3C2,2.45 2.45,2 3,2H6.5C7.05,2 7.5,2.45 7.5,3C7.5,4.25 7.7,5.45 8.06,6.59C8.17,6.94 8.08,7.32 7.81,7.59L6.62,8.78Z"/>
                </svg>
            </button>
            <!-- Video Call Button -->
            <button class="header-btn" id="video-btn" title="Video Call" onclick="window.location.href='video_call.php'">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#fff" d="M17 10.5V6c0-1.1-.9-2-2-2H3C1.9 4 1 4.9 1 6v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4.5l4 4v-11l-4 4z"/>
                </svg>
            </button>
            <!-- Profile Button -->
            <button class="header-btn" id="profile-btn" title="Profile" onclick="window.location.href='profile.php'">
                <img src="profile.png" alt="Profile" class="profile-img">
            </button>
        </div>
    </div>
    
    <div class="container">
        <div class="contacts">
            <div class="search-box">
                <input type="text" id="search" placeholder="Search by unique number">
            </div>
            <?php foreach($contacts as $contact): ?>
                <div class="contact" data-id="<?php echo $contact['id']; ?>" data-unique="<?php echo $contact['unique_number']; ?>">
                    <strong><?php echo $contact['name']; ?></strong><br>
                    <small><?php echo $contact['unique_number']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-window">
            <div class="messages" id="chat-messages">
                <!-- Chat messages will load here -->
            </div>
            <div class="input-area">
                <input type="text" id="message-input" placeholder="Type your message">
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    
    <script>
        let selectedContactId = null;
        
        // Handle contact click events
        document.querySelectorAll('.contact').forEach(contact => {
            contact.addEventListener('click', function() {
                selectedContactId = this.getAttribute('data-id');
                // Highlight the selected contact
                document.querySelectorAll('.contact').forEach(c => c.style.background = '');
                this.style.background = '#e0e0e0';
                loadMessages();
            });
        });
        
        // Send message when button is clicked or Enter key is pressed
        document.getElementById('send-btn').addEventListener('click', function() {
            sendMessage();
        });
        
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        
        function sendMessage(){
            let message = document.getElementById('message-input').value.trim();
            if(message === ''){
                alert("Please enter a message.");
                return;
            }
            if(selectedContactId === null){
                alert("Please select a contact to chat with.");
                return;
            }
            
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function(){
                if(xhr.readyState === 4 && xhr.status === 200){
                    document.getElementById('message-input').value = '';
                    loadMessages();
                }
            };
            xhr.send('receiver_id=' + selectedContactId + '&message=' + encodeURIComponent(message));
        }
        
        function loadMessages(){
            if(selectedContactId === null) return;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_messages.php?contact_id=' + selectedContactId, true);
            xhr.onreadystatechange = function(){
                if(xhr.readyState === 4 && xhr.status === 200){
                    document.getElementById('chat-messages').innerHTML = xhr.responseText;
                    // Auto-scroll to the bottom of the chat
                    document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
                }
            };
            xhr.send();
        }
        
        // Poll for new messages every 2 seconds
        setInterval(function(){
            loadMessages();
        }, 2000);
        
        // Simple search by unique number
        document.getElementById('search').addEventListener('input', function(){
            let filter = this.value.toLowerCase();
            document.querySelectorAll('.contact').forEach(contact => {
                let unique = contact.getAttribute('data-unique').toLowerCase();
                if(unique.indexOf(filter) > -1){
                    contact.style.display = '';
                } else {
                    contact.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
