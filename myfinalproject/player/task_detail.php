
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

<?php
include '../config.php';
include '../functions.php';
checkLogin();
$task_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE id=$task_id");
$task = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $upload_dir = "../uploads/";
    $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $new_name = uniqid() . "." . $ext;
    $target_file = $upload_dir . $new_name;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $file_path = mysqli_real_escape_string($conn, $target_file);
        mysqli_query($conn, "INSERT INTO user_tasks (user_id, task_id, status, upload_file_path) VALUES ({$_SESSION['user_id']}, $task_id, 'completed', '$file_path')");
        echo "<div class='alert alert-success'>上傳成功！</div>";
    } else {
        echo "<div class='alert alert-danger'>上傳失敗，請確認 uploads 資料夾存在且有權限。</div>";
    }
}
?>
<h2><?= $task['title'] ?></h2>
<p><?= $task['description'] ?></p>
<form method="POST" enctype="multipart/form-data" class="p-4 card">
    <input type="file" name="file" class="form-control mb-3" required>
    <input type="submit" name="submit" value="上傳檔案" class="btn btn-game w-100">
</form>
<a href="board.php" class="btn btn-link mt-3">回任務看板</a>

</div></body></html>


