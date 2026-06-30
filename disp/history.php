<?php
session_start();
require_once '../db.php'; 

$user_id = $_SESSION['user_id'] ?? null;

$orders = [];
if ($user_id) {
    try {
        $pdo = getPdo();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created DESC");
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll();
    } catch (Exception $e) {

    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入履歴画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">購入履歴画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            
            <div style="margin-bottom: 20px;">注文一覧</div>

            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-block">
                        <div class="order-info">
                            注文日: <?php echo htmlspecialchars($order['created']); ?><br>
                            価格: ¥<?php echo number_format($order['price']); ?><br>
                            配送先: <?php echo htmlspecialchars($order['address']); ?>
                        </div>
                        <a href="order_detail.php?id=<?php echo $order['order_id']; ?>" class="btn-rebuy">再度購入</a>
                        <a href="#" class="btn-cancel">キャンセル</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>購入履歴はありません。</p>
            <?php endif; ?>

            <div class="dots">・<br>・<br>・<br>・<br>・<br>・</div>
            
            <div class="auth-links" style="text-align: center;">
                <a href="home.php">ホーム画面へ</a>
            </div>

        </section>
    </main>
</body>
</html>
