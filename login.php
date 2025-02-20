<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp Clone - Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #e9ebee; }
        .container { width: 300px; margin: 100px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 5px 0 10px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { width: 100%; padding: 10px; background: #25d366; border: none; color: #fff; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background: #20c159; }
        .link { text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="process_login.php" method="post">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="submit" value="Login">
    </form>
    <div class="link">
        <a href="signup.php">Don't have an account? Signup</a>
    </div>
</div>
</body>
</html>
