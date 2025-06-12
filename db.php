<?php
// DB接続設定
$dsn = 'mysql:dbname=???;host=localhost';
$user = '???';
$password = '???';
try {
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
} catch (PDOException $e) {
    die("DB接続エラー: " . $e->getMessage());
}
?>