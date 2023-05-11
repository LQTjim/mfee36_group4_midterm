<?php
require './../parts/db-connect.php';
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => []
];
if (!empty($_POST['email']) and !empty($_POST['password'])) {

    $sql = "SELECT * FROM member WHERE email=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $_POST['email']
    ]);

    $row = $stmt->fetch();

    if (empty($row)) {
        $output['code'] = 410; # 帳號是錯的
        $output['error'][0] = '您的帳號不存在';
    } else if ($row['role_sid'] !== '3') {
        # 驗證 role_sid = 3為admin
        $output['code'] = 410;
        $output['error'][0] = '您的權限不足';
    } else {
        if (password_verify($_POST['password'], $row['password'])) {
            # 密碼也是對的
            $_SESSION['admin'] = $row;
            $output['success'] = true;
        } else {
            # 密碼是錯的
            $output['code'] = 420;
            $output['error'][0] = '您的密碼錯誤';
        }
    }
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);
