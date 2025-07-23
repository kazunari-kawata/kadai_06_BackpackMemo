<?php
session_start();
require_once __DIR__ . '/functions.php';
check_session_id();
if (!isset($_SESSION['user_id'])) {
    exit('ログインしてください');
}

$user_id = $_SESSION['user_id'];
// DB＆設定読み込み
$config = include __DIR__ . '/config.php';
$apiKey = $config['GOOGLE_MAPS_API_KEY'];
$pdo    = connect_to_db();

$sql = 'SELECT id, place, date, memo, latitude AS lat, longitude AS lng
        FROM travelRecord
        WHERE deleted_at IS NULL AND user_id = :user_id
        ORDER BY date ASC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 表示用にエスケープ
$data = [];
foreach ($rows as $r) {
    $data[] = [
        'id'    => (int)$r['id'],
        'place' => htmlspecialchars($r['place'], ENT_QUOTES),
        'date'  => htmlspecialchars($r['date'],  ENT_QUOTES),
        'memo'  => nl2br(htmlspecialchars($r['memo'], ENT_QUOTES)),
        'lat'   => (float)$r['lat'],
        'lng'   => (float)$r['lng'],
    ];
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/read.css">
    <title>訪れた場所マップ</title>
</head>

<body>
    <h1>訪れた場所マップ</h1>
    <div class="logout-container">
        <a href="./logout.php">ログアウト</a>
    </div>

    <a href="./write.php">入力画面に戻る</a>

    <div id="map" style="height:35rem;"></div>

    <div id="visit-list">
        <?php foreach ($data as $item): ?>
            <div class="visit-card">
                <h3><?= $item['place'] ?></h3>
                <p><strong>日付:</strong> <?= $item['date'] ?></p>
                <p class="memo"><?= $item['memo'] ?></p>
                <div class="edit-delete">
                    <a href="edit.php?id=<?= urlencode($item['id']) ?>">編集</a>
                    <a href="delete.php?id=<?= urlencode($item['id']) ?>">削除</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script type="module">
        const markers = <?= json_encode($data, JSON_UNESCAPED_UNICODE) ?>;

        const apiKey = "<?= $apiKey ?>";

        function initMap() {
            const center = markers.length ? {
                lat: markers[0].lat,
                lng: markers[0].lng
            } : {
                lat: 35.6895,
                lng: 139.6917
            }; // 東京をデフォルトに設定

            const map = new google.maps.Map(document.getElementById("map"), {
                center,
                zoom: 5,
            });

            const pathCoordinates = [];

            markers.forEach(marker => {
                const position = {
                    lat: marker.lat,
                    lng: marker.lng
                };
                pathCoordinates.push(position);

                const gMarker = new google.maps.Marker({
                    position,
                    map,
                    title: marker.place,
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `<div><strong>${marker.place}</strong><br>${marker.date}<br>${marker.memo}</div>`
                });

                gMarker.addListener("click", () => {
                    infoWindow.open(map, gMarker);
                });
            });

            if (pathCoordinates.length >= 2) {
                const routeLine = new google.maps.Polyline({
                    path: pathCoordinates,
                    geodesic: true,
                    strokeColor: "#FF0000",
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                });

                routeLine.setMap(map);
            }
        }

        // Google Maps APIを非同期に読み込む
        const script = document.createElement("script");
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
        script.async = true;
        window.initMap = initMap;
        document.head.appendChild(script);
    </script>

</body>

</html>