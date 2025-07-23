<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>ログイン画面</title>
</head>

<body>
    <h1>Backpack Memo</h1>
    <form action="login_act.php" method="POST">
        <fieldset>
            <legend>Let's head out with us</legend>
            <div>
                ユーザー名: <input type="text" name="username">
            </div>
            <div>
                パスワード: <input type="password" name="password">
            </div>
            <div>
                <button>ログイン</button>
            </div>
            <a href="register.php">登録する</a>
        </fieldset>
    </form>

</body>

</html>