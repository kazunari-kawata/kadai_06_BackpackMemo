<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/read.css">
    <title>Document</title>
</head>

<body>
    <h1>訪れた場所マップ</h1>
    <a href="./index.php">入力画面に戻る</a>
    <div id="map" style="height: 35rem;"></div>
    <div id="visit-list">
        <?php
        $config = include('./config.php');
        $apiKey = $config['GOOGLE_MAPS_API_KEY'];
        // CSVの中身を1行ずつ読む
        $lines = file("./data/data.csv");
        $data = [];
        // 各行に繰り返し処理
        foreach ($lines as $line) {
            $parts = explode(",", trim($line));
            $place = htmlspecialchars($parts[0] ?? ''); //値が存在しなければ空文字を代入
            $date = htmlspecialchars($parts[1] ?? '');
            $memo = nl2br(htmlspecialchars($parts[2] ?? ''));

            $data[] = [
                'place' => htmlspecialchars($parts[0] ?? ''),
                'date' => htmlspecialchars($parts[1] ?? ''),
                'memo' => nl2br(htmlspecialchars($parts[2] ?? '')),
            ];
        }
        // 日付で降順ソート（古い順）
        usort($data, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });

        // そのまま長いHTMLをかけるらしい
        foreach ($data as $item) {
            echo <<<HTML
        <div class="visit-card">
            <h3>{$item["place"]}</h3>
            <p><strong>日付:</strong> {$item["date"]}</p>
            <p>{$item["memo"]}</p>
        </div>
        HTML;
        }
        ?>
    </div>

    <script type="module">
        const apiKey = "<?= $apiKey ?>";

        // PHPが作ったマーカー情報をJSの配列展開
        const markers = [
            <?php
            $lines = file("./data/data.csv");
            foreach ($lines as $line) {
                $parts = explode(",", trim($line));
                $place = $parts[0];
                $date = $parts[1];
                $memo = $parts[2];
                $lat = $parts[3];
                $lng = $parts[4];
                // JSオブジェクト形式
                echo "{ name: '$place', date: '$date', memo: '$memo', lat: $lat, lng: $lng },\n";
            }
            ?>
        ];

        // Google mapsのスクリプトを動的読み込み
        function loadGoogleMaps(callbackName) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=${callbackName}`;
            script.async = true;
            script.defer = true;
            // headに追加
            document.head.appendChild(script);
        }
        // Google maps初期化
        window.initMap = () => {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: markers[0]?.lat || 0,
                    lng: markers[0]?.lng || 0
                },
                zoom: 4
            });
            // 各マーカー配置
            markers.forEach(m => {
                const marker = new google.maps.Marker({
                    position: {
                        lat: m.lat,
                        lng: m.lng
                    },
                    map: map,
                    title: m.name
                });

                const infowindow = new google.maps.InfoWindow({
                    content: `<strong>${m.name}</strong><br>${m.memo}`
                });

                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });
            });
        };

        // スクリプト読み込み開始
        loadGoogleMaps("initMap");
    </script>

</body>

</html>