<?php
include '../config.php';
include '../functions.php';
include 'header.php';
checkLogin();
$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "
    SELECT t.* 
    FROM tasks t
    LEFT JOIN user_tasks ut ON ut.task_id = t.id AND ut.user_id = $user_id
    WHERE ut.status IS NULL OR ut.status != 'completed'
");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>遊戲任務系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; }
        .game-title { font-size: 32px; font-weight: bold; color: #00ffcc; margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }
        .card { background-color: #16213e; border: 1px solid #00ffcc; }
        .btn-game { background-color: #00ffcc; border: none; color: #1a1a2e; }
        .btn-game:hover { background-color: #00ccaa; }
        a { color: #00ffcc; }
    </style>
</head>
<body class="d-flex flex-column align-items-center">
<div class="container mt-4">
    <div class="game-title text-center">🎮 遊戲任務系統</div>
    <h2 class="text-center mb-4">📋 任務看板</h2>
    <div class="card p-4 mb-4">
        <ul class="list-group">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                🎯 <?= htmlspecialchars($row['title']) ?>
                <a href="task_detail.php?id=<?= $row['id'] ?>" class="btn btn-game btn-sm">查看</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="mytasks.php" class="btn btn-outline-light mx-2">🎯 我的任務（領取獎勵）</a>
        <a href="shop.php" class="btn btn-warning mx-2">🛒 前往商城</a>
        <a href="my_items.php" class="btn btn-info mx-2">🎁 查看我的物品</a>
        <a href="../logout.php" class="btn btn-link mx-2">登出</a>
    </div>
</div>
</body>
</html>




