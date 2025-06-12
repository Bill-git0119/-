

<?php
include '../config.php';
include '../functions.php';
include "header.php"; 
checkLogin();
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM user_tasks WHERE user_id=$user_id AND status='completed'");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>遊戲任務系統</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #1a1a2e;
        color: #eaeaea;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .game-title {
        font-size: 32px;
        font-weight: bold;
        color: #00ffcc;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px #000;
    }
    .btn-game {
        background-color: #00ffcc;
        border: none;
        color: #1a1a2e;
    }
    .btn-game:hover {
        background-color: #00ccaa;
    }
    .card {
        background-color: #16213e;
        border: 1px solid #00ffcc;
    }
    a { color: #00ffcc; }
</style>

</head>
<body class="d-flex flex-column align-items-center">
<div class="container mt-4">
<div class="game-title text-center">🎮 遊戲任務系統</div>

<h2>歷史任務</h2>
<ul class="list-group">
<?php while ($row = mysqli_fetch_assoc($result)): ?>
    <li class="list-group-item bg-dark text-light">✅ 任務ID: <?= $row['task_id'] ?>，檔案: <?= basename($row['upload_file_path']) ?></li>
<?php endwhile; ?>
</ul>
<a href="board.php" class="btn btn-link mt-4">回任務看板</a>

</div></body></html>
