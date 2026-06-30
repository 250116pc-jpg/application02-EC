<?php
session_start();
require_once '../db.php';
$row = 10;
$col = 10;
$error = "";



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ホーム画面</title>
    
</head>
<body class="auth-page">
    <header class="auth-header" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-bottom: 40px;">
        
        <h1 style="margin: 0; font-size: 28px;">ホーム画面</h1>
    </header>

    <main class="auth-container">
        <section class="auth-card">
            

            
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
            </p>
            <div>商品一覧</div>
            <?php for ($i = 0; $i < $row; $i++) { ?>
                <table>
                <tr>
                    <?php for ($j = 0; $j < $col; $j++) { ?>
                        <td>
                            <a href="item_detail.php?id=<?php echo $i*$row+$j; ?>">はげ</a>
                        </td>
                    <?php } ?>
                </tr>
                </table>
            <?php } ?>
        </section>
    </main>
</body>
</html>
