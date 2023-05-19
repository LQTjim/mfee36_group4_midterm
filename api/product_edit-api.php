<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];



if (!empty($_POST['name']) and !empty($_POST['sid'])) {
    $isPass = true;



    $sql = "UPDATE `product_name` SET 
    `product_name`=?,
    `description`=? 
    WHERE `sid`=?";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['sid'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
