<?php
session_start();
require_once '../db.php';
$error = "";

if (!empty($_POST)) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($email === "" || $password === "" || $password_confirm === "") {
        $error = "メールアドレスとパスワードをすべて入力してください。";
    } elseif ($password !== $password_confirm) {
        $error = "パスワードが一致しません。";
    } elseif (!preg_match('/^[a-zA-Z0-9_@.-]{3,20}$/', $email)) {
        $error = "メールアドレスは英数字、_ @ . - の3～20文字で入力してください。";
    } else {
        
        try {
            $pdo = getPdo();
            

            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "そのメールアドレスはすでに使われています。別のメールアドレスを入力してください。";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO `users`(`name`, `email`, `address`, `password`, `created`) VALUES 
                (?,?,"地球",?,NOW())');
                $stmt->execute([$name, $email, $password_hash]);

                header('Location: login.php');
                exit();
            }
        } catch (PDOException $e) {
            $error = "データベース接続に失敗しました。管理者に連絡してください。";
            error_log('登録エラー: ' . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>登録画面</title>
    
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        
        <h1 style="margin: 0; font-size: 28px;">登録画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <?php if ($error): ?>
                <div class="auth-notice error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="post" class="auth-form">
                <label>
                    ニックネーム
                    <input type="text" name="name" placeholder="半角英数字3～20文字" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" autofocus>
                </label>
                <label>
                    メールアドレス
                    <input type="text" name="email" placeholder="半角英数字3～20文字" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autofocus>
                </label>
                <label>
                    パスワード
                    <input type="password" name="password" placeholder="パスワードを入力">
                </label>
                <label>
                    パスワード（確認）
                    <input type="password" name="password_confirm" placeholder="もう一度入力">
                </label>
                
                <div class="auth-actions">
                    <button type="submit" class="auth-btn btn-user">登録する</button>
                </div>
            </form>

            <div class="auth-links">
                <a href="login.php">ログイン画面へ戻る</a>
            </div>
        </section>
    </main>
</body>
</html>
