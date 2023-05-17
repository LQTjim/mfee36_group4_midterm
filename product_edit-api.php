<?php
require './parts/admin-required.php';
require './parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];



if (!empty($_POST['name']) and !empty($_POST['sid'])) {
    $isPass = true;


    # TODO: 檢查欄位資料
    $email = trim($_POST['email']); # 去掉頭尾的空白
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (empty($email)) {
        $isPass = false;
        $output['error']['email'] = 'Email 格式不正確';
    }


    $birthday = empty($_POST['birthday']) ? null : $_POST['birthday'];


    $sql = "UPDATE `product_name` SET 
    `name`=?,
    `email`=?,
    `mobile`=?,
    `birthday`=?,
    `address`=?
    
    WHERE `sid`=? ";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['mobile'],
            $birthday,
            $_POST['address'],
            $_POST['sid'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
