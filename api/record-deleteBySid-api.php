<?php
require '../parts/db-connect.php';

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
    $sql = sprintf("DELETE FROM %s WHERE %s.sid = %s", $_POST['db'], $_POST['db'], $_POST['sid']);
    // $sql = sprintf("DELETE FROM record_diet_record WHERE `record_diet_record`.`sid` = %s", $_POST['sid']);
    // $sql = sprintf("DELETE FROM record_condition WHERE `record_condition`.`sid` = %s", $_POST['sid']);
    $pdo->query($sql);
    $output['success'] = true;
    header('Content-Type: application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}
