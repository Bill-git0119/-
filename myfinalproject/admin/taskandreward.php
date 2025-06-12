<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");

if (isset($_POST['add_task'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $deadline = $_POST['deadline'];
    mysqli_query($conn, "INSERT INTO tasks (title, description, deadline) VALUES ('$title','$desc','$deadline')");
}

if (isset($_GET['delete_task'])) {
    $tid = intval($_GET['delete_task']);
    mysqli_query($conn, "DELETE FROM user_tasks WHERE task_id = $tid");
    mysqli_query($conn, "DELETE FROM rewards WHERE task_id = $tid");
    if (mysqli_query($conn, "DELETE FROM tasks WHERE id = $tid")) {
        echo "<script>alert('已刪除任務！');location.href='taskandreward.php';</script>";
        exit;
    } else {
        echo "<script>alert('刪除失敗：".mysqli_error($conn)."');</script>";
    }
}

if (isset($_POST['add_reward'])) {
    $task_id = intval($_POST['task_id']);
    $exp = intval($_POST['exp']);
    $coins = intval($_POST['coins']);
    mysqli_query($conn, "INSERT INTO rewards (task_id, exp, coins) VALUES ($task_id, $exp, $coins)
      ON DUPLICATE KEY UPDATE exp=$exp, coins=$coins");
}
if (isset($_GET['delete_reward'])) {
    $rid = intval($_GET['delete_reward']);
    mysqli_query($conn, "DELETE FROM rewards WHERE id=$rid");
}

$tasks = mysqli_query($conn, "SELECT * FROM tasks ORDER BY id DESC");
$rewards = mysqli_query($conn, "
    SELECT r.*, t.title 
    FROM rewards r 
    JOIN tasks t ON r.task_id = t.id
    ORDER BY r.task_id DESC
");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>任務＋獎勵管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; }
        .game-title { font-size: 32px; font-weight: bold; color: #00ffcc; text-align:center; margin:24px 0 14px; text-shadow:2px 2px 4px #000; }
        .card { background-color: #16213e; border: 2px solid #00ffcc; border-radius: 18px; box-shadow: 0 4px 24px #0ff3c055; }
        .btn-game { background-color: #00ffcc; border: none; color: #1a1a2e; font-weight: bold; border-radius: 20px; transition: box-shadow 0.2s, background 0.2s; box-shadow: 0 2px 8px #00ffcc33;}
        .btn-game:hover { background-color: #00ccaa; color: #fff; box-shadow: 0 4px 12px #00ffcc66;}
        .list-group-item { background: #232343 !important; border: 1px solid #00ffcc22 !important; border-radius: 16px !important;}
        h3 { color:#00ffcc; margin-top:18px; }
        label { font-weight:bold; }
        .title-bright { color: #fff; font-size: 1.18em; font-weight:bold; letter-spacing:0.5px; }
        .reward-title-bright { color: #fff; font-size: 1.08em; font-weight:bold;}
    </style>
</head>
<body>
<div class="container mt-4" style="max-width:820px;">
    <div class="game-title">🎮 任務 & 獎勵管理</div>
    <div class="mb-4 d-flex justify-content-center gap-3">
        <a href="taskandreward.php" class="btn btn-game">📋 任務＋獎勵管理</a>
        <a href="shop_manage.php" class="btn btn-game">🛒 商品管理</a>
        <a href="players.php" class="btn btn-game">👤 玩家狀態</a>
        <a href="../logout.php" class="btn btn-game">登出</a>
    </div>
    <div class="card p-4 mb-4">
        <h3>📋 任務管理</h3>
        <form method="post" class="row g-2 mb-3">
            <div class="col-3"><input name="title" class="form-control" placeholder="標題" required></div>
            <div class="col-4"><input name="desc" class="form-control" placeholder="描述" required></div>
            <div class="col-3"><input type="date" name="deadline" class="form-control" required></div>
            <div class="col-2"><button name="add_task" class="btn btn-game w-100">新增</button></div>
        </form>
        <ul class="list-group">
        <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <b class="title-bright"><?= htmlspecialchars($t['title']) ?></b>
                    <small class="ms-2 text-secondary"><?= htmlspecialchars($t['description']) ?></small>
                    <small class="ms-2 text-info">截止日: <?= $t['deadline'] ?></small>
                </span>
                <a href="?delete_task=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('確定刪除任務？')">刪除</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    <div class="card p-4 mb-4">
        <h3>🎁 獎勵設定</h3>
        <form method="post" class="row g-2 mb-3">
            <div class="col-4">
                <select name="task_id" class="form-select" required>
                    <option value="">請選擇對應任務</option>
                    <?php
                    $tasks2 = mysqli_query($conn, "SELECT * FROM tasks");
                    while ($t2 = mysqli_fetch_assoc($tasks2)):
                    ?>
                        <option value="<?= $t2['id'] ?>"><?= htmlspecialchars($t2['title']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-3"><input name="exp" type="number" class="form-control" placeholder="經驗值" required></div>
            <div class="col-3"><input name="coins" type="number" class="form-control" placeholder="金幣" required></div>
            <div class="col-2"><button name="add_reward" class="btn btn-game w-100">新增/修改</button></div>
        </form>
        <ul class="list-group">
        <?php while ($r = mysqli_fetch_assoc($rewards)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    <b class="reward-title-bright"><?= htmlspecialchars($r['title']) ?></b>
                    <span class="badge bg-success ms-2">+<?= $r['exp'] ?> 經驗</span>
                    <span class="badge bg-warning ms-2">+<?= $r['coins'] ?> 金幣</span>
                </span>
                <a href="?delete_reward=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('確定刪除獎勵？')">刪除</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
</div>
</body>
</html>


