<?php
// upload.php: Dosya yükleme
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $filename = $file['name'];
    $filepath = 'uploads/' . basename($filename);

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $stmt = $pdo->prepare("INSERT INTO files (user_id, filename, filepath) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $filename, $filepath]);
        echo "<div class='alert'>Dosya yüklendi!</div>";
    } else {
        echo "<div class='alert'>Dosya yükleme başarısız.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosya Yükle - NAS System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dosya Yükle</h1>
        <form method="POST" enctype="multipart/form-data" action="upload.php">
            <input type="file" name="file" required>
            <button type="submit">Dosya Yükle</button>
        </form>
    </div>
</body>
</html>
