<?php
session_start();
require('../db.php');
$db=getPdo();
$error =[];


// 戻る処理
if (isset($_POST['return'])) {
  header("Location: acc_info.php");
  exit();
}

if (isset($_POST['check'])) {
    if(!empty($_POST)){
        // メールアドレスがすでに登録されているか
        if(!empty($_POST['email'])){
            $mail = $_POST['email'];
            $stmt = $db->prepare('SELECT COUNT(id) FROM users WHERE email = :mail');
            $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 1) {
                $error['email'] = 'er';
            }
        }
        
        // パスワードのエラー
        if(!empty($_POST['password'])){
            if(strlen($_POST['password'])<8){
                $error['password']='length';
            }
            if($_POST['password']!==$_POST['password2']){
                $error['password2']='not';
            }
            if($_POST['password2']==''){
                $error['password2']='blank';
            }
        }

    
    }

    if(empty($error)){
        $_SESSION['update_check']=$_POST;
        header('location:account_update_check.php');
        exit();
    }
  
}
if($_REQUEST['action']??''=='return'){
  $date=$_SESSION['update_check']??'';
  $error['return']=true;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>アカウント情報更新画面</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <header>
        <form action="" method="post"><input type="submit" name='return' value="戻る" class='return'></form>
        <h1>アカウント情報更新画面</h1>
    </header>
    <main>
        <h3>更新する箇所を入力してください</h3>
        <form action='' method='post'>
            <dl>
                <dt>名前</dt>
                <dd>
                    <input type='text' name='name' value="<?php echo h(($date['name']??''),ENT_QUOTES);?>">
                </dd>
                <dt>メールアドレス</dt>
                <dd>
                    <input type='email' name='email' value="<?php echo h(($date['email']??''),ENT_QUOTES);?>">
                    <?php if(($error['email']??'')=='er'):?>
                    <p class="error">*このメールアドレスは既に登録されています</p>
                    <?php endif;?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    <input type='password' name='password'>
                    <?php if(($error['password']??'')=='length'):?>
                    <p class="error">*パスワードは8文字以上で入力してください</p>
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
                <dt>住所</dt>
                <dd>
                    <input type='text' name='address' value="<?php echo h(($date['address']??''),ENT_QUOTES);?>">
                </dd>
            </dl>
            <input type="submit" name='check' value="確認画面へ" class='check'>
        </form>

    </main>
</body>
</html>
