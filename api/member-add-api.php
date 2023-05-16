<?php
require './../parts/db-connect.php';
//錯誤訊息、error code
// print_r($_POST['email']);
// print_r($_POST['name']);
// print_r($_POST['password']);
// echo count($_POST['email']);
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];
for ($i = 0; $i < count($_POST['email']); $i++) {
    $sql = "INSERT INTO `member`(`email`, `password`, `name`) VALUES (? ,? ,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['email'][$i], password_hash($_POST['password'][$i], PASSWORD_BCRYPT), $_POST['name'][$i]]);
}
$output['success'] = true;
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
