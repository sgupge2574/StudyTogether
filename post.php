<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $datetime = $_POST['datetime'] ?? '';

    if ($title && $content && $datetime) {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, datetime) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $title,
            $content,
            $datetime
        ]);
        header('Location: list.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勉強会投稿</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="post.php">投稿</a> |
    <a href="list.php">一覧</a> |
    <a href="logout.php">ログアウト</a>
</nav>
<div class="container">
    <h1>勉強会投稿</h1>
    <form method="post">
        <label for="title">タイトル:</label>
        <input type="text" id="title" name="title" required>

        <label for="content">内容:</label>
        <textarea id="content" name="content" required></textarea>

        <label for="datetime">集合日時:</label>
        <input type="datetime-local" id="datetime" name="datetime" required>

        <button type="submit" class="center-button">投稿する</button>
        <div class="footer-buttons">
            <a href="list.php" class="button-link">勉強会一覧へ</a>
            <a href="logout.php" class="button-link">ログアウト</a>
        </div>
    </form>
    
</div>
</body>
</html>
