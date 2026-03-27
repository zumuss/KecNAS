<?php
// view.php: Yüklenen dosyaları görüntüleme
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Dosya silme işlemi
if (isset($_GET['delete'])) {
    $file_id = $_GET['delete'];
    
    // Dosya bilgilerini al
    $stmt = $pdo->prepare("SELECT filepath FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$file_id, $user_id]);
    $file = $stmt->fetch();

    if ($file) {
        // Dosya sistemden sil
        unlink($file['filepath']);
        
        // Veritabanından dosyayı sil
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = ? AND user_id = ?");
        $stmt->execute([$file_id, $user_id]);

        echo "<div class='alert'>Dosya silindi!</div>";
    }
}

// Dosya ismini değiştirme işlemi
if (isset($_POST['rename']) && isset($_POST['file_id']) && isset($_POST['new_name'])) {
    $file_id = $_POST['file_id'];
    $new_name = $_POST['new_name'];
    
    $stmt = $pdo->prepare("UPDATE files SET filename = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$new_name, $file_id, $user_id]);

    echo "<div class='alert'>Dosya adı değiştirildi!</div>";
}

$stmt = $pdo->prepare("SELECT * FROM files WHERE user_id = ?");
$stmt->execute([$user_id]);
$files = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yüklenen Dosyalar - NAS System</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleRenameForm(fileId) {
            var form = document.getElementById('rename-form-' + fileId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Yüklediğiniz Dosyalar</h1>
        <?php if ($files): ?>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li>
                        <a href="<?php echo $file['filepath']; ?>" target="_blank"><?php echo htmlspecialchars($file['filename']); ?></a>
                        <a href="view.php?delete=<?php echo $file['id']; ?>" class="delete" onclick="return confirm('Bu dosyayı silmek istediğinizden emin misiniz?');">Sil</a>
                        <button type="button" onclick="toggleRenameForm(<?php echo $file['id']; ?>)">İsmi Değiştir</button>
                        
                        <!-- İsim Değiştirme Formu -->
                        <form method="POST" action="view.php" id="rename-form-<?php echo $file['id']; ?>" style="display:none;">
                            <input type="hidden" name="file_id" value="<?php echo $file['id']; ?>">
                            <input type="text" name="new_name" placeholder="Yeni isim" required>
                            <button type="submit" name="rename">İsmi Değiştir</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Henüz dosya yüklemediniz.</p>
        <?php endif; ?>
    </div>
</body>
</html>
