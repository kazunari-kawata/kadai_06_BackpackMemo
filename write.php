<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/write.css?v=<?= filemtime('./css/index.css') ?>">
    <title>Backpack Memo</title>
</head>

<body>
    <!-- <header>
        <div class="login-container">
            <button>ログイン</button>
        </div>
        <div class="signup-container">
            <button>サインアップ</button>
        </div>
    </header> -->
    <form action="./create.php" method="POST">
        <fieldset>
            <legend>バックパックメモ</legend>
            <div class="logout-container">
                <a href="./logout.php">ログアウト</a>
            </div>
            <div id="list_screen_container">
                <a href="./read.php" id="list_screen">一覧画面</a>
            </div>
            <div id="name-container">
                <label>地名：</label><br>
                <input type="text" id="place" name="place" required>
            </div>
            <div id="date-container">
                <label>日付：</label><br>
                <input type="date" id="date" name="date" value="<?= date('Y-m-d')?>" required>
            </div>
            <div id="memo-container">
                <label>現地情報：</label><br>
                <textarea name="memo" id="" cols="30" rows="10" required></textarea>
            </div>
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">
            <button type="submit" name="submit" id="submit-btn" disabled>保存</button>
        </fieldset>
    </form>
    <?php
    session_start();
    include('functions.php');
    check_session_id();

    $config = include('./config.php');
    $apiKey = $config['GOOGLE_MAPS_API_KEY'];
    ?>
    <script type="module">
        const apiKey = "<?= $apiKey ?>";

        document.addEventListener("DOMContentLoaded", () => {
            const placeInput = document.getElementById("place");
            const latInput = document.getElementById("lat");
            const lngInput = document.getElementById("lng");
            const submitBtn = document.getElementById("submit-btn");

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
                            submitBtn.disabled = false;
                            // console.log(`緯度経度取得：${location.lat}, ${location.lng}`);
                        } else {
                            latInput.value = '';
                            lngInput.value = '';
                            // 存在しない地名は保存できないように
                            submitBtn.disabled = true;
                            alert("地名が見つかりませんでした。もう一度入力してください。");
                        }
                    }).catch(err => {
                        console.error("ジオコーディングにエラー");
                        alert("ジオコーディングにエラー");;
                        submitBtn.disabled = true;
                    });
            });
        });
    </script>
</body>

</html>