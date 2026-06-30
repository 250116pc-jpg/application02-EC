<?php
session_start();
require_once 'db.php';
$error = "";
$registered = isset($_GET['registered']) && $_GET['registered'] == 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">ログイン画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <?php if ($registered): ?>
                <div class="auth-notice success">登録が完了しました。ログインしてください。</div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="auth-notice error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form action="login.php" method="post" class="auth-form">
                <div class="auth-actions">
                    <button type="submit" class="auth-btn btn-user">ログイン</button>
                </div>
            </form>

            <div class="auth-links">
                <a href="register.php">新規ユーザー登録はこちら</a>
            </div>
        </section>
    </main>
</body>
</html>
