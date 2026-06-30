<?php 
require_once '../db.php';
function login_check(){
    if (isset($_SESSION['id']) && $_SESSION["time"] + 3600 > time()) {
    $_SESSION["time"] = time();

   

} else {
    // ログインしてなければ戻す
   

    header('Location: login.php');
    exit();
}
}

?>