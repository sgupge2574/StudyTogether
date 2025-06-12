<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$team_name = $_SESSION['team_name'] ?? '';

// 参加処理
if (isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO participants (user_id, post_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $post_id]);
}

// 投稿一覧取得（同じチーム名のユーザーによる投稿に限定）
$stmt = $pdo->prepare("SELECT posts.*, users.team_name, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE users.team_name = ? ORDER BY datetime DESC");
$stmt->execute([$team_name]);
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>StudyTogether</title>
    <link rel="stylesheet" href="style.css">
    <style>
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
<nav>
    <a href="post.php">投稿</a> |
    <a href="list.php">一覧</a> |
    <a href="logout.php">ログアウト</a>
</nav>

<div class="container">
    <h1>勉強会一覧</h1>

    <?php foreach ($posts as $post): ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
            <p><strong>投稿者:</strong> <?php echo htmlspecialchars($post['name']); ?></p>
            <p><strong>内容:</strong><br><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <p><strong>集合日時:</strong> <?php echo htmlspecialchars($post['datetime']); ?></p>

            <div class="participants">
                <strong>参加者:</strong><br>
                <?php
                $stmt_participants = $pdo->prepare("SELECT DISTINCT users.name FROM participants JOIN users ON participants.user_id = users.id WHERE participants.post_id = ?");
                $stmt_participants->execute([$post['id']]);
                $participants = $stmt_participants->fetchAll();
                foreach ($participants as $p) {
                    echo htmlspecialchars($p['name']) . '<br>';
                }
                ?>
            </div>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" class="center-button">参加する</button>
            </form>
        </div>
    <?php endforeach; ?>
    <div class="footer-buttons">
        <a href="post.php" class="button-link">勉強会投稿へ</a>
        <a href="logout.php" class="button-link">ログアウト</a>
    </div>
    
</div>
</body>
</html>