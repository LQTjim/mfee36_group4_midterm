<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];


if (!empty($_POST['sid'])) {
    $isPass = true;

    $sql = "UPDATE `record_diet_record` SET `member_sid`=?,`food_sid`=?,`quantity`=?,`diet_time`=? WHERE `record_diet_record`.`sid` = ?";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['memberSid'],
            $_POST['foodSid'],
            $_POST['quantity'],
            (empty($_POST['diet_time'])) ? (date("Y-m-d H:i:s")) : ($_POST['diet_time']),
            $_POST['sid']
        ]);
        $output['success'] = !!$stmt->rowCount();
        // $output['success'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
