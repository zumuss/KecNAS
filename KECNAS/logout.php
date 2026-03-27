<?php
// logout.php: Çıkış işlemi
session_start();
session_destroy();
header('Location: login.php');
exit;
