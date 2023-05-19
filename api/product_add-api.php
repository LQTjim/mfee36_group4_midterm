<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST, # 除錯用的
    'code' => 0,
    'error' => [],
];



if (!empty($_POST['name'])) {
    $isPass = true;



    $sql = "INSERT INTO `product_name`(`product_name`, `description`, `category_id`) VALUES (
            ?, ?, 4 )";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([$_POST['name'], $_POST['description']]);
        $output['success'] = true;
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
