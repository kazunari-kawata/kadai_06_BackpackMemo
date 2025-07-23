<?php
session_start();
require_once __DIR__ . '/functions.php';
check_session_id();

$id = $_GET['id'];

$pdo = connect_to_db();

$sql = 'DELETE FROM travelRecord WHERE id = :id';

$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT); // もしくは POSTから

try {
$status = $stmt->execute();
} catch (PDOException $e) {
echo json_encode(["sql error" => "{$e->getMessage()}"]);
exit();
}

header("Location:read.php");
exit();