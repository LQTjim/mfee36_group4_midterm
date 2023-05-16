<?php
$pageName = 'Cart';
$title = 'Cart'
?>
<?php include "./parts/db-connect.php"; ?>

<?php
// include './connectdb.php';
// include './order_select.php';
$perPage = 10; #每頁幾筆資料
$totolRows = //抓總筆數
    "SELECT
    count(*)
FROM
    order_cart
";
$totalRowsNum = $pdo->query($totolRows)->fetch(PDO::FETCH_NUM)[0];
// echo json_encode($totalPageNum);
// exit;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('location: ?page=1');
    exit;
};


if ($totalRowsNum) :
    $totalPage = ceil($totalRowsNum / $perPage);
    if ($page > $totalPage) :
        header("location:?page=$totalPage");
    endif;

    $sql_order_cart =
        sprintf("SELECT 
    oc.*, member.name, ot.product_type
FROM 
    order_cart as oc
LEFT JOIN 
    order_product_type as ot
ON 
    ot.sid = oc.products_type_sid
LEFT JOIN 
    member
ON
    oc.member_sid=member.sid
ORDER BY
    oc.sid
LIMIT
    %s, %s", ($page - 1) * $perPage, $perPage);

    $stmt_order_cart = $pdo->query($sql_order_cart);
    $rows_order_cart = $stmt_order_cart->fetchAll();
endif;




?>

<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>

<div class="container">
    <div class="row">
        <nav aria-label="Page navigation example">
            <ul class="pagination">

                <!-- page begining and page-1 -->
                <li class="page-item"><a class="page-link <?= ($page == 1) ? 'disabled' : '' ?>" href="?page=<?= 1 ?>">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>
                <li class="page-item"><a class="page-link <?= ($page == 1) ? 'disabled' : '' ?>" href=" ?page=<?= $page - 1 ?>">
                        <i class="fa-solid fa-angle-left"></i></a>
                </li>

                <!-- page button -->
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i >= 1 and $i <= $totalPage) : ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <?php if ($i == $page) : ?>
                                <span class="page-link" href="?page=<?= $i ?>"><?= $i ?></span>
                            <?php else : ?>
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php endif; ?>
                        </li>
                <?php endif;
                endfor ?>

                <!-- page+1 and page end -->
                <li class="page-item"><a class="page-link <?= ($page == $totalPage) ? 'disabled' : '' ?>" href="?page=<?= $page + 1 ?>">
                        <i class="fa-solid fa-angle-right"></i></a>
                </li>
                <li class="page-item"><a class="page-link <?= ($page == $totalPage) ? 'disabled' : '' ?>" href="?page=<?= $totalPage ?>">
                        <i class="fa-solid fa-angles-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">編號</th>
                    <th scope="col">會員編號</th>
                    <th scope="col">會員姓名</th>
                    <th scope="col">產品類型(編號)</th>
                    <th scope="col">單價(NTD)</th>
                    <th scope="col">數量</th>
                    <th scope="col">小計(NTD)</th>
                    <th scope="col">加入購物車時間</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows_order_cart as $r) : ?>
                    <tr>
                        <th scope="row"><?= $r['sid'] ?></th>
                        <td><?= $r['member_sid'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['product_type'] ?></td>
                        <td><?= $r['price'] ?></td>
                        <td><?= $r['quantity'] ?></td>
                        <td><?= $r['amount'] ?></td>
                        <td><?= $r['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    // document.querySelector('#pageNow').removeAttribute('href');
</script>

<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<?php include "./parts/html-footer.php"; ?>