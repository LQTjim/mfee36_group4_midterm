<?php $pageName = 'product'; ?>
<?php
include './parts/admin-required.php'; ?>
<?php include './parts/db-connect.php'; ?>

<?php include './parts/html-head.php'; ?>
<?php include './parts/html-navbar.php'; ?>
<?php
$perPage =  10; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `product_name`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];
if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
}
$sql = sprintf("SELECT p.*, pc.`categories_name` FROM `product_name` p 
JOIN product_categories as pc 
ON p.category_id=pc.sid ORDER BY p.`sid`  LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);
$rows = $pdo->query($sql)->fetchAll();
// $sql_categories = "
// SELECT
// 	pc.categories_name
// FROM 
// 	product_name as pn 
// JOIN 
// 	product_categories as pc 
// ON 
// 	pn.category_id=pc.sid;

// ";
// $categories = $pdo->query($sql_categories)->fetchAll();


?>
<div class="row">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=1">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            </li>
            <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            </li>
            <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                if ($i >= 1 and $i <= $totalPages) :
            ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
            <?php endif;
            endfor; ?>
            <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                    <i class="fa-solid fa-angle-right"></i>
                </a>
            </li>
            <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $totalPages ?>">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
            </li>
        </ul>


    </nav>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
            <th scope="col">編號</th>
            <th scope="col">商品名稱</th>
            <th scope="col">產品描述</th>
            <th scope="col">產品類別</th>
            <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td><a href="javascript: delete_it(<?= $r['sid'] ?>)">
                        <i class="fa-solid fa-trash-can"></i>
                    </a></td>
                <td><?= $r['sid'] ?></td>
                <td><?= $r['product_name'] ?></td>
                <td><?= $r['description'] ?></td>
                <td><?= $r['categories_name'] ?></td>
                <td><a href="product_edit.php?sid=<?= $r['sid'] ?>">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

            </tr>
        <?php endforeach; ?>
    </tbody>

    <?php
    include './parts/html-navbar-end.php'; ?>

    <?php include './parts/html-scripts.php' ?>
    <script>
        document.querySelector('li.page-item.active a').removeAttribute('href');

        function delete_it(sid) {
            if (confirm(`是否要刪除編號為 ${sid} 的資料?`)) {
                location.href = 'product_delete.php?sid=' + sid;
            }

        }
    </script>
    <?php include './parts/html-footer.php' ?>