<?php
session_start();
include('functions.php');
check_session_id();

require_once __DIR__ . '/functions.php';

$id = $_GET['id'];

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    exit('IDパラメータが不正です');
}

$pdo = connect_to_db();
$sql = 'SELECT * FROM travelRecord WHERE id = :id';
$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/edit.css">
    <title>Document</title>
</head>

<body>
    <form action="update.php" method="POST">
        <fieldset>
            <legend>編集画面</legend>
            <a href="read.php">一覧画面</a>
            <div>
                地名: <br>
                <input type="text" name="place" value="<?= $record['place'] ?>" readonly>
                <p>*地名は変更できません</p>
            </div>
            <div>
                日付: <br>
                <input type="date" name="place" value="<?= $record['date'] ?>">
            </div>
            <div>
                メモ: <br>
                <textarea type="text" name="memo" rows="5" style="width: 100%" ?><?= htmlspecialchars($record['memo'], ENT_QUOTES) ?></textarea>
            </div>
            <div>
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
            </div>
            <div class="submit-button-container">
                <button>submit</button>
            </div>
        </fieldset>
    </form>
</body>

</html>