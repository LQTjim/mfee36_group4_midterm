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

    if (!empty($_POST['sid'])) {
        $output['success'] = true;
    };

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
?>