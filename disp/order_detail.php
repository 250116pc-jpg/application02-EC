
<?php
session_start();
require_once '../db.php';

$order_id = $_GET['id'] ?? null;
$order = null;

if ($order_id) {
    try {
        $pdo = getPdo();
        
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();
    } catch (Exception $e) {
        $error = "読み込みエラーが発生しました。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>注文詳細画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">注文詳細画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <?php if ($order): ?>
                <div class="detail-box">
                    <div class="detail-item"><strong>注文ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></div>
                    <div class="detail-item"><strong>注文日:</strong> <?php echo htmlspecialchars($order['created']); ?></div>
                    <div class="detail-item"><strong>合計金額:</strong> ¥<?php echo number_format($order['price']); ?></div>
                    <div class="detail-item"><strong>配送先:</strong> <?php echo htmlspecialchars($order['address']); ?></div>
                </div>

                <form action="cancel_order_process.php" method="post">
                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                    <button type="submit" class="btn-cancel">キャンセルする</button>
                </form>
            <?php else: ?>
                <p>注文が見つかりませんでした。</p>
            <?php endif; ?>

            <div class="auth-links" style="margin-top: 30px;">
                <a href="history.php">購入履歴画面へ</a><br>
                <a href="home.php">ホーム画面へ</a>
            </div>
        </section>
    </main>
</body>
</html>
