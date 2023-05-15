<?php
$pageName = 'member';
$title = '會員列表';
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php'; ?>

<?php
$perPage =  20; # 每頁最多幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; # 用戶要看第幾頁
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
`m`.`sid` ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
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
        <div class="table-responsive member-list-table ">
            <table class="table table-hover mb-0 table-striped">
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
                                    <!-- <a href="#" class="btn btn-sm btn-outline-dark">
                                        編輯 <i class="bi bi-pen"></i></a> -->
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        操作
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <!-- <li><a class="dropdown-item" href="javascript:openUpdateModal">修改狀態</a></li> -->
                                        <li><a class="dropdown-item text-info" href="" data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-member-id="<?= $r['sid'] ?>" data-bs-member-email="<?= $r['email'] ?>" data-bs-member-name="<?= $r['name'] ?>" data-bs-member-birth="<?= $r['birth'] ?>" data-bs-member-address="<?= $r['address'] ?>" data-bs-member-sex="<?= $r['sex'] ?>" data-bs-member-heroicon="<?= $r['hero_icon'] ?>" data-bs-member-tier="<?= $r['tier'] ?>" data-bs-member-role="<?= $r['role'] ?>" data-bs-member-active="<?= $r['active'] == 1 ? "已啟用" : "未啟用" ?>">修改狀態</a></li>
                                        <li><a class="dropdown-item text-danger" href="" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-member-id="<?= $r['sid'] ?>">刪除</a></li>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確認刪除編號「<span id="deleteText"></span>」的資料嗎？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">確認刪除</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">修改資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Email 姓名 生日 地址 性別 會員等級 會員頭像 會員權限 啟用狀態 -->

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="emailInput">
                    </div>
                    <div class="mb-3">
                        <label for="birth" class="form-label">生日</label>
                        <input type="date" class="form-control" id="birthInput">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">地址</label>
                        <input type="text" class="form-control" id="addressInput">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">性別</label>
                        <!-- <input type="text" class="form-control" id="sexInput"> -->
                        <select class="form-select" id="sexInput">
                            <option value="男">男</option>
                            <option value="女">女</option>
                            <option value="不透露">不透露</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">會員等級</label>
                        <!-- <input type="text" class="form-control" id="tierInput"> -->
                        <select class="form-select" id="tierInput">
                            <option value="銅牌會員">銅牌會員</option>
                            <option value="銀牌會員">銀牌會員</option>
                            <option value="金牌會員">金牌會員</option>
                            <option value="白金會員">白金會員</option>
                            <option value="鑽石會員">鑽石會員</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateImg" class="form-label">會員頭像</label>
                        <input type="file" class="form-control" id="updateImg">
                        <div class="mt-2"><img class="d-block mb-3" style="width:50px;height:50px;object-fit:cover;" src="" alt="" id="heroiconInput"></div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">會員權限</label>
                        <select class="form-select" id="roleInput">
                            <option value="用戶">用戶</option>
                            <option value="教練">教練</option>
                            <option value="管理員">管理員</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">啟用狀態</label>
                        <!-- <input type="text" class="form-control" id="activeInput"> -->
                        <select class="form-select" id="activeInput">
                            <option value="已啟用">已啟用</option>
                            <option value="未啟用">未啟用</option>
                        </select>
                    </div>

                    <p>確認修改編號「<span id="updateText"></span>」的資料嗎？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">確認修改</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const tbody = document.querySelector('[data-tbody]');
            const tdCheckbox = document.querySelectorAll('td input[checkbox]:checked')
            console.log(tdCheckbox)
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

            const modalByDelete = document.querySelector('#deleteModal');
            modalByDelete.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                console.log(button)
                const memberId = button.dataset.bsMemberId;
                modalByDelete.setAttribute('data-sid', memberId)
                const modalText = modalByDelete.querySelector('#deleteText');
                modalText.textContent = memberId;
            })
            const modalByUpdate = document.querySelector('#updateModal');
            modalByUpdate.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                //active role hero_icon tier sex address birth
                const {
                    bsMemberId: memberId,
                    bsMemberEmail: memberEmail,
                    bsMemberBirth: memberBirth,
                    bsMemberAddress: memberAddress,
                    bsMemberSex: memberSex,
                    bsMemberTier: memberTier,
                    bsMemberHeroicon: memberHeroicon,
                    bsMemberRole: memberRole,
                    bsMemberActive: memberActive,
                } = button.dataset;
                const modalText = modalByUpdate.querySelector('#updateText');
                modalText.textContent = memberId;
                const modalEmailInput = modalByUpdate.querySelector('#emailInput')
                modalEmailInput.value = memberEmail
                const modalBirthInput = modalByUpdate.querySelector('#birthInput')
                modalBirthInput.value = memberBirth
                const modalAddressInput = modalByUpdate.querySelector('#addressInput')
                modalAddressInput.value = memberAddress
                const modalSexInput = modalByUpdate.querySelector('#sexInput')
                modalSexInput.value = memberSex
                const modalTierInput = modalByUpdate.querySelector('#tierInput')
                modalTierInput.value = memberTier
                const modalHeroiconInput = modalByUpdate.querySelector('#heroiconInput')
                modalHeroiconInput.src = memberHeroicon
                const modalRoleInput = modalByUpdate.querySelector('#roleInput')
                modalRoleInput.value = memberRole
                const modalActiveInput = modalByUpdate.querySelector('#activeInput')
                modalActiveInput.value = memberActive
            })
            const deleteBtn = document.querySelector('#deleteModal button.btn.btn-danger')
            deleteBtn.addEventListener('click', () => {
                const fd = new FormData();
                fd.append("sid", modalByDelete.dataset['sid'])

                fetch('./api/member-list-delete-api.php', {
                    method: 'POST',
                    body: fd
                }).then((res) => res.json()).then(
                    (data) => {
                        if (data.success) {
                            Swal.fire({
                                text: '刪除成功',
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                            setTimeout(() => {
                                location.href = `/mfee36_group4_midterm/member_list.php?page=<?= $page ?>`
                            }, 1500)
                        }

                    }
                ).catch((err) => {
                    Swal.fire({
                        text: '刪除失敗，請聯絡工程師',
                        icon: 'error',
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                })

            })
            const updateBtn = document.querySelector('#updateModal button.btn.btn-info')
            updateBtn.addEventListener('click', () => {
                console.log('work')
            })
        })()
    </script>
</div>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>