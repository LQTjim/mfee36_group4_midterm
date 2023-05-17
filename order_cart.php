<?php
$pageName = 'Cart';
$title = 'Cart'
?>
<?php include "./parts/db-connect.php"; ?>

<?php
$perPage = 20; #每頁幾筆資料
$totolRows = //抓總筆數
    "SELECT
    count(*)
FROM
    order_cart
";
$totalRowsNum = $pdo->query($totolRows)->fetch(PDO::FETCH_NUM)[0];
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$totalPage = ceil($totalRowsNum / $perPage);

if ($page < 1) {
    header('location: ?page=1');
    exit;
};

if ($totalRowsNum) :
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
    <!-- 上方分頁紐 -->
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

    <!-- 主介面 -->
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>編輯</th>
                    <th>編號</th>
                    <th>會員編號</th>
                    <th>會員姓名</th>
                    <th>產品類型(編號)</th>
                    <th>單價(NTD)</th>
                    <th>數量</th>
                    <th>小計(NTD)</th>
                    <th></th>加入購物車時間</th>
                    <th>刪除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows_order_cart as $r) : ?><a href=></a>
                    <tr>
                        <td><a href=""><i class=" fa-solid fa-pen-to-square"></i></a></td>
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['member_sid'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['product_type'] ?></td>
                        <td><?= $r['price'] ?></td>
                        <td><?= $r['quantity'] ?></td>
                        <td><?= $r['amount'] ?></td>
                        <td><?= $r['created_at'] ?></td>
                        <td><a href="./api/order_cart_delete.php?sid=<?= $r['sid'] ?>"><i class="fa-solid fa-trash"></i></a></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- 下方分頁紐 -->
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
<script>
    // document.querySelector('#pageNow').removeAttribute('href');
</script>

<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<?php include "./parts/html-footer.php"; ?>