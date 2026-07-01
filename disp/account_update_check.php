<?php
session_start();
require('../db.php');

$date=$_SESSION['update_check'];

// 更新処理





// 戻る処理
if(isset($_POST['return'])){
    header('location:account_update.php?action=rewrite');
    exit();
}

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
            <?php 
            if($date['name']==''){
              echo '変更なし';
            }else{
              echo h($date['name'],ENT_QUOTES);
            }?>
          </dd>
          <dt>メールアドレス</dt>
          <dd>
           <?php 
            if($date['email']==''){
              echo '変更なし';
            }else{
              echo h($date['email'],ENT_QUOTES);
            }?>
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
           <?php 
            if($date['address']==''){
              echo '変更なし';
            }else{
              echo h($date['address'],ENT_QUOTES);
            }?>
          </dd>
        </dl>
        <form action="" method="post">
        <input type="submit" name='return' value="戻る" class='return'>
          <input type="submit" name='change' value="更新する" class='change'>
        </form>
    </main>
</body>
</html>
