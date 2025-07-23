<?php
session_start();
include('functions.php');
check_session_id();

// 
if (
    !isset($_POST['place']) ||
    !isset($_POST['date']) ||
    !isset($_POST['memo']) ||
    !isset($_POST['lat']) ||
    !isset($_POST['lng'])
) {
    exit('必要なデータが送信されていません。');
}
// 送信されたデータを変数に格納
$place = $_POST['place'];
$date = $_POST['date'];
$memo = $_POST['memo'];
$lat = (float)$_POST['lat'];
$lng = (float)$_POST['lng'];

$pdo = connect_to_db();

$sql = 'INSERT INTO travelRecord (
            id, place, date, memo, latitude, longitude, created_at, updated_at, deleted_at
        ) VALUES (
            NULL, :place, :date, :memo, :lat, :lng, NOW(), NOW(), NULL
        )';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':place', $place, PDO::PARAM_STR);
$stmt->bindValue(':date',  $date,  PDO::PARAM_STR);
$stmt->bindValue(':memo',  $memo,  PDO::PARAM_STR);
$stmt->bindValue(':lat',   $lat,   PDO::PARAM_STR);
$stmt->bindValue(':lng',   $lng,   PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location: ./read.php');
exit();
