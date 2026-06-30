<?php
session_start();
require_once '../db.php';
$max_row = 10;
$max_col = 5;
$error = "";
$pdo = getPdo();

// 1. ログインチェック
if (isset($_SESSION['id']) && $_SESSION["time"] + 3600 > time()) {
    $_SESSION["time"] = time();
    $id = $_SESSION['id'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
    
    $stmt->execute([$id]);
    $member = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT * FROM items WHERE 1');
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    #商品数
    $counts = $pdo->prepare('SELECT COUNT(*) AS cnt FROM items');
    $counts->execute();
    $counts = $counts->fetch();

   

} else {
    // ログインしてなければ戻す
   

    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ホーム画面</title>
    
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        <link rel="stylesheet" href="../style.css">
        <h1 style="margin: 0; font-size: 28px;">ホーム画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            
            <form action="">

                <input type="text" placeholder="検索する">
                <button type="submit"><img src="..\images\system\search.png" alt="送信" width="30" height="30"></button>
                
            </form>
            
            <p>
                <div class="auth-links">
                    <a href="acc_info.php">アカウント情報画面へ</a>
                </div>
                <div class="auth-links">
                    <a href="history.php">購入履歴画面へ</a>
                </div>
                <div class="auth-links">
                    <a href="cart.php">カート画面へ</a>
                </div>
                <div class="auth-links">
                    <a href="login.php">ログアウトへ</a>
                </div>
            </p>
            <div>商品一覧</div>
            <div>商品数<?php echo $counts["cnt"];?></div>

            <?php foreach (array_chunk($items, $max_col) as $items_row) { ?>
                <table>
                <tr>
                    <?php foreach ($items_row as $item) { ?>
                        <td>
                            <a href="item_detail.php?id=<?php echo h($item['id']); ?>">
                                <img src="..\images\items\default.png" alt="" width="150" height="150">
                                <div class="truncate-line"><?php
                                 echo h($item["name"]); ?></div>
                                <div>￥<?php echo h($item['price']); ?></div>
                            </a>
                        </td>
                    <?php } ?>
                </tr>
                </table>
            <?php } ?>
        </section>
    </main>
</body>
</html>
