<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");

$uid = intval($_GET['uid']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$uid"));
$items = mysqli_query($conn, "
    SELECT si.name, si.image, usi.created_at
    FROM user_shop_items usi
    JOIN shop_items si ON usi.item_id = si.id
    WHERE usi.user_id = $uid
    ORDER BY usi.created_at DESC
");
?>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($user['username']) ?> 的物品 | 管理員</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; color: #eaeaea; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .game-title { font-size: 26px; color: #00ffcc; margin-bottom: 16px; text-align: center;}
        .card { background: #16213e; border: 2px solid #00ffcc; border-radius: 18px;}
        img.item-img { width: 44px; height: 44px; object-fit: cover; border-radius: 10px; background: #222; margin-right: 13px; }
        .no-item { color: #888; font-size: 18px; font-style: italic; padding: 24px 0 18px 0; }
        .fs-5 { font-size: 20px; font-weight: bold; color: #fff; }
        .obtained-at { color: #7fffd4; font-size: 13px; margin-left: 16px; }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width:680px;">
    <div class="game-title"><?= htmlspecialchars($user['username']) ?> 的物品欄</div>
    <div class="card p-4 mb-4">
        <ul class="list-group">
            <?php if(mysqli_num_rows($items)==0): ?>
                <li class="list-group-item no-item text-center">尚未兌換任何商品</li>
            <?php endif; ?>
            <?php while ($row = mysqli_fetch_assoc($items)): ?>
                <li class="list-group-item d-flex align-items-center" style="background: #232343;">
                    <?php
                        $imgsrc = (preg_match('/^https?:\/\//', $row['image']))
                            ? $row['image']
                            : "../player/images/" . htmlspecialchars($row['image']);
                    ?>
                    <?php if ($row['image']): ?>
                        <img src="<?= $imgsrc ?>" class="item-img">
                    <?php endif; ?>
                    <b class="fs-5"><?= htmlspecialchars($row['name']) ?></b>
                    <span class="obtained-at"><?= $row['created_at'] ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="players.php" class="btn btn-outline-info">← 回玩家列表</a>
    </div>
</div>
</body>
</html>