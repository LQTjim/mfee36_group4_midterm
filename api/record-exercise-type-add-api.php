<?php
require '../parts/db-connect.php';

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];



if (!empty($_POST['exercise_name'])) {
    $isPass = true;


    $sql = "INSERT INTO `record_exercise_type`(
        `exercise_name`, `exercise_description`, `exercise_img`, `exercise_vid`) VALUES
        (?,?,?,?)";

    $stmt = $pdo->prepare($sql);


    if ($isPass) {
        $stmt->execute([
            $_POST['exercise_name'],
            $_POST['exercise_description'],
            $_POST['exercise_img'],
            $_POST['exercise_vid'],
        ]);

        $output['success'] = !!$stmt->rowCount();
    }
}
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
