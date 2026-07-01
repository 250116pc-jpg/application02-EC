<?php
session_start();
require_once '../db.php';
require_once '../funcs.php';

$max_row = 10;
$max_col = 5;
$error = "";
$pdo = getPdo();

// 1. ログインチェック
login_check();
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

if(!empty($_GET)){
    $search = $_GET["search"] ?? "";
    $category = $_GET["category"];
    
    $c_text = [
        2 => "is_CD",
        3 => "is_DVD_BD",
        4 => "is_comic",
        6 => "is_novel",
        7 => "is_goods",
        8 => "is_game",
    ];
    if ($category == 1) {
        $stmt = $pdo->prepare(
            "SELECT * FROM items WHERE name LIKE ?"
        );
        
        $counts = $pdo->prepare('SELECT COUNT(*) AS cnt FROM items WHERE name LIKE ?');
        
    } else {
        $text = $c_text[$category];

        $stmt = $pdo->prepare(
            "SELECT * FROM items
            WHERE name LIKE ?
            AND $text = 1"
        );
        
        $counts = $pdo->prepare("SELECT COUNT(*) AS cnt FROM items WHERE name LIKE ?
            AND $text = 1");
    }
    

    $stmt->execute(["%$search%"]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $counts->execute(["%$search%"]);
    $counts = $counts->fetch();
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
            
            <form action="" method="GET">

                <input type="text" name="search" value="<?php echo isset($search) ? h($search) : ''; ?>" placeholder="検索する">
                <button type="submit"><img src="..\images\system\search.png" alt="送信" width="30" height="30"></button>
                
            
            カテゴリ<select name="category">
                <option value="1" <?= (($_GET["category"] ?? "1") == "1") ? "selected" : "" ?>>すべて</option>
                <option value="2" <?= (($_GET["category"] ?? "1") == "2") ? "selected" : "" ?>>CD</option>
                <option value="3" <?= (($_GET["category"] ?? "1") == "3") ? "selected" : "" ?>>DVD・Blu-ray</option>
                <option value="4" <?= (($_GET["category"] ?? "1") == "4") ? "selected" : "" ?>>コミック</option>
                <option value="6" <?= (($_GET["category"] ?? "1") == "6") ? "selected" : "" ?>>ノベル</option>
                <option value="7" <?= (($_GET["category"] ?? "1") == "7") ? "selected" : "" ?>>フィギュア・グッズ</option>
                <option value="8" <?= (($_GET["category"] ?? "1") == "8") ? "selected" : "" ?>>ゲームソフト</option>
            </select>
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
                            <a href="item_detail.php?id=<?php echo h($item['id']); ?> ">
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
