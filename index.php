<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Document</title>
</head>

<body>
    <form action="./write.php" method="POST">
        <fieldset>
            <legend>バックパックメモ</legend>
            <div id="list_screen_container">
                <a href="./read.php" id="list_screen">一覧画面</a>
            </div>
            <div id="name-container">
                <label>地名：</label><br>
                <input type="text" id="place" name="place">
            </div>
            <div id="date-container">
                <label>日付：</label><br>
                <input type="date" id="date" name="date">
            </div>
            <div id="memo-container">
                <label>現地情報：</label><br>
                <textarea name="memo" id="" col="10" row="30"></textarea>
            </div>
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">
            <button type="submit" name="submit">保存</button>
        </fieldset>
    </form>
    <?php
    $config = include('./config.php');
    $apiKey = $config['GOOGLE_MAPS_API_KEY'];
    ?>
    <script type="module">
        const apiKey = "<?= $apiKey ?>";

        document.addEventListener("DOMContentLoaded", () => {
            const placeInput = document.getElementById("place");
            const latInput = document.getElementById("lat");
            const lngInput = document.getElementById("lng");

            placeInput.addEventListener('blur', () => {
                const place = placeInput.value.trim();
                if (!place) return;

                const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(place)}&key=${apiKey}`;

                fetch(geocodeUrl)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === "OK") {
                            const location = data.results[0].geometry.location;
                            latInput.value = location.lat;
                            lngInput.value = location.lng;
                            console.log(`緯度経度取得：${location.lat}, ${location.lng}`);
                        } else {
                            alert('場所が見つかりませんでした');
                        }
                    }).catch(err => {
                        console.error("ジオコーディングにエラー");
                        alert("ジオコーディングにエラー");;
                    });
            });
        });
    </script>
</body>

</html>