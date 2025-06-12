
<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // 本機端設定
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "game_task_platform";
} else {
    // 線上主機設定（改為你自己的！）
    $db_host = "sql303.infinityfree.com";
    $db_user = "if0_39208608";
    $db_pass = "2T4UbghEeJTe4";
    $db_name = "if0_39208608_game_task_platform";
}
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("資料庫連線失敗: " . mysqli_connect_error());
}
session_start();
?>
