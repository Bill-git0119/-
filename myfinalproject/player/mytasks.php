<?php
include '../config.php';
include '../functions.php';
include 'header.php';
checkLogin();
$user_id = $_SESSION['user_id'];


if (isset($_GET['claim_id'])) {
    $task_id = intval($_GET['claim_id']);
    $check = mysqli_query($conn, "SELECT * FROM user_tasks WHERE user_id=$user_id AND task_id=$task_id AND status='completed' AND reward_claimed='no'");
    if (mysqli_num_rows($check) > 0) {
        $reward = mysqli_query($conn, "SELECT * FROM rewards WHERE task_id=$task_id");
        if ($r = mysqli_fetch_assoc($reward)) {
            mysqli_query($conn, "UPDATE users SET exp=exp+{$r['exp']}, coins=coins+{$r['coins']} WHERE id=$user_id");
            mysqli_query($conn, "UPDATE user_tasks SET reward_claimed='yes' WHERE user_id=$user_id AND task_id=$task_id");
            $_SESSION['message'] = "🎉 已領取獎勵！獲得 {$r['exp']} <b>經驗</b>、{$r['coins']} <b>金幣</b>";
            header("Location: mytasks.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "❗ 無可領取的獎勵";
        header("Location: mytasks.php");
        exit;
    }
}

$result = mysqli_query($conn, "
    SELECT ut.*, r.exp, r.coins
    FROM user_tasks ut
    JOIN rewards r ON ut.task_id = r.task_id
    WHERE ut.user_id = $user_id AND ut.status = 'completed' AND ut.reward_claimed = 'no'
");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的任務｜遊戲任務系統</title>
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
        .card {
            background-color: #16213e;
            border: 2px solid #00ffcc;
            border-radius: 18px;
            box-shadow: 0 4px 24px #0ff3c055;
        }
        .btn-game {
            background-color: #00ffcc;
            border: none;
            color: #1a1a2e;
            font-weight: bold;
            border-radius: 20px;
            transition: box-shadow 0.2s, background 0.2s;
            box-shadow: 0 2px 8px #00ffcc33;
        }
        .btn-game:hover {
            background-color: #00ccaa;
            color: #fff;
            box-shadow: 0 4px 12px #00ffcc66;
        }
        .list-group-item {
            background: #232343 !important;
            border: 1px solid #00ffcc22 !important;
            margin-bottom: 8px;
            border-radius: 16px !important;
            font-size: 18px;
            padding-top: 14px;
            padding-bottom: 14px;
        }
        .alert-success {
            background: linear-gradient(90deg, #00ffcc33, #003f5c33);
            border: 1px solid #00ffcc77;
            color: #009966;
            font-weight: bold;
        }
        .btn-outline-light {
            border-radius: 18px;
            margin: 0 6px;
            padding-left: 18px;
            padding-right: 18px;
        }
        @media (max-width: 600px) {
            .game-title { font-size: 22px; }
        }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width:680px;">
    <div class="game-title text-center">🎮 遊戲任務系統</div>
    <h2 class="text-center mb-4">🎯 我的任務</h2>
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success mt-3 text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <div class="card p-4 mb-4">
        <?php if(mysqli_num_rows($result) == 0): ?>
            <div class="text-center text-secondary pb-2" style="font-size:18px;">目前沒有可以領取的任務～</div>
        <?php endif; ?>
        <ul class="list-group">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <b>📋 任務ID: <?= $row['task_id'] ?></b>
                    <span class="badge bg-success ms-2"><?= htmlspecialchars($row['status']) ?></span>
                    <span class="text-success ms-3">(+<?= $row['exp'] ?>經驗, +<?= $row['coins'] ?>金幣)</span>
                </span>
                <a href="?claim_id=<?= $row['task_id'] ?>" class="btn btn-game btn-sm">領取獎勵</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="board.php" class="btn btn-outline-light">← 回任務看板</a>
        <a href="history.php" class="btn btn-outline-light">📜 查看歷史紀錄</a>
    </div>
</div>
</body>
</html>






