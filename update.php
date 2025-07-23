<?php
session_start();
require_once __DIR__ . '/functions.php';check_session_id();
if (!isset($_SESSION['user_id'])) {
    exit('ログインしてください');
}
$user_id = $_SESSION['user_id'];
// 
if (
    !isset($_POST['place']) ||
    !isset($_POST['memo']) ||
    !isset($_POST['id'])
) {
    exit('必要なデータが送信されていません。');
}
// 送信されたデータを変数に格納
$place = $_POST['place'];
$memo = $_POST['memo'];
$id = $_POST['id'];

$pdo = connect_to_db();

$sql = 'UPDATE travelRecord SET memo = :memo, updated_at = NOW() WHERE id = :id AND user_id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':id',   $id,   PDO::PARAM_INT);
$stmt->bindValue(':user_id',  $user_id, PDO::PARAM_INT);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location: ./read.php');
exit();
