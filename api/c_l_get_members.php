<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'get' => $_GET,
        'data' => [],
        'error' => [],
    ];

    if( empty($_GET['id']) ) quit('輸入值錯誤') ;
    if( !is_numeric($_GET['id']) ) quit('輸入值錯誤') ;

    $id = intval($_GET['id']) ;

    $c_sql = "SELECT `member_sid` FROM `c_l_coach`" ;
    $c_statment = $pdo->query($c_sql) ;
    $c_rows = $c_statment->fetchAll() ;

    foreach($c_rows as $rows) {
        if(in_array($id, $rows))
            quit('此教練已登錄') ;
    }

    $sql = "SELECT * FROM `member` WHERE `sid` = {$id}" ;
    $statment = $pdo->query($sql) ;
    $row = $statment->fetch();

    if(!isset($row['role_sid']) || empty($row['role_sid'])) quit('資料庫錯誤') ;

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