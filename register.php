<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/register.css">
    <title>todoリストユーザ登録画面</title>
</head>

<body>
    <form action="register_act.php" method="POST">
        <fieldset>
            <legend>ユーザ登録画面</legend>
            <div>
                ユーザー名: <input type="text" name="username">
            </div>
            <div>
                パスワード: <input type="text" name="password">
            </div>
            <div>
                <button>登録する</button>
            </div>
            <a href="index.php">ログインする</a>
        </fieldset>
    </form>

</body>

</html>