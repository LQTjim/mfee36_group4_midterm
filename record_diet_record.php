<?php
$pageName = 'record';
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php';

$perPage = 5;
$pagePerSide = 4; //pages pers side on the pagniation
$title = 'record_diet_record';
$data = 'record_diet_record';
$addApi = './api/record-diet-add-api.php';
?>
<link rel="stylesheet" href="./css/sean.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // if no specify page, then go to first page

if ($page < 1) {
    header('Location: ?page=1');
    exit; // finish "this php after redirect"
}

// $tot_sql = "SELECT COUNT(1) FROM $data";
$tot_sql = "SELECT COUNT(1)
FROM $data db
JOIN `member` m ON db.member_sid = m.sid AND m.active='1'";
$tot_row =  $pdo->query($tot_sql)->fetch(PDO::FETCH_NUM)[0]; // total number of data
$totPages = ceil($tot_row / $perPage);
// echo $tot_row;
// exit;


$rows = [];
if ($tot_row) {
    if ($page > $totPages) {
        header("Location: ?page=$totPages"); // if page > total pages, then go to last page
        exit;
    }

    // $sql = sprintf("SELECT * FROM address_book LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
    $sql = sprintf(
        "SELECT dr.sid, m.name, ft.sid AS ftSid, ft.food_type, ft.calories, ft.protein, dr.quantity, dr.diet_time
        FROM `record_diet_record` dr
        JOIN `member` m ON dr.member_sid = m.sid AND m.active='1'
        JOIN `record_food_type` ft ON dr.food_sid = ft.sid
        ORDER BY dr.diet_time DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}
// === bar chart ===

$sql_barChart = sprintf("SELECT dr.food_sid, ft.food_type,
COUNT(dr.food_sid) AS freq
FROM  record_diet_record dr
JOIN record_food_type ft ON dr.food_sid = ft.sid
GROUP BY dr.food_sid
ORDER BY freq DESC
LIMIT 5;
");

$bar_rows = $pdo->query($sql_barChart)->fetchAll();

$fID = [];
$fData = [];

foreach ($bar_rows as $b) {
    // $fID[] = intval($b['member_sid']);
    $fID[] = $b['food_type'];
    $fData[] = intval($b['freq']);
}
// ========================================================
?>

<div class="chartBox">
    <canvas id="bar-chart" class=""></canvas>
</div>

<!-- end barchart =============================================== -->
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
                        <th scope="col">姓名</th>
                        <th scope="col">食物類型</th>
                        <th scope="col">數量</th>
                        <th scope="col">熱量</th>
                        <th scope="col">蛋白質</th>
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
                            <td scope="row">
                                <div><?= $r['sid'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['name'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['food_type'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['quantity'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['quantity'] * $r['calories'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['quantity'] * $r['protein'] ?></div>
                            </td>
                            <td>
                                <div><?= $r['diet_time'] ?></div>
                            </td>
                            <!-- ==================== -->
                            <td class="pe-4">
                                <div class="btnA btn-group">
                                    <a href="./record_diet_record_edit.php?sid=<?= $r['sid'] ?>" class=" btn-edit btn btn-sm btn-outline-dark">
                                        編輯
                                    </a>

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
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <td>
                            <div class="">
                                <label for="memberSid" class="form-label">member ID</label>
                                <input type="text" class="form-control" name="memberSid" id="memberSid" placeholder="999">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="foodSid" class="form-label">food ID</label>
                                <input type="email" class="form-control" name="foodSid" id="foodSid" placeholder="183">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="quantity" class="form-label">數量</label>
                                <input type="text" class="form-control" name="quantity" id="quantity" placeholder="99">
                            </div>
                        </td>
                        <td>
                            <div class="">
                                <label for="record_time" class="form-label">紀錄時間</label>
                                <input type="text" class="form-control" name="record_time" id="record_time" placeholder="2020-01-01">
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
<script>
    const barCtx = document.querySelector("#bar-chart").getContext('2d');
    const barConfig = {
        type: 'bar',
        data: {
            datasets: [{
                data: <?= json_encode($fData) ?>,
                label: '熱門飲食'
            }],
            labels: <?= json_encode($fID) ?>
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, ticks) {
                            return value;
                        }
                    }
                },
                // x: {
                //     ticks: {
                //         // Include a dollar sign in the ticks
                //         callback: function(value, index, ticks) {
                //             return value;
                //         }
                //     }
                // }
            }


        }
    };
    const barChart = new Chart(barCtx, barConfig);
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-sean-script.php';
include './parts/html-footer.php';
?>