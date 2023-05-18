<?php
require './../parts/db-connect.php';
$output = [
    'success' => false,
    'postData' => $_POST['deleteSids'],
    'code' => 0,
    'error' => []
];
foreach ($_POST['deleteSids'] as $k => $v) {
    $sql = " DELETE FROM `member` WHERE `member`.`sid` = ? ";
    $stmt = $pdo->prepare($sql);
    $v = intval($v);
    $stmt->execute([$v]);
}
$output['success'] = true;
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
