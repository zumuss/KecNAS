<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>KECNAS | Giriş</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h1>KECNAS</h1>
        <p class="subtitle">Private NAS System</p>

        <?php if (!empty($error)): ?>
            <div class="alert"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
    <label>Kullanıcı Adı</label>
    <input type="text" name="username" required>
</div>

<div class="input-group">
    <label>Şifre</label>
    <input type="password" name="password" required>
</div>


            <button type="submit">Giriş Yap</button>
        </form>

        <p class="register-text">
            Hesabın yok mu? <a href="register.php">Kayıt Ol</a>
        </p>

    </div>
</div>

</body>
</html>
