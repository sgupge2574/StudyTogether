<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $_POST['team_name'] ?? '';
    $name = $_POST['name'] ?? '';

    if (!empty($team_name)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, team_name) VALUES (?, ?)");
        $stmt->execute([ $name, $team_name]);
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>StudyTogether</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>新規登録</h1>
    <form method="post" class="login-form" >
        名前: <input type="text" name="name" required><br>
        チーム名: <input type="text" name="team_name" required><br>
        <button type="submit" class="center-button">登録する</button>
        <div class="footer-buttons">
            <a href="login.php"class="button-link">ログイン画面に戻る</a>
        </div>
    </form>
</div>
</body>
</html>