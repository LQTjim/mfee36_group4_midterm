<?php
include '../parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM `order_cart` WHERE `order_cart`.`sid` = $sid";

$pdo->query($sql);

$comeFrom = 'order_cart';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $comeFrom = $_SERVER['HTTP_REFERER'];
}

header('Location:' . $comeFrom);
