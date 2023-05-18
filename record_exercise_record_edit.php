<?php
include './parts/html-head.php';
include './parts/html-navbar.php';
include './parts/db-connect.php';

$perPage = 5;
$pagePerSide = 4; //pages pers side on the pagniation
$pageName = 'record';
$title = 'record_exercise_record_eidt';
$data = 'record_exercise_record'; // name of the table
$api = "./api/record-exercise-record-edit-api.php"
?>
<link rel="stylesheet" href="./css/sean.css">

<?php

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT * FROM $data WHERE sid={$sid}";

$r = $pdo->query($sql)->fetch();


?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">編輯資料</h5>
                    <form id="editForm" name="editForm" onsubmit="checkForm(event)">
                        <input type="hidden" id="sid" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="memberSid" class="form-label">member ID</label>
                            <input type="text" class="form-control" id="memberSid" name="memberSid" data-required="1" value="<?= htmlentities($r['member_sid']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="exeTypeSid" class="form-label">exercise type ID</label>
                            <input type="text" class="form-control" id="exeTypeSid" name="exeTypeSid" data-required="1" value="<?= htmlentities($r['exe_type_sid']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">重量</label>
                            <input type="text" class="form-control" id="weight" name="weight" value="<?= htmlentities($r['weight']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="sets" class="form-label">組數</label>
                            <input type="text" class="form-control" id="sets" name="sets" value="<?= htmlentities($r['sets']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="reps" class="form-label">次數</label>
                            <input type="text" class="form-control" id="reps" name="reps" value="<?= htmlentities($r['reps']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="exeDate" class="form-label">訓練時間</label>
                            <input type="text" class="form-control" id="exeDate" name="exeDate" value="<?= htmlentities($r['exe_date']) ?>" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <!-- <script>
                            document.querySelector("#recordTime").value = '2000-01-01'
                        </script> -->

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>
                        <div>
                            <button class="ms-3 confirmEditBtn btn btn-success" type="button" onclick="editData(event)" data-edit-api="<?= $api ?>">
                                Submit form
                            </button>
                            <button class="ms-5 me-3 cancelBtn btn btn-danger" type="button">
                                cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- === script =============================================================== -->

<script>
    'use strict'

    // start === edit confirm ===
    const confirmEditDataBtn = document.querySelector(".confirmEditBtn");
    const cancelEditBtn = document.querySelector(".cancelBtn");
    cancelEditBtn.addEventListener('click', () => {
        Swal.fire({
            text: '取消編輯',
            icon: 'warning',
            showCancelButton: false,
            showConfirmButton: false
        })
        setTimeout(() => {
            history.back();
        }, 1500);
    })

    function editData() {
        const editApi = confirmEditDataBtn.dataset['editApi'];
        const fm = document.querySelector("#editForm");
        // console.log(fm['exeDate'].value);
        const fd = new FormData();
        fd.append("sid", fm['sid'].value);
        fd.append("memberSid", fm['memberSid'].value);
        fd.append("exe-type-sid", fm['exeTypeSid'].value);
        fd.append("weight", fm['weight'].value);
        fd.append("reps", fm['reps'].value);
        fd.append("sets", fm['sets'].value);
        fd.append("exe-date", fm['exeDate'].value);

        fetch(editApi, {
            method: 'POST',
            body: fd
        }).then((res) => res.json()).then(
            (data) => {
                if (data.success) {
                    Swal.fire({
                        text: '修改成功',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    setTimeout(() => {
                        history.back();
                    }, 1500)
                } else {
                    Swal.fire({
                        text: '未修改',
                        icon: 'error',
                        showCancelButton: false,
                        showConfirmButton: true
                    })
                }
            }
        ).catch((err) => {
            console.log(err);
            Swal.fire({
                text: '修改失敗，請聯絡工程師',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false
            })
        })



    }

    // end === edit confirm ===
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
// include './parts/html-sean-edit-script.php';
include './parts/html-footer.php';
?>