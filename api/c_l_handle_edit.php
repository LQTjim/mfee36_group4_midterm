<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $table_name = 'c_l_coach' ;

    $output = [
        'success' => false,
        'post' => $_POST,
        'files' => $_FILES,
        'error' => []
    ];

    if(empty($_FILES['data'])) quit() ;
    
    list( $file_type, $file_extension ) = explode("/", $_FILES['data']['type'] ) ;

    if($file_type !== 'image') quit() ;

    $result = saveImage() ;

    if(!$result) quit('fail to move file') ;

    $sql = "UPDATE `{$table_name}`
            SET `{$_POST['type']}` = '{$result}' 
            WHERE `sid` = {$_POST['sid']}"
    ;

    $statment = $pdo->query($sql) ;

    $output['success'] = !! $statment->rowCount() ;

    quit() ;

    // ----------------- function declare blow -----------------

    function saveImage() {
        global $file_extension ;

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