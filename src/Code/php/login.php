<?php
session_start();

require 'db.php';

$error = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Find the admin by username
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if admin exists and password is correct
    // password_verify - Reference: PHP Group (2024) https://www.php.net/manual/en/function.password-hash.php
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: ../admin.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <header>
        <h1>Admin Login</h1>
        <p>Community Events Portal</p>
    </header>

    <main class="login-main">
        <div class="login-box">
            <h2>Sign In</h2>

            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Login">
            </form>

            <p><a href="../index.php">Back to Public Site</a></p>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Community Events Portal</p>
    </footer>

</body>
</html>