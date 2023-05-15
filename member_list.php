<?php
$pageName = 'member';
$title = '會員列表';
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php'; ?>

<?php
$perPage =  20; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁
echo $page . '<div>page</div>' . '<br/>';
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}
$t_sql = "SELECT COUNT(1) FROM `member`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0]; # 總筆數
$totalPages = ceil($totalRows / $perPage); # 總頁數
$rows = [];
if ($totalRows) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }

    $sql = sprintf("SELECT
m.`sid`,
m.`email`,
m.`name`,
m.`mobile`,
m.`birth`,
m.`address`,
ms.`name` AS `sex`,
ml.tier,
m.`hero_icon`,
CASE 
    mr.role 
    WHEN 'admin' THEN '管理員'    
    WHEN 'user' THEN '用戶'
    WHEN 'coach' THEN '教練'
    ELSE '未知狀態'
END AS `role`,
m.`created_at`,
m.`active`
FROM
`member` m
JOIN `member_sex` ms ON m.sex_sid = ms.sid
JOIN `member_level` ml ON m.`member_level_sid` = ml.sid
JOIN `member_role` mr ON m.`role_sid` = mr.sid
ORDER BY
`m`.`created_at` ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $rows = $pdo->query($sql)->fetchAll();
}
?>
<link rel="stylesheet" href="./css/member.css">
<div>
    <a href="index.php">首頁</a>
    >>
    <a href="javascript: return;">會員列表</a>
</div>
<div class="card shadow-sm">
    <div class="card-footer bg-transparent py-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end mb-0">
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
                <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
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
    <div class="card-header bg-transparent">
        <div class="input-group">
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    依類別
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">依姓名</a></li>
                    <li><a class="dropdown-item" href="#">依生日</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <span class="input-group-text border-0 bg-transparent pe-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="search" class="form-control border rounded">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive member-list-table">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="align-middle">
                        <th scope="col" class="ps-4">
                            <input type="checkbox" class="form-check-input" data-chechAll>
                        </th>
                        <th scope="col" class="py-3 ">會員編號</th>
                        <th scope="col">Email</th>
                        <th scope="col">姓名</th>
                        <th scope="col">生日</th>
                        <th scope="col  ">地址</th>
                        <th scope="col">性別</th>
                        <th scope="col">會員等級</th>
                        <th scope="col">會員頭像</th>
                        <th scope="col">會員權限</th>
                        <th scope="col">加入時間</th>
                        <th scope="col">啟用狀態</th>
                        <th scope="col" class="pe-4">編輯</th>
                    </tr>
                </thead>
                <tbody class="text-nowrap" data-tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td scope="row"><?= $r['sid'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td>
                                <?= $r['birth'] ?>
                            </td>
                            <td>
                                <div class="overflow-auto member-address "><?= $r['address'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['sex'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['tier'] ?></div>
                            </td>
                            <td>
                                <img class="member-list-hero-icon  rounded-circle" src="<?= isset($r['hero_icon']) ? $r['hero_icon'] : "./imgs/defalut_icon.jpg" ?>" alt="使用者頭像"></img>
                            </td>
                            <td>
                                <div><?= $r['role'] ?></div>
                            </td>


                            <td>
                                <div class="overflow-auto member-created_at"><?= $r['created_at'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['active'] == 1 ? "已啟用" : "未啟用" ?></div>
                            </td>
                            <td class="pe-4">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-outline-dark">
                                        編輯 <i class="bi bi-pen"></i></a>
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        操作
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">修改狀態</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-order-id="TX123456788">刪除訂單</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent py-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end mb-0">
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
                <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
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
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確認刪除「<span id="deleteText"></span>」的訂單嗎？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">確認刪除</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            tbody = document.querySelector('[data-tbody]')
            tbody.addEventListener('wheel', (e) => {
                if (e.target.classList.contains('member-address') || e.target.classList.contains('member-created_at')) {
                    if (e.deltaY == 0) return;
                    e.preventDefault();
                    e.target.scrollTo({
                        left: e.target.scrollLeft + e.deltaY,
                        behavior: "smooth"
                    });
                }
            })
        })()

        const modalByDelete = document.querySelector('#deleteModal');
        modalByDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const orderId = button.dataset.bsOrderId;
            console.log(button, orderId);
            const modalText = modalByDelete.querySelector('#deleteText');

            modalText.textContent = orderId;
        })
    </script>
</div>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>