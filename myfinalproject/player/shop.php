<?php
include '../config.php';
include '../functions.php';
checkLogin();
$user_id = $_SESSION['user_id'];

if (isset($_GET['buy'])) {
    $item_id = intval($_GET['buy']);
    $item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM shop_items WHERE id=$item_id"));
    if ($item) {
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));
        if ($user['coins'] >= $item['price']) {
            mysqli_query($conn, "UPDATE users SET coins=coins-{$item['price']} WHERE id=$user_id");
            mysqli_query($conn, "INSERT INTO user_shop_items (user_id, item_id) VALUES ($user_id, $item_id)");
            $_SESSION['shop_msg'] = "兌換成功！你獲得了「{$item['name']}」";
        } else {
            $_SESSION['shop_msg'] = "金幣不足，無法兌換！";
        }
    } else {
        $_SESSION['shop_msg'] = "找不到商品";
    }
    header("Location: shop.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM shop_items");
?>


<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>玩家商城</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; color: #eaeaea; }
        .card { background: #16213e; border: 1.5px solid #00ffcc; border-radius: 18px; }
        .btn-outline-info, .btn-info, .btn-outline-warning { border-radius: 16px; }
        th, td { vertical-align: middle !important; }
        img.shop-img { border-radius: 8px; background: #111; max-width: 56px; max-height: 56px; }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width:720px;">
    <h2 class="mb-4">🛒 商城</h2>
    <div class="mb-3 d-flex justify-content-between">
        <a href="board.php" class="btn btn-outline-info">← 回任務看板</a>
        <div>
            <a href="my_items.php" class="btn btn-info me-2">🎁 我的物品</a>
            <a href="shop_history.php" class="btn btn-outline-warning">兌換紀錄</a>
        </div>
    </div>

    <?php if (isset($_SESSION['shop_msg'])): ?>
        <div class="alert alert-info"><?= $_SESSION['shop_msg']; unset($_SESSION['shop_msg']); ?></div>
    <?php endif; ?>

    <div class="card p-4">
        <table class="table table-dark table-hover table-bordered mb-0">
            <thead>
                <tr>
                    <th>商品</th>
                    <th>金幣</th>
                    <th>圖片</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>
                        <?php if ($row['image']): ?>
                            <?php
                                $imgsrc = (preg_match('/^https?:\/\//', $row['image']))
                                    ? $row['image']
                                    : "images/" . htmlspecialchars($row['image']);
                            ?>
                            <img src="<?= $imgsrc ?>" width="48" class="shop-img">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?buy=<?= $row['id'] ?>" class="btn btn-warning btn-sm" onclick="return confirm('確定用 <?= $row['price'] ?> 金幣兌換「<?= htmlspecialchars($row['name']) ?>」？')">兌換</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

