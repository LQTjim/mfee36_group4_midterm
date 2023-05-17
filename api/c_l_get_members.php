<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'get' => $_GET,
        'data' => [],
        'error' => [],
    ];

    if( empty($_GET['id']) ) quit('empty') ;
    if( !is_numeric($_GET['id']) ) quit('not num') ;

    $id = intval($_GET['id']) ;

    $sql = "SELECT * FROM `member` WHERE `sid` = {$id}" ;

    $statment = $pdo->query($sql) ;
    $row = $statment->fetch();

    if(!!! $statment->rowCount()) quit('sql error') ;

    if(!isset($row['role_sid']) || empty($row['role_sid'])) quit('no role') ;

    if($row['role_sid'] !== "2") quit('該會員尚未登錄為教練') ;

    $output['success'] = true ;
    $output['data'] = $row['name'] ;

    quit() ;

    function quit($info = null) {
        global $output ;

        if(!empty($info)) $output['error'] = $info ;

        header('Content-Type: application/json');
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

        exit ;
    }

?>