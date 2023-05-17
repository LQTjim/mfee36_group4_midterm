<?php
require './parts/admin-required.php';
require './parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = " DELETE FROM product_name WHERE sid={$sid}";

$pdo->query($sql);

$comeFrom = 'product_list.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}


header('Location: ' . $comeFrom);
