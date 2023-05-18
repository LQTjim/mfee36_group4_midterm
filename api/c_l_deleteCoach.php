<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'get' => $_GET,
        'error' => [],
    ];

    if(!isset($_GET)) quit() ;
    if(empty($_GET)) quit() ;
    if($_GET['id'] != 9) quit('not 9') ;

    $sid = intval($_GET['id']) ;
    $d_sql = "DELETE FROM `c_l_coach` WHERE `sid` = {$sid}" ;

    $d_stmt = $pdo->query($d_sql) ;
    $output['success'] = !! $d_stmt->rowCount() ;

    quit() ;

    function quit($info = null) {
        global $output ;

        if(!empty($info)) $output['error'] = $info ;

        header('Content-Type: application/json');
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

        exit ;
    }