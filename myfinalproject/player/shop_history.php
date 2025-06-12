<?php
include '../config.php';
include '../functions.php';
checkLogin();
$user_id = $_SESSION['user_id'];
$items = mysqli_query($conn, "
    SELECT s.name, s.image, s.price, usi.created_at
    FROM user_shop_items usi
    JOIN shop_items s ON usi.item_id = s.id
    WHERE usi.user_id = $user_id
    ORDER BY usi.created_at DESC
");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>兌換紀錄</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; color: #eaeaea; }
        .card { background: #16213e; border: 1px solid #00ffcc; border-radius: 18px; }
        img.shop-img { border-radius: 8px; background: #111; max-width: 56px; max-height: 56px; }
    </style>
</head>
<body>
<div class="container mt-5" style="max-width:680px;">
    <h2 class="mb-4">🎁 我的兌換紀錄</h2>
    <a href="shop.php" class="btn btn-outline-info mb-3">← 回商城</a>
    <div class="card p-4">
        <table class="table table-dark table-hover table-bordered mb-0">
            <thead>
                <tr><th>商品</th><th>金幣</th><th>圖片</th><th>兌換時間</th></tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($items)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['price'] ?></td>
                    <td>
                        <?php
                        $img = trim($row['image']);
                        if ($img) {
                            if (preg_match('/^https?:\/\//', $img)) {
                                echo "<img src='$img' class='shop-img'>";
                            } else {
                                echo "<img src='images/" . htmlspecialchars($img) . "' class='shop-img'>";
                            }
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
