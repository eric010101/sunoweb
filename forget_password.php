<?php
require 'db.php'; // 包含数据库连接的文件

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $new_password = $user['email']; // 假设初始密码为email
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE username = ?');
        $stmt->execute([$hashed_password, $username]);

        echo 'Your password has been reset to your email address.';
    } else {
        echo 'No such user found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <button type="submit">Reset Password</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>
</body>
</html>
