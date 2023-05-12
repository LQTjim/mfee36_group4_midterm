<?php
$pageName = 'member';
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php'; ?>
<?php
// $sql = 'SELECT
// m.`sid`,
// m.`email`,
// m.`name`,
// m.`mobile`,
// m.`birth`,
// m.`address`,
// ms.`name` AS `sex`,
// ml.tier,
// m.`hero_icon`,
// mr.role,
// m.`created_at`,
// m.`active`
// FROM
// `member` m
// JOIN `member_sex` ms ON m.sex_sid = ms.sid
// JOIN `member_level` ml ON m.`member_level_sid` = ml.sid
// JOIN `member_role` mr ON m.`role_sid` = mr.sid
// ORDER BY
// `m`.`created_at` ASC';
$sql = "SELECT rc.sid, m.name, ms.name AS `sex`, m.birth, rc.height, rc.weight, rc.bodyfat, rc.record_time
FROM `record_condition` rc
JOIN `member` m ON rc.member_sid = m.sid AND m.active='1'
JOIN `member_sex` ms ON m.sex_sid=ms.sid
ORDER BY rc.record_time DESC";

$rows = $pdo->query($sql)->fetchAll();

print_r($rows);
exit;

?>
<div class="card shadow-sm">
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
            <input type="search" class="form-control border-0 shadow-none">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="align-middle">
                        <th scope="col" class="ps-4">
                            <input type="checkbox" class="form-check-input">
                        </th>
                        <th scope="col" class="py-3 ">會員編號</th>
                        <th scope="col">姓名</th>
                        <th scope="col">性別</th>
                        <th scope="col">生日</th>
                        <th scope="col">身高</th>
                        <th scope="col">體重</th>
                        <th scope="col">體脂肪率</th>
                        <th scope="col">紀錄時間</th>
                        <th scope="col" class="pe-4">編輯</th>
                    </tr>
                </thead>
                <tbody class="text-nowrap">
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <!-- [0] => Array ( [sid] => 24 [name] => 王教練 [sex] => 男 [birth] => 1993-05-02 [height] => 180.2 [weight] => 76.6 [bodyfat] => 22 [record_time] => 2023-05-31 00:00:00 -->
                            <td scope="row"><?= $r['sid'] ?></td>
                            <td>
                                <div><?= $r['name'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['sex'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['birth'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['height'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['weight'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['bodyfat'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['hero_icon'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['role'] ?></div>
                            </td>


                            <td><?= $r['created_at'] ?></td>
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
                <li class="page-item"><a class="page-link" href="#">前一頁</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">下一頁</a></li>
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