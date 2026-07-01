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
            //カート内のアイテム情報を取得
            $placeholders = rtrim($placeholders, ',');
            $sql = "SELECT * FROM items WHERE id IN (" . $placeholders . ")";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($keys);
            $db_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //アイテム情報に数量を追加
            $items_info = [];
            foreach ($db_items as $db_item) {
                $item_id = $db_item["id"];
                $num = $items[$item_id];
                $db_item["num"] = $num;
                $items_info[] = $db_item;
            }
        } else {
            $items_info = [];
        }
    } else {
        $items_info = [];
    }
} catch (PDOException $e) {
    $error = "うーん";
}
//セッションにカート情報追加
if(!empty($_POST)) {
    $user_id = $_SESSION['id'];
    
    $_SESSION['price'] = 0;
    $_SESSION['all_num'] = 0;
    $_SESSION['items'] = $items_info;
    
    foreach($items_info as $item){
        $_SESSION['price'] += $item["price"]*$item["num"];
        $_SESSION['all_num'] += $item["num"];
        
    }
    header('Location: purchase/purchase.php');
    exit();
    
}
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
                    
                    <form action="" method="post">
                        <input type="hidden" name="purchase" value="1">
                        <button type="submit">購入画面へ</button>
                    </form>
                    
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
                        echo h($item["name"]); ?>×<?php echo $item["num"] ?>
                    </div>
                    <div>￥<?php echo h($item['price']); ?></div>
                </a>
            <?php };?>
            
        </section>
    </main>
</body>
</html>
