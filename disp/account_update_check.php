<?php
session_start();
require('db.php');

$date=$_SESSION['update_check'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント情報更新 - 確認画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header>
        <h1>アカウント情報更新の確認</h1>
    </header>

    <main>
        <h3>以下の内容で更新してよろしいですか？</h3>
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
          <dd> 
            <?php if($date['password']==''){
                    echo '変更なし';
                  }else{
                    echo h($date['password'],ENT_QUOTES);
                  }?>
                    
          </dd>
          <dt>住所</dt>
          <dd>
            <?php echo h($date['address'],ENT_QUOTES);?>
          </dd>
        </dl>
        <form action="" method="post">
          <input type="submit" name='change' value="更新する" class='change'>
        </form>
    </main>
</body>
</html>
