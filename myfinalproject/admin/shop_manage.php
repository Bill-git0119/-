<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");

if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = intval($_POST['price']);
    $image = mysqli_real_escape_string($conn, $_POST['image']); // 圖片網址或檔名
    mysqli_query($conn, "INSERT INTO shop_items (name, price, image) VALUES ('$name', $price, '$image')");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM shop_items WHERE id=$id");
}

$result = mysqli_query($conn, "SELECT * FROM shop_items");
?>

<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>商品管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5" style="max-width:720px;">
    <div class="mb-3">
        <a href="admin.php" class="btn btn-outline-info">← 回管理員選單</a>
    </div>

    <h2 class="mb-4">🛒 商品管理（Admin）</h2>
    <form method="post" class="card p-3 mb-4">
        <div class="row g-2">
            <div class="col-md-5">
                <input name="name" class="form-control" placeholder="商品名稱" required>
            </div>
            <div class="col-md-3">
                <input name="price" type="number" class="form-control" placeholder="金幣" required>
            </div>
            <div class="col-md-3">
                <input name="image" class="form-control" placeholder="圖片網址或檔名">
            </div>
            <div class="col-md-1 d-grid">
                <button name="add" class="btn btn-success">新增</button>
            </div>
        </div>
    </form>
    <table class="table table-dark table-hover table-bordered">
        <thead>
            <tr><th>名稱</th><th>金幣</th><th>圖片</th><th>管理</th></tr>
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
                                 : "../player/images/" . htmlspecialchars($row['image']);
                        ?>
                        <img src="<?= $imgsrc ?>" width="40">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定刪除？')">刪除</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="../logout.php" class="btn btn-outline-light mt-3">登出</a>
</div>
</body>
</html>
