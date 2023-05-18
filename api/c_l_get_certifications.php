<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'get' => $_GET,
        'own' => [],
        'error' => [],
        'all' => []
    ];

    if(empty($_GET['id'])) {
        $all_sql = "SELECT * FROM `c_l_certification`" ;
        $statment = $pdo->query($all_sql) ;
        
        $rows = $statment->fetchAll() ;
        $output['sussecc'] = !! $statment->rowCount() ;
        $output['all'] = $rows ;

        quit() ;
    }

    $own_sql = "SELECT `name`, `certification_sid` FROM `c_l_certification` AS certi 
                JOIN `c_l_rela_coach_certification` AS rela ON rela.coach_sid = {$_GET['id']}
                WHERE rela.certification_sid = certi.sid"
    ;

    $statment = $pdo->query($own_sql) ;
    $rows = $statment->fetchAll() ;

    $certi_array = [] ;

    foreach($rows as $row) {
        $certi_array[] = $row['certification_sid'] ;
    }

    $certi_string = implode( "', '" , $certi_array ) ;
    $certi_sql = "'{$certi_string}'" ;


    $not_sql = "SELECT `name`, `sid` FROM `c_l_certification`
                WHERE `sid` NOT IN ({$certi_sql})"
    ;

    $n_statment = $pdo->query($not_sql) ;
    $n_rows = $n_statment->fetchAll() ;

    $output['success'] = (!!$statment->rowCount() && !!$n_statment->rowCount()) ;
    $output['own'] = $rows ;
    $output['all'] = $n_rows ;

    quit() ;

    function quit($info = null) {
        global $output ;

        if(!empty($info)) $output['error'] = $info ;

        header('Content-Type: application/json');
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

        exit ;
    }

?>