<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");
$result = mysqli_query($conn, "SELECT * FROM users WHERE role='player'");
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>玩家狀態一覽 | 遊戲任務系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .game-title { font-size: 32px; font-weight: bold; color: #00ffcc; margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }
        .card { background-color: #16213e; border: 1.5px solid #00ffcc; border-radius: 22px; box-shadow: 0 4px 18px #00ffcc33; }
        .list-group-item { background: #232343 !important; border: 1px solid #00ffcc22 !important; margin-bottom: 14px; border-radius: 14px !important; font-size: 19px; display: flex; align-items: center; justify-content: space-between;}
        .player-badge { font-size: 18px; font-weight: bold; margin-right: 14px; }
        .badge-new { background: #48baff; color: #fff; }
        .badge-advanced { background: #1fd174; color: #fff; }
        .badge-role { background: #ffaa33; color: #222; }
        .namecolor1 { color: #48baff; font-weight: bold; }
        .namecolor2 { color: #ffbe48; font-weight: bold; }
        .namecolor3 { color: #f661ae; font-weight: bold; }
        .namecolor4 { color: #5cd2e6; font-weight: bold; }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width:700px;">
    <div class="game-title text-center">🎮 遊戲任務系統</div>
    <h2 class="text-center mb-4">👥 玩家狀態一覽</h2>
    <div class="card p-4 mb-4">
        <ul class="list-group">
        <?php
        $colors = ['namecolor1', 'namecolor2', 'namecolor3', 'namecolor4'];
        $idx = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $colorClass = $colors[$idx % count($colors)];
            $badge = "";
            if ($row['exp'] < 100) {
                $badge = '<span class="badge badge-new player-badge">新手</span>';
            } else if ($row['exp'] >= 200) {
                $badge = '<span class="badge badge-advanced player-badge">高級玩家</span>';
            }
        ?>
            <li class="list-group-item">
                <div>
                    <span class="<?= $colorClass ?>"><?= htmlspecialchars($row['username']) ?></span>
                    <span class="text-secondary ms-2" style="font-size: 16px;">(ID: <?= $row['id'] ?>)</span>
                    <?= $badge ?>
                    <span class="ms-2 text-warning" style="font-size: 16px;">⭐經驗值: <?= $row['exp'] ?></span>
                    <span class="ms-2 text-info" style="font-size: 16px;">🪙金幣: <?= $row['coins'] ?></span>
                </div>
                <div>
                    <a href="players_items.php?uid=<?= $row['id'] ?>" class="btn btn-sm btn-info me-2">查看物品</a>
                    <span class="badge badge-role ms-1"><?= htmlspecialchars($row['role']) ?></span>
                </div>
            </li>
        <?php
            $idx++;
        endwhile;
        ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="admin.php" class="btn btn-outline-light">← 回管理員選單</a>
        <a href="../logout.php" class="btn btn-link ms-3">登出</a>
    </div>
</div>
</body>
</html>


