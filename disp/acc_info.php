<?php
session_start();
require('../db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    header('Location: home.php');
}
// ここも後でやる
// ログアウト処理
if (isset($_POST['logout'])) {
  header("Location: login.php");
  exit();
}

// 戻る処理
if (isset($_POST['return'])) {
  header("Location: home.php");
  exit();
}

// 取得
$db=getPdo();
$dates=$db->prepare('SELECT * FROM users WHERE id=?');
$dates->execute(array($_SESSION['id']));
$date=$dates->fetch();

// 更新処理
if (isset($_POST['change'])) {
  $_SESSION['update']=$date;
  $_SESSION['update']['password']='・・・・・・・・';
  header("Location:account_update.php");
  exit();
}
// 後でやる
// アカウント削除処理
if (isset($_POST['cancel'])) {
  $_SESSION['cancel']=$date['id'];
  header("Location: cancel_check.php");
  exit();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント情報画面</title>
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="icon" type="image/jpeg" href="favicon.jpg"> -->
</head>
<body class="auth-page">
    <header>
      <form action="" method="post"><input type="submit" name='return' value="戻る" class='return'></form>
        <!-- <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;"> -->
        <h1>アカウント情報画面</h1>
        <form action="" method="post"><input type="submit" name='logout' value="ログアウト" class='logout'></form>
    </header>

    <main>
        <dl>
          <dt>名前</dt>
          <dd>
            <?php echo h($date['name'],ENT_QUOTES);?>
          </dd>
          <dt>メールアドレス</dt>
          <dd>
            <?php echo h($date['email'],ENT_QUOTES);?>
          </dd>
          <dt>パスワード</dt>
          <dd>........</dd>
          <dt>住所</dt>
          <dd>
            <?php echo h($date['address'],ENT_QUOTES);?>
          </dd>
        </dl>
        <form action="" method="post">
          <input type="submit" name='change' value="更新する" class='change'>
          <input type="submit" name='cancel' value="アカウント削除" class='cancel'>
        </form>
    </main>
</body>
</html>
