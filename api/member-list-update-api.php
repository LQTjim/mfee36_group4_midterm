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
if (!empty($_FILES['hero_icon'])) {
    $filename = sha1(uniqid()) . '.jpg';

    if (move_uploaded_file($_FILES['hero_icon']['tmp_name'], "../imgs/member_imgs/{$filename}")) {
        $output['filename'] = $filename;
    } else {
        $output['error'] = 'cannot move files';
    }
}
// if (!isset($_POST['sid'])) {
//     $output['error'] = '發生錯誤';
//     header('Content-Type: application/json');
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// } else {
//     $sql = "UPDATE  member 
//     SET 
//     `email`= ?,`name`= ?,`mobile`= ?,`birth`= ?,`address`=?,`sex_sid`=?,`member_level_sid`=?,`hero_icon`=?,`role_sid`=?,`active`=? 
//      WHERE `member`.`sid` = ?";
//     $stmt = $pdo->prepare($sql);
//     $stmt-> execute([]);
//     $output['success'] = true;
//     header('Content-Type: application/json');
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
// }
header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
