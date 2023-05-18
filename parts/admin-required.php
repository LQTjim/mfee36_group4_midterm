<?php

if (!isset($_SESSION)) {
    session_start();
}

// if (!isset($_SESSION['admin'])) {
//     header('Location: login.php');
//     exit; #沒有登入就導入到 登入頁面
// }
