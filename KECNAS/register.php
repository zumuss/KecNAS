<?php
// register.php: Kullanıcı kaydı
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo "<div class='alert'>Kayıt başarılı! Şimdi giriş yapabilirsiniz.</div>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - NAS System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>KECNAS - Kayıt Ol</h1>
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required>
            <input type="password" name="password" placeholder="Parola" required>
            <button type="submit">Kaydol</button>
            <p>Hesabınız var mı? <a href="login.php">Giriş Yapın</a></p>
        </form>
       
    </div>
</body>
</html>
