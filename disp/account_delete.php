<?php
session_start();
require('../db.php');
$error =[];
// 取得
$db=getPdo();
$dates=$db->prepare('SELECT * FROM users WHERE id=?');
$dates->execute(array($_SESSION['account_delete']));
$date=$dates->fetch();

// 削除処理
if (isset($_POST['delete'])) {
    if(!empty($_POST['password'])){
            if($_POST['password']!==$_POST['password2']){
                $error['password2']='not';
            }
            if($_POST['password2']==''){
                $error['password2']='blank';
            }
    }else{
        $error['password']='blank';
    }
    if(empty($error)){
        if(password_verify($_POST['password'], $date['password'])){
            $delete_user = $db->prepare('DELETE FROM users WHERE id = ?');
            $delete_user->execute(array($date['id']));

            $delete_carts = $db->prepare('DELETE FROM carts WHERE user_id = ?');
            $delete_carts->execute(array($date['id']));

            header("Location: register.php");
            exit();
            }else{
                $error['password']='miss';
            }
    }
}

// 戻る処理
if (isset($_POST['return'])) {
  header("Location: acc_info.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント削除画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header>
      <form action="" method="post"><input type="submit" name='return' value="戻る" class='return'></form>
        <h1>アカウントを削除しますか？</h1>
    </header>

    <main>
        <h3>パスワードを入力してください</h3>
        <form action='' method='post'>
            <dl>
                <dt>パスワード</dt>
                <dd>
                    <input type='password' name='password'>
                    <?php if(($error['password']??'')=='blank'):?>
                    <p class="error">*パスワードを入力してください</p>
                    <?php endif;?>
                    <?php if(($error['password']??'')=='miss'):?>
                    <p class="error">*パスワードが間違っています</p>
                    <?php endif;?>
                </dd>
                <dt>パスワード(確認)</dt>
                <dd>
                    <input type='password' name='password2'>
                    <?php if(($error['password2']??'')=='blank'):?>
                    <p class="error">*パスワードをもう一度入力してください</p>
                    <?php endif;?>
                    <?php if(($error['password2']??'')=='not'):?>
                        <p class="error">*パスワードが間違っています</p>
                    <?php endif;?>   
                </dd>
            </dl>
            <input type="submit" name='delete' value="削除する" class='delete'>
        </form>
    </main>
</body>
</html>