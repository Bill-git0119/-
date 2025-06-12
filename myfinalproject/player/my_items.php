<?php
include '../config.php';
include '../functions.php';
include 'header.php';
checkLogin();
$user_id = $_SESSION['user_id'];
$my_items = mysqli_query($conn, "
    SELECT si.name, si.image, usi.created_at
    FROM user_shop_items usi
    JOIN shop_items si ON usi.item_id = si.id
    WHERE usi.user_id = $user_id
    ORDER BY usi.created_at DESC
");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的物品欄｜遊戲任務系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .game-title { font-size: 30px; font-weight: bold; color: #00ffcc; margin-bottom: 22px; text-shadow: 2px 2px 6px #000; }
        .card { background: #16213e; border: 2px solid #00ffcc; border-radius: 18px; box-shadow: 0 4px 24px #0ff3c088; }
        .list-group-item { background: #232343 !important; border: none !important; margin-bottom: 8px; border-radius: 16px !important; transition: box-shadow 0.18s; }
        .list-group-item:hover { box-shadow: 0 4px 18px #00ffcc44; background: #223; }
        img.item-img { width: 50px; height: 50px; object-fit: cover; border-radius: 12px; background: #1a1a2e; box-shadow: 0 2px 8px #00ffcc55; margin-right: 15px; }
        .no-item { color: #888; font-size: 18px; font-style: italic; padding: 28px 0 18px 0; }
        .fs-5 { font-size: 21px !important; font-weight: bold; color: #fff; }
        .obtained-at { color: #7fffd4; font-size: 13px; margin-left: 18px; }
        .btn-outline-info { border-radius: 16px; margin-top: 18px;}
    </style>
</head>
<body>
<div class="container mt-5" style="max-width: 700px;">
    <div class="game-title text-center">🎁 我的物品欄</div>
    <div class="card p-4 mb-4">
        <ul class="list-group">
        <?php if(mysqli_num_rows($my_items)==0): ?>
            <li class="list-group-item no-item text-center">
                <span style="font-size:30px;">😶</span><br>
                目前尚未兌換任何商品
            </li>
        <?php endif; ?>
        <?php while ($row = mysqli_fetch_assoc($my_items)): ?>
            <li class="list-group-item d-flex align-items-center">
                <?php if ($row['image']): ?>
                    <?php
                        $imgsrc = (preg_match('/^https?:\/\//', $row['image']))
                            ? $row['image']
                            : "images/" . htmlspecialchars($row['image']);
                    ?>
                    <img src="<?= $imgsrc ?>" class="item-img">
                <?php endif; ?>
                <span class="fs-5"><?= htmlspecialchars($row['name']) ?></span>
                <span class="obtained-at"><?= $row['created_at'] ?></span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="shop.php" class="btn btn-outline-info">← 回商城</a>
    </div>
</div>
</body>
</html>

