<?php
session_start();
$cart = $_SESSION['cart'] ?? []; 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>購入手続き画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <img src="logo.png" alt="Logo" style="height: 80px; width: auto; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px;">購入手続き画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            
            <form action="check.php" method="post">
                
                <div style="margin-bottom: 20px;">
                    <div><strong>カート内容</strong></div>
                    <?php if (!empty($cart)): ?>
                        <ul>
                            <?php foreach ($cart as $item): ?>
                                <li><?php echo htmlspecialchars($item['item_name'], ENT_QUOTES, 'UTF-8'); ?> 
                                    (¥<?php echo number_format($item['price']); ?> × <?php echo htmlspecialchars($item['order_count'], ENT_QUOTES, 'UTF-8'); ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>カートは空です。</p>
                    <?php endif; ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <div><strong>支払方法選択</strong></div>
                    <label><input type="radio" name="pay" value="クレジットカード" required> クレジットカード</label><br>
                    <label><input type="radio" name="pay" value="コンビニ決済"> コンビニ決済</label><br>
                    <label><input type="radio" name="pay" value="paypay"> paypay</label>
                </div>

                <div style="margin-bottom: 20px;">
                    <div><strong>発送方法選択・発送先入力</strong></div>
                    <label><input type="radio" name="method" value="宅配便" required> 宅配便</label><br>
                    <label><input type="radio" name="method" value="メール便"> メール便</label><br>
                    <div style="margin-top: 10px;">
                        <input type="text" name="address" placeholder="発送先住所を入力してください" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>
                </div>

                <div class="auth-actions" style="margin-top: 20px;">
                    <button type="submit" class="auth-btn">確認画面へ進む</button>
                </div>
            </form>

            <div class="auth-links" style="margin-top: 30px;">
                <a href="cart.php">カート一覧画面へ戻る</a><br>
                <a href="home.php">ホーム画面へ</a>
            </div>

        </section>
    </main>
</body>
</html>
