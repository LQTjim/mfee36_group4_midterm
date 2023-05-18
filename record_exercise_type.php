<?php
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php';

$perPage = 5;
$pagePerSide = 4; //pages pers side on the pagniation
$pageName = 'record';
$title = 'record_exercise_type';
$data = 'record_exercise_type';
$addApi = './api/record-exercise-type-add-api.php';
?>
<link rel="stylesheet" href="./css/sean.css">

<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // if no specify page, then go to first page

if ($page < 1) {
    header('Location: ?page=1');
    exit; // finish "this php after redirect"
}

$tot_sql = "SELECT COUNT(1) FROM $data";
$tot_row =  $pdo->query($tot_sql)->fetch(PDO::FETCH_NUM)[0]; // total number of data
$totPages = ceil($tot_row / $perPage);

$rows = [];
if ($tot_row) {
    if ($page > $totPages) {
        header("Location: ?page=$totPages"); // if page > total pages, then go to last page
        exit;
    }

    // $sql = sprintf("SELECT * FROM address_book LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $sql = sprintf(
        "SELECT db.sid, db.exercise_name, db.exercise_description, db.exercise_img, db.exercise_vid, db.status
        FROM $data db
        ORDER BY db.sid DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

// print_r($rows);
// exit;

// ========================================================

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
            <div class="ms-2">
                <span class="badge bg-secondary p-2">
                    total number of data: <?= $tot_row ?>
                </span>
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
                        <th scope="col" class="py-3 ">紀錄編號</th>
                        <th scope="col">類型</th>
                        <th scope="col">敘述</th>
                        <th scope="col">圖示</th>
                        <th scope="col">影片</th>
                        <th scope="col">狀態(0/1)</th>
                        <th scope="col" class="pe-4">編輯</th>
                    </tr>
                </thead>
                <tbody class="text-nowrap">
                    <?php foreach ($rows as $r) : ?>
                        <tr data-sid=<?= $r['sid'] ?>>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <!-- db.sid, db.exercise_name, db.exercise_description, db.exercise_img, db.exercise_vid, db.status -->
                            <td scope="row">
                                <div><?= $r['sid'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['exercise_name'] ?></div>
                            </td>
                            <td>
                                <!-- <div><?= mb_substr($r['exercise_description'], 0, 20, "UTF-8") . "..." ?></div> -->
                                <div class="sean_description sean_ellipsis"><?= $r['exercise_description'] ?></div>
                            </td>
                            <td>
                                <div>
                                    <!-- <?= $r['exercise_img'] ?> -->
                                    <img class="imgBox" src="<?= $r['exercise_img'] ?>" alt="404">
                                </div>
                            </td>
                            <td>
                                <div><?= $r['exercise_vid'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['status'] ?></div>
                            </td>
                            <td class="pe-4">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-outline-dark">
                                        編輯 </a>
                                    <a href="#" class="btn btn-sm btn-outline-dark text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-order-id="<?= $r['sid'] ?>">刪除</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- pagination -->
    <?php include "./parts/html-pagination.php" ?>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">刪除資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確認刪除「編號<span id="deleteText"></span>」的資料嗎？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">確認刪除</button>
                </div>
            </div>
        </div>
    </div>

    <!-- start === add data === -->
    <div><button type="button" class="add-btn btn btn-info mb-2 ms-2 border border-primary"><i class="fa-solid fa-plus"></i>Add</button></div>

    <form name="addForm" id="addForm">
        <div class="add-form display-toggle table-responsive ms-3 me-3">
            <table class="table table-hover mb-0">

                <tbody class="text-nowrap">
                    <tr>
                        <!-- INSERT INTO `record_exercise_type`(`sid`, `exercise_name`, `exercise_description`, `exercise_img`, `exercise_vid`, `status`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]') -->
                        <td>
                            <div class="">
                                <label for="exercise_name" class="form-label">類型</label>
                                <input type="text" class="form-control" name="exercise_name" id="exercise_name" placeholder="push up">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="exercise_description" class="form-label">敘述</label>
                                <input type="text" class="form-control" name="exercise_description" id="exercise_description" placeholder="Just do it!">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="exercise_img" class="form-label">圖片路徑</label>
                                <input type="text" class="form-control" name="exercise_img" id="exercise_img" placeholder="./imgs/exercise/abc.jpg">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="exercise_vid" class="form-label">影片路徑</label>
                                <input type="text" class="form-control" name="exercise_vid" id="exercise_vid" placeholder="./vid/exercise/abc.jpg">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="col-12">
                <button class="ms-3 formBtn btn btn-success" type="button" onclick="addData(event)" data-add-api="<?= $addApi ?>">Submit form</button>

                <button class="ms-5 cancelBtn btn btn-danger" type="button">cancel</button>
            </div>

        </div>
    </form>
    <!-- end === add data === -->

</div>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-sean-script.php';
include './parts/html-footer.php';
?>