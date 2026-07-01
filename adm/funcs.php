<?php 
require_once '../db.php';
function adm_login_check(){
    if (isset($_SESSION['id']) && $_SESSION["time"] + 3600 > time()) {
    $_SESSION["time"] = time();

   

} else {
    // ログインしてなければ戻す
   

    header('Location: adm/login.php');
    exit();
}
}

?>