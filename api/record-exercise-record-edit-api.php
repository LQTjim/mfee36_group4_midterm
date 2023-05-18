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

    $sql = "UPDATE `record_exercise_record` SET
        `member_sid`=?, `exe_type_sid`=?, `weight`=?, `sets`=? ,`reps`=?, `exe_date`=?
        WHERE `record_exercise_record`.`sid` = ?";

    $stmt = $pdo->prepare($sql);

    if ($isPass) {
        $stmt->execute([

            $_POST['memberSid'],
            $_POST['exe-type-sid'],
            $_POST['weight'],
            $_POST['sets'],
            $_POST['reps'],
            (empty($_POST['exe-date'])) ? (date("Y-m-d H:i:s")) : ($_POST['exe-date']),
            $_POST['sid']
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
