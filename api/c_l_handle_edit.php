<?php

    $output = [
        'success' => false,
        'post' => $_POST
    ];

    header('Content-Type: application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>