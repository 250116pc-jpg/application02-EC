<?php
session_start();
require_once '../db.php';
require_once '../funcs.php';

login_check();
$error = "";
$id = $_SESSION['id'];
$pdo = getPdo();
$stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');

$stmt->execute([$id]);
$member = $stmt->fetch();

if(!empty($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    
    $pdo = getPdo();
    $item = $pdo->prepare('SELECT * FROM items WHERE id=?');
    $item->execute([$id]);
    $item = $item->fetch();

    $name = $item["name"];
    $price = $item["price"];
    $image = $item["image"];
    $description = $item["description"];
    $stock = $item["stock"];
    $category = $item["category"];
    $release_date = $item["release_date"];
    $is_sale = $item["is_sale"];
    
}
if(!empty($_POST["item_id"])) {
    $item_id = $_POST["item_id"];
    $user_id = $_SESSION['id'];

    if ($user_id) {
        try {
            $pdo = getPdo();
            $stmt = $pdo->prepare('SELECT items FROM carts WHERE user_id=?');
            $stmt->execute([$user_id]);
            $now_cart = $stmt->fetch();

            if ($now_cart) {
                $items = json_decode($now_cart['items'] ?? '{}', true) ?? [];
                
                if (isset($items[$item_id])) {
                    $items[$item_id] += 1;
                } else {
                    $items[$item_id] = 1;
                }
                $items_json = json_encode($items);
                $stmt = $pdo->prepare("UPDATE carts SET items = ?, time = NOW() WHERE user_id = ?");
                $stmt->execute([$items_json, $user_id]);
                
            } else {
                
                $items = [];
                $items[$item_id] = 1;
                $items_json = json_encode($items);

                
                $stmt = $pdo->prepare("INSERT INTO carts (user_id, items, time) VALUES (?, ?, NOW())");
                $stmt->execute([$user_id, $items_json]);
            }

            
            header('Location: cart.php');
            exit();
        } catch (PDOException $e) {
            $error = "うーん";
        }
    }else{
        header('Location: home.php');
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品詳細画面</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" type="image/jpeg" href="favicon.jpg">
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        
        <h1 style="margin: 0; font-size: 28px;">商品詳細画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            <p>
                <div class="auth-links">
                    <a href="home.php">ホーム画面へ</a>
                </div>
                
                <div class="auth-links">
                    <a href="cart.php">カート画面へ</a>
                </div>
            </p>
            <div>商品詳細</div>
            <p>
                <h1><?php echo $name; ?></h1>
                <div>カテゴリー: <?php echo $category; ?></div>
            </p>
            <div>
                <img src="../images/items/<?php echo $image; ?>" alt="商品画像">
            </div>
            <div>価格: ¥<?php echo $price; ?></div>
            <div>在庫: <?php echo $stock; ?></div>
            <p>
                <div>商品説明: <?php echo $description; ?></div>
            </p>
            <?php if ($is_sale) { ?>
                <div>発売日: <?php echo $release_date; ?></div>
            
                <form action="" method="post">
                    <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                    <input type="submit" value="カートに追加">
                </form>
            <?php }else{ ?>
                <div>この商品は現在販売されていません。</div>
            <?php } ?>
        </section>

    </main>
</body>
</html>
