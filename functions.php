<?php

function connect_to_db() {
    // このプログラムを実行しているサーバー情報を取得して変数に保存
    // $_SERVERについて
    // https://www.php.net/manual/ja/reserved.variables.server.php   
    $server_info = $_SERVER;

    $db_name = "";
    $db_id = "";
    $db_pw = "";
    $db_host = "";

    // サーバー情報の中のサーバの名前がlocalhostだった場合と本番だった場合で処理を分ける
    if ($server_info["SERVER_NAME"] == "localhost") {
        // localhostの場合はこのデータを変数に代入
        $db_name = 'BackpackMemo';       // データベース名
        $db_id   = 'root';                    // アカウント名
        $db_pw   = '';                        // パスワード：XAMPPはパスワード無し、MAMPの場合はroot
        $db_host = 'localhost';               // DBホスト
    } else {
        // localhostでない場合(本番環境)はこのデータを変数に代入
        $db_name = 'xs358115_backpackmemo';           // 本番環境のDBの名前
        $db_host = 'mysql57.xs358115.xsrv.jp'; // 自身のDBが割り当てられているサーバを記述
        $db_id   = 'xs358115_kawata';               // さくらのアカウント
        $db_pw   = 'Dd8qXjmF';          // さくらのデータベースにログインする際のパスワード

    }

    try {
        // テンプレートリテラルでの書き方の場合
        $pdo = new PDO("mysql:dbname={$db_name};charset=utf8mb4;port=3306;host={$db_host}", $db_id, $db_pw);

        // $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB接続エラー:' . $e->getMessage());
    }
}

// ログイン状態のチェック関数
function check_session_id() {
    if (
        !isset($_SESSION["session_id"]) ||
        $_SESSION["session_id"] !== session_id()
    ) {
        header('Location: index.php'); // ログイン画面などへ
        exit();
    }

    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
}
function check_admin() {
    if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== 1) {
        header('Location: readread.php');
        exit();
    }
}