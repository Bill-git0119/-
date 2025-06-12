<?php
if (!isset($conn)) include '../config.php';
if (!isset($_SESSION)) session_start();
$user_id = $_SESSION['user_id'];
$udata = mysqli_fetch_assoc(mysqli_query($conn, "SELECT exp, coins FROM users WHERE id=$user_id"));
?>
<div style="position:fixed;top:18px;right:40px;z-index:1000;">
    <span style="color:#00ffcc; font-weight:bold; font-size:18px;">
        ⭐ 經驗值: <?= intval($udata['exp']) ?>
        ｜🪙 金幣: <?= intval($udata['coins']) ?>
    </span>
</div>

