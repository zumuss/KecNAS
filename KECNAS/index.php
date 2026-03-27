<?php
// index.php: Ana sayfa
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - NAS System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Hoş geldiniz, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        

        <form method="POST" action="logout.php">
        <p><a href="view.php">Yüklediğiniz Dosyaları Görüntüleyin</a></p>
        <p><a href="upload.php">Yeni Dosya Yükleyin</a></p>
            <button type="submit">Çıkış Yap</button>
        </form>
    </div>
</body>
</html>
