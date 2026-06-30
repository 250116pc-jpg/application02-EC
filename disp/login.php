<?php
session_start();
require_once '../db.php';
$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === "" || $password === "") {
        $error = "メールアドレスとパスワードを入力してください。";
    } else {
        try {
            $pdo = getPdo();
            $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION["id"] =  $user['id'];
                $_SESSION['time'] = time();
                header('Location: home.php');
                exit();
            } else {
                $error = "IDまたはパスワードが正しくありません。";
            }
        } catch (PDOException $e) {
            $error = "データベースエラーが発生しました。";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ログイン画面</title>
    
    
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        
        <h1 style="margin: 0; font-size: 28px;">ログイン画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            

            <?php if ($error): ?>
                <div class="auth-notice error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form action="login.php" method="post" class="auth-form">
                <label>
                    メールアドレス
                    <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autofocus>
                </label>
                <label>
                    パスワード
                    <input type="password" name="password" value="<?= htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </label>
                
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
