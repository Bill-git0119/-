
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>管理員後台功能選單</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; color: #eaeaea; }
        .menu-box {
            background: #16213e;
            border: 2px solid #00ffcc;
            border-radius: 20px;
            max-width: 420px;
            margin: 90px auto 0;
            box-shadow: 0 6px 32px #00ffcc44;
            padding: 36px 32px;
        }
        .btn-menu {
            width: 100%; margin-bottom: 24px; font-size: 22px;
            font-weight: bold; border-radius: 20px;
            background: linear-gradient(90deg,#00ffcc 80%,#226875 100%);
            color: #181818;
            box-shadow: 0 2px 8px #00ffcc33;
            border: none;
            transition: background 0.2s, box-shadow 0.2s;
        }
        .btn-menu:hover { background: #00ccaa; color: #fff; box-shadow: 0 4px 16px #00ffcc66; }
        h2 { color:#00ffcc; font-weight:bold; text-shadow: 2px 2px 4px #111; }
    </style>
</head>
<body>
    <div class="menu-box text-center">
        <h2 class="mb-4">🎮 管理員功能選單</h2>
        <a href="taskandreward.php" class="btn btn-menu mb-3">🎯 任務指派 / 獎勵設定</a>
        <a href="shop_manage.php" class="btn btn-menu mb-3">🛒 商品管理</a>
        <a href="players.php" class="btn btn-menu mb-3">👤 玩家狀態查詢</a>
        <a href="../logout.php" class="btn btn-outline-light w-100">登出</a>
    </div>
</body>
</html>
