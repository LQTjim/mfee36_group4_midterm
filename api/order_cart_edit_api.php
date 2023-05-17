<?php include '../parts/db-connect.php'; ?>
<?php
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];


if (!empty($_POST['sid'])) {

    $isPass = true;

    // $member_sid = trim($_POST['member_sid']);
    // $member_sid = filter_var($member_sid, FILTER_VALIDATE_INT);
    // if(empty($member_sid)){
    //     $isPass = false;
    //     $output['error']['member_sid']='會員編號格式有誤';
    // };

    $sql_input = "UPDATE 
`order_cart` 
SET
`member_sid`=?, 
`products_type_sid`=?, 
`item_sid`=?, 
`price`=?, 
`quantity`=?, 
`amount`=?, 
`created_at`=NOW()
WHERE `sid` =?";

    $stmt_input = $pdo->prepare($sql_input);
    $sid = intval($_POST['sid']);

    if ($isPass) {
        $stmt_input->execute([
            $_POST['member_sid'],
            $_POST['products_type_sid'],
            $_POST['item_sid'],
            $_POST['price'],
            $_POST['quantity'],
            $_POST['amount'],
            $sid
        ]);
    }
}

header('conten-type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE)
// header('Location: ../index_.php');

// header('Location: ../login.php');
?>