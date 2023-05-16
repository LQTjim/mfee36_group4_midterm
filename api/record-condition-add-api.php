<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];



if (!empty($_POST['memberSid'])) {
    $isPass = true;

    $sql = "INSERT INTO `record_condition`(
        `member_sid`, `height`, `weight`, `bodyfat`, `record_time`) VALUES
        (?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([
            $_POST['memberSid'],
            $_POST['height'],
            $_POST['weight'],
            $_POST['bodyfat'],
            // $_POST['record_time'],
            (empty($_POST['record_time'])) ? (date("Y-m-d H:i:s")) : ($_POST['record_time'])
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
