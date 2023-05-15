<?php
require './../parts/db-connect.php';
//錯誤訊息、error code
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];
if (!isset($_POST['sid'])) {
    $output['error'] = '發生錯誤';
    header('Content-Type: application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    $sql = sprintf("DELETE FROM member WHERE `member`.`sid` = %s", $_POST['sid']);
    $pdo->query($sql);
    $output['success'] = true;
    header('Content-Type: application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}
