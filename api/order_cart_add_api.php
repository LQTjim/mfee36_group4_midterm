<?php include '../parts/db-connect.php'; ?>
<?php
$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => [],
];


if (!empty($_POST['member_sid'])) {

    $isPass = true;
    // $member_sid = trim($_POST['member_sid']);
    // $member_sid = filter_var($member_sid, FILTER_VALIDATE_INT);
    // if(empty($member_sid)){
    //     $isPass = false;
    //     $output['error']['member_sid']='會員編號格式有誤';
    // };

    $sql_input = "INSERT INTO 
    `order_cart`
(`member_sid`, `products_type_sid`, `item_sid`, 
`price`, `quantity`, `amount`, 
`created_at`) VALUES 
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
    if ($_POST['products_type_sid'] === 1) {
        $item = 1;
    } else {
        $item = intval($_POST['item_sid']);
    }

    // $qty = ($type === 1) ? intval(1) : random_int(1, 10); //數量
    // $p = $rows_input[$i - 1]['price'];
    // $pp = random_int(1, 20) * 100; //實體產品的價格
    // $amount = ($type === 1) ? $p : $qty * $pp; //總價
    // $price = ($type === 1) ? $p : $pp; //判斷是lession price還是product price



    if ($isPass) {
        $stmt_input->execute([
            $_POST['member_sid'], //member_sid;
            // $_POST['products_type_sid'],
            $type,

            // $_POST['item_sid'],
            $item,
            $_POST['price'],
            $_POST['quantity'],
            $_POST['amount'],
        ]);
    }
}
// header('Location: ../index_.php');

// header('Location: ../login.php');
?>