<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'post' => $_POST,
        'test' => []
    ];

    $table_name = 'c_l_coach' ;

    $sql = "UPDATE `{$table_name}` SET `{$_POST['type']}` = './assets/coach_imgs/{$_FILES['data']['name']}' WHERE `sid` = {$_POST['sid']}" ;

    $statment = $pdo->query($sql) ;

    $output['success'] = !! $statment->rowCount() ;

    header('Content-Type: application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>