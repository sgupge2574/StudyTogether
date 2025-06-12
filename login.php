<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $_POST['team_name'] ?? '';
    $name = $_POST['name'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE team_name = ? AND name = ?");
    $stmt->execute([$team_name, $name]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['team_name'] = $user['team_name'];
        $_SESSION['name'] = $user['name'];
        header('Location: list.php');
        exit;
    } else {
        echo 'ログインに失敗しました';
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
    <h1>StudyTogether</h1>
<div class="container">
<h1>ログイン</h1>
<form method="post" class="login-form" >
    名前: <input type="text" name="name" required><br>
    チーム名: <input type="text" name="team_name" required><br>
    <button type="submit" class="center-button">ログイン</button>
</form>
    <div class="footer-buttons">
        <a href="register.php" class="button-link">初めての方はこちら</a>
    </div>
</div>
</body>
</html>