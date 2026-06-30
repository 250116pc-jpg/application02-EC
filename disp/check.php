<?php
session_start();
require_once 'db.php';
$error = "";
$registered = isset($_GET['registered']) && $_GET['registered'] == 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_POST['user_id'] ?? '');
    $password = $_POST['password'] ?? '';

    $registered = 1;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>確認画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">確認画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <?php if ($registered): ?>
                <div class="auth-notice success">登録が完了しました。ログインしてください。</div>
                <div class="auth-links">
                    <a href="login.php">ログインはこちら</a>
                </div>
            <?php endif; ?>
            

            <form action="check.php" method="post" class="auth-form">
                <div class="auth-actions">
                    <button type="submit" class="auth-btn btn-user">登録</button>
                </div>
            </form>

            
        </section>
    </main>
</body>
</html>
