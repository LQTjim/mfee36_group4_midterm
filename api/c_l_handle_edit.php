<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'post' => $_POST,
        'files' => $_FILES,
        'error' => []
    ];

    $type_gate = [
        'photo' => 'EditPhoto',
        'name' => 'EditData',
        'nickname' => 'EditData',
        'date' => 'EditData',
        'experience' => 'EditData',
        'introduction' => 'EditData',
    ] ;

    if(empty($_POST['type'])) quit() ;

    $type_gate[$_POST['type']]() ;

    function EditData() {
        global $pdo, $output;

        if(empty($_POST['data'])) quit() ;

        $sql_gate = [
            'name' => " UPDATE `member` SET `{$_POST['type']}` = '{$_POST['data']}' 
                        WHERE `sid` = ( SELECT `member_sid` FROM `c_l_coach` 
                        WHERE `sid` = {$_POST['sid']} ) ",

            'nickname' => " UPDATE `c_l_coach` SET `{$_POST['type']}` = '{$_POST['data']}' 
                            WHERE `sid` = {$_POST['sid']} ",
                            
            'date' => " UPDATE `c_l_coach` SET `created_at` = '{$_POST['data']}'
                        WHERE `sid` = {$_POST['sid']} ",

            'experience' => " UPDATE `c_l_coach` SET `{$_POST['type']}` = '{$_POST['data']}'
                              WHERE `sid` = {$_POST['sid']} ",
            'introduction' => " UPDATE `c_l_coach` SET `{$_POST['type']}` = '{$_POST['data']}'
                              WHERE `sid` = {$_POST['sid']} ",
        ] ;

        $sql = $sql_gate[$_POST['type']] ;

        $statment = $pdo->query($sql) ;
    
        $output['success'] = !! $statment->rowCount() ;
    
        quit() ;
    }

    function EditPhoto() {
        global $pdo, $output ;

        if(empty($_FILES['data'])) quit() ;
        
        $file_type = explode("/", $_FILES['data']['type'] )[0] ;
    
        if($file_type !== 'image') quit() ;
    
        $result = saveImage() ;
    
        if(!$result) quit('fail to move file') ;
    
        $sql = "UPDATE `c_l_coach`
                SET `{$_POST['type']}` = '{$result}' 
                WHERE `sid` = {$_POST['sid']}"
        ;
    
        $statment = $pdo->query($sql) ;
    
        $output['success'] = !! $statment->rowCount() ;
    
        quit() ;
    }

    function saveImage() {
        $tmp_array = explode("/", $_FILES['data']['type'] ) ;
        $file_extension = end($tmp_array) ;

        $file_name = sha1( $_FILES['data']['name'] . uniqid() ) ;
        $save_path = "./imgs/coach_imgs/{$file_name}" ;

        if($file_extension !== 'webp') {
            $save_path = "{$save_path}.{$file_extension}" ;

            return move_uploaded_file($_FILES['data']['tmp_name'], ".{$save_path}") ?
                $save_path : false ;
        }

        $webp_img = imagecreatefromwebp($_FILES['data']['tmp_name']) ;

        if(!$webp_img) quit('fail to trans webp') ;

        $save_path = "{$save_path}.jpg" ;

        $result = imagejpeg($webp_img, ".{$save_path}", 100) ?
            $save_path : false ;
            
        imagedestroy($webp_img) ;
        return $result ;
    }

    function quit($info = null) {
        global $output ;

        if(!empty($info)) $output['error'] = $info ;

        header('Content-Type: application/json');
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

        exit ;
    }

?>