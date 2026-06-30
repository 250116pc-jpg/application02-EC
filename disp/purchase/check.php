<?php
session_start();
$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_POST['user_id'] ?? '');
    $password = $_POST['password'] ?? '';

    
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入確認画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">購入確認画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            

            
            <p>
                <div class="auth-links">
                    <a href="complete.php">注文完了画面へ</a>
                </div>
            </p>
            <p>
                <div class="auth-links">
                    <a href="../cart.php">カート一覧画面へ</a>
                </div>
                
                <div class="auth-links">
                    <a href="../home.php">ホーム画面へ</a>
                </div>
            
            <p>
                <div>カート内容</div>
            </p>
            <p>
                <div>支払方法</div>
            </p>
             <p>
                <div>配送先</div>
            </p>
        </section>
    </main>
</body>
</html>
