<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Elegance</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; background: var(--dark-bg); }
        .login-card { max-width: 400px; width: 100%; text-align: center; }
        .login-card h2 { color: var(--accent-color); margin-bottom: 20px; }
        .error { color: #ffaaaa; margin-bottom: 15px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="glass-card login-card">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control" required placeholder="Username">
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
            <input type="password" name="password" class="form-control" required placeholder="Password">
        </div>
        <button type="submit" class="btn" style="width: 100%;">Login</button>
    </form>
    <p style="margin-top: 20px; color: var(--text-muted); font-size: 0.8rem;">Demo Credentials: admin / admin123</p>
</div>

</body>
</html>
