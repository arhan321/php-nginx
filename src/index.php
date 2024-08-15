<?php
$host = '100.100.55.20';
$dbname = 'sample_login';
$user = 'root';
$pass = '123';
$port = 13307;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if (isset($_POST['logout'])) {
    setcookie('username', '', time() - 3600, "/"); 
    echo "Anda telah logout.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['logout'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $stmt = $pdo->query($sql);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {
        setcookie('username', $username, time() + (86400 * 30), "/"); 
        echo "Login berhasil! Selamat datang, " . htmlspecialchars($user['username']) . "!";
    } else {
        echo "Login gagal! Username atau password salah.";
    }
}

if (isset($_COOKIE['username'])) {
    echo "<p>Anda sudah login sebagai " . htmlspecialchars($_COOKIE['username']) . ".</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login Form</h2>
    <?php if (!isset($_COOKIE['username'])): ?>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" ><br><br>
            <input type="submit" value="Login">
        </form>
    <?php else: ?>
        <form action="" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>
    <?php endif; ?>
</body>
</html>
