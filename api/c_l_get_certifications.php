<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'get' => $_GET,
        'data' => [],
        'error' => []
    ];

    $sql = "SELECT * FROM `c_l_certification`" ;

    $statment = $pdo->query($sql) ;
    $rows = $statment->fetchAll() ;

    $output['data'] = $rows ;
    quit() ;

    function quit($info = null) {
        global $output ;

        if(!empty($info)) $output['error'] = $info ;

        header('Content-Type: application/json');
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

        exit ;
    }

?>