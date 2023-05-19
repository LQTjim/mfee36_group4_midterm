<?php
include '../parts/db-connect.php'; ?>
<?php
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];

if (!empty($_POST['member_sid'])) {
    $isPass = true;

    $member_sid = trim($_POST['member_sid']);
    $member_sid = filter_var($member_sid, FILTER_VALIDATE_INT);
    $products_type_sid = trim($_POST['products_type_sid']);
    $products_type_sid = filter_var($products_type_sid, FILTER_VALIDATE_INT);
    $item_sid = trim($_POST['item_sid']);
    $item_sid = filter_var($item_sid, FILTER_VALIDATE_INT);
    $output["test"] = $member_sid;
    if (empty($member_sid) || empty($products_type_sid) || empty($item_sid)) {
        // $isPass = false;
        $output['error']['member_sid'] = '格式有誤';
        $output['error']['products_type_sid'] = '格式有誤';
        $output['error']['item_sid'] = '格式有誤';
        exit;
    };




    $sql_input = "INSERT INTO `order_cart`
(`member_sid`, 
`products_type_sid`, 
`item_sid`, 
`price`, 
`quantity`, 
`amount`, 
`created_at`) 
VALUES 
(?,
?,
?,
?,
?,
?,
NOW())"; //表格製作時間created_at，以後改為now()

    $stmt_input = $pdo->prepare($sql_input);

    if ($_POST['products_type_sid'] == "課程") {
        $type = 1;
    } else if ($_POST['products_type_sid'] == "衣服") {
        $type = 2;
    } else if ($_POST['products_type_sid'] == "設備") {
        $type = 3;
    } else if ($_POST['products_type_sid'] == "食品") {
        $type = 4;
    } else if ($_POST['products_type_sid'] == 1) {
        $type = 1;
    } else if ($_POST['products_type_sid'] == 2) {
        $type = 2;
    } else if ($_POST['products_type_sid'] == 3) {
        $type = 3;
    } else if ($_POST['products_type_sid'] == 4) {
        $type = 4;
    }

    //產品編號
    if ($type == 1) {
        $quantity = 1;
    } else {
        $quantity = intval($_POST['quantity']);
    }


    if ($isPass) {
        $stmt_input->execute([
            $_POST['member_sid'], //member_sid;
            // $_POST['products_type_sid'],
            $type,
            // $_POST['item_sid'],
            $_POST['item_sid'],
            $_POST['price'],
            $quantity,
            $_POST['amount'],
        ]);
    }
    $output['success'] = !!$stmt_input->rowCount();
};

function quit()
{
    global $output;
    header("Content-Type: application/json");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
};

?>