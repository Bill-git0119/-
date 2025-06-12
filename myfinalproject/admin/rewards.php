
<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");

if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $exp = $_POST['exp'];
    $coins = $_POST['coins'];
    $item_name = $_POST['item_name'];
    mysqli_query($conn, "INSERT INTO rewards (task_id, exp, coins, item_name) VALUES ($task_id, $exp, $coins, '$item_name') ON DUPLICATE KEY UPDATE exp=$exp, coins=$coins, item_name='$item_name'");
}
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

<h2>獎勵設定</h2>
<form method="POST" class="p-4 card">
    <input name="task_id" class="form-control mb-2" placeholder="任務ID" required>
    <input name="exp" class="form-control mb-2" placeholder="經驗" required>
    <input name="coins" class="form-control mb-2" placeholder="金幣" required>
    <input name="item_name" class="form-control mb-3" placeholder="道具名稱" required>
    <input type="submit" value="新增" class="btn btn-game w-100">
</form>
<a href="../logout.php" class="btn btn-link mt-4">登出</a>

</div></body></html>
