<?php
session_start();
require_once '../db.php';
require_once '../funcs.php';
$error = "";
login_check();
$id = $_SESSION['id'];


$pdo = getPdo();
$stmt = $pdo->prepare('SELECT items FROM carts WHERE user_id=?');
$stmt->execute([$id]);
$now_cart = $stmt->fetch();

try {
    if ($now_cart) {
        $items = json_decode($now_cart['items'] ?? '{}', true) ?? [];

        if (!empty($items)) {
            $placeholders = '';
            $keys = [];
            
            foreach ($items as $key => $value) {
                $placeholders .= '?,'; 
                $keys[] = $key;
            }
            
            $placeholders = rtrim($placeholders, ',');
            $sql = "SELECT * FROM items WHERE id IN (" . $placeholders . ")";
            $stmt = $pdo->prepare($sql);

            $stmt->execute($keys);
            
            $items_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } else {
            $items_info = [];
        }
    } else {
        $items_info = [];
    }
} catch (PDOException $e) {
    $error = "うーん";
}

#商品数



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>カート一覧画面</title>
    
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        
        <h1 style="margin: 0; font-size: 28px;">カート一覧画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <p>
                <div class="auth-links">
                    <a href="item_detail.php">商品詳細画面へ</a>
                </div>
                <div class="auth-links">
                    <a href="purchase/purchase.php">購入画面へ</a>
                </div>
                
                <div class="auth-links">
                    <a href="home.php">ホーム画面へ</a>
                </div>
            </p>
            <div>カート内容</div>
            <?php foreach($items_info as $item){ ?>
                <a href="item_detail.php?id=<?php echo h($item['id']); ?>">
                    <img src="..\images\items\default.png" alt="" width="150" height="150">
                    <div class="truncate-line"><?php
                        echo h($item["name"]); ?></div>
                    <div>￥<?php echo h($item['price']); ?></div>
                </a>
            <?php };?>
            
        </section>
    </main>
</body>
</html>
