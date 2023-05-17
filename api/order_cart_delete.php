<?php
include './parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM `order_cart` WHERE `order_cart`.`sid` = $sid";

$pdo->query($sql);

// header('Location: order_cart.php');
