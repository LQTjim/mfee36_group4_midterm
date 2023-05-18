<?php
require './../parts/db-connect.php';
//錯誤訊息、error code
$output = [
    'success' => false,
    'postData' => $_POST,
    'filename' => '',
    'files' => $_FILES,
    'code' => 0,
    'error' => []
];

$sql = "UPDATE  member 
    SET 
    `name`= ?,`mobile`= ?,`birth`= ?,
    `address`=?,`sex_sid`=?,`member_level_sid`=?,
    `role_sid`=?,`active`=? 
     WHERE `member`.`sid` = ?";
$stmt = $pdo->prepare($sql);
$mobile = $_POST['mobile'] !== '' ? $_POST['mobile'] : null;
$birth = $_POST['birth'] !== '' ? $_POST['birth'] : null;
$address = $_POST['address'] !== '' ? $_POST['address'] : null;
$stmt->execute([$_POST['name'], $mobile, $birth, $address, $_POST['sex'], $_POST['level'], $_POST['role'], $_POST['active'], $_POST['sid']]);
$output['success'] = true;
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
