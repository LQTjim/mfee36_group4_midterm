<?php
require './parts/admin-required.php';
$title = '編輯';
require './parts/db-connect.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$sql = "SELECT * FROM product_name WHERE sid= {$sid}";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: product_list.php');
    exit;
}




?>
<?php include './parts/html-head.php' ?>
<?php include './parts/html-navbar.php' ?>
<style>
    form .mb-3 .form-text {
        color: red;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">編輯資料</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="name" name="name" data-required="1" value="<?= htmlentities($r['product_name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">商品描述</label>
                            <textarea class="form-control" id="description" name="description" data-required="1"><?= $r['description'] ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">編輯</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include './parts/html-scripts.php' ?>
<script>
    const nameField = document.querySelector('#name');
    const infoBar = document.querySelector('#infoBar');
    // 取得必填欄位
    const fields = document.querySelector('form1');

    function checkForm(event) {
        event.preventDefault();

        // for (let f of fields) {
        //     f.style.border = '1px solid #ccc';
        //     f.nextElementSibling.innerHTML = ''
        // }
        // nameField.style.border = '1px solid #CCC';
        // nameField.nextElementSibling.innerHTML = ''
        let isPass = true; // 預設值是通過的

        // TODO: 檢查欄位資料

        /*
        // 檢查必填欄位
        for(let f of fields){
            if(! f.value){
                isPass = false;
                f.style.border = '1px solid red';
                f.nextElementSibling.innerHTML = '請填入資料'
            }
        }
        */


        if (isPass) {
            const fd = new FormData(document.form1); // 沒有外觀的表單
            const usp = new URLSearchParams(fd); // 可以轉換為 urlencoded 格式
            // console.log(usp.toString());

            fd.append("sid", <?= $sid ?>);
            // for (var pair of fd.entries()) {
            //     console.log(pair[0] + ', ' + pair[1]);
            // }

            fetch('./api/product_edit-api.php', {

                    method: 'POST',
                    body: fd, // Content-Type 省略, multipart/form-data
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {

                        infoBar.classList.remove('alert-danger')
                        infoBar.classList.add('alert-success')
                        infoBar.innerHTML = '編輯成功'
                        infoBar.style.display = 'block';

                    } else {
                        infoBar.classList.remove('alert-success')
                        infoBar.classList.add('alert-danger')
                        infoBar.innerHTML = '資料沒有編輯'
                        infoBar.style.display = 'block';
                    }
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                        window.location.replace('product_list.php');
                    }, 2000);
                })
                .catch(ex => {
                    console.log(ex);
                    infoBar.classList.remove('alert-success')
                    infoBar.classList.add('alert-danger')
                    infoBar.innerHTML = '編輯發生錯誤'
                    infoBar.style.display = 'block';
                    setTimeout(() => {
                        infoBar.style.display = 'none';
                    }, 2000);
                })

        } else {
            // 沒通過檢查
        }


    }
</script>
<?php include './parts/html-navbar-end.php' ?>
<?php include './parts/html-footer.php' ?>