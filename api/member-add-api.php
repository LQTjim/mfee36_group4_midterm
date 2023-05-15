<?php
require './../parts/db-connect.php';
//錯誤訊息、error code
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
