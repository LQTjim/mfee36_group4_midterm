<?php
    include '../parts/admin-required.php' ;
    include '../parts/db-connect.php' ;

    $output = [
        'success' => false,
        'post' => $_POST,
        'files' => $_FILES,
        'error' => [],
        'test' => [],
    ];

    if(!isset($_POST)) quit() ;
    if(empty($_POST['member_sid'])) quit('no member id') ;
    if(empty($_POST['introduction'])) quit('no intro') ;

    $photo_path = SaveImage() ;
    if($photo_path) {
        $_POST['photo'] = $photo_path ; 
    }

    $certis = $_POST['certification'] ;
    unset($_POST['certification']) ;
    
    // insert data first
    if(!InsertData()) quit('fail to insert data') ;
    // put coach id to output variable
    $output['id'] = getCoachId() ;
    // insert certification data
    if(!HandleCerti()) quit('fail to insert certification') ;

    $output['success'] = true ;
    quit() ;

    function InsertData() {
        global $pdo ;
        $head_sql = "INSERT INTO `c_l_coach`( ";
        $tail_sql = "" ;
    
        foreach($_POST as $key => $value) {
            if(empty($value)) continue ;
            $frag_sql = "`{$key}`," ;
            $head_sql = $head_sql . $frag_sql ;
    
            $frag_sql = "?," ;
            $tail_sql = $tail_sql . $frag_sql ;
        }
    
        $head_sql = rtrim($head_sql, ",") ;
        $head_sql = $head_sql . ") VALUES (" ;
    
        $tail_sql = rtrim($tail_sql, ",") ;
        $tail_sql = $tail_sql . ")" ;
    
        $final_sql = $head_sql . $tail_sql ;
        $statment = $pdo->prepare($final_sql) ;
        $post_values = array_values(array_filter($_POST)) ;
        $statment->execute($post_values) ;

        return !! $statment->rowCount() ;
    }

    function HandleCerti() {
        global $pdo, $certis ;

        if(empty($certis)) return true;

        $sid = getCoachId() ;
        $certis = explode(",", $certis) ;

        foreach($certis as $certi) {
            $cid = intval($certi) ;
            $add_sql = "INSERT INTO `c_l_rela_coach_certification` 
                        ( `coach_sid`, `certification_sid` ) 
                        VALUES ( {$sid}, {$cid} )"
            ;
            $add_stm = $pdo->query($add_sql) ;
        }
        return !! $add_stm->rowCount() ;
    }

    function getCoachId() {
        global $pdo ;

        $m_sid = intval($_POST['member_sid']) ;
        $get_cid_sql = "SELECT `sid` FROM `c_l_coach` 
                        WHERE `member_sid` = {$m_sid} "
        ;
        $g_c_stmt = $pdo->query($get_cid_sql) ;
        $row = $g_c_stmt->fetch() ; 
        $sid = intval($row['sid']) ;
        return $sid ;
    }

    function SaveImage() {
        if(empty($_FILES['photo'])) return false;
        
        $file_type = explode("/", $_FILES['photo']['type'] )[0] ;
    
        if($file_type !== 'image') return false ;

        $tmp_array = explode("/", $_FILES['photo']['type'] ) ;
        $file_extension = end($tmp_array) ;

        $file_name = sha1( $_FILES['photo']['name'] . uniqid() ) ;
        $save_path = "./imgs/coach_imgs/{$file_name}" ;

        if($file_extension !== 'webp') {
            $save_path = "{$save_path}.{$file_extension}" ;

            return move_uploaded_file($_FILES['photo']['tmp_name'], ".{$save_path}") ?
                $save_path : false ;
        }

        $webp_img = imagecreatefromwebp($_FILES['photo']['tmp_name']) ;

        if(!$webp_img) return false ;

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