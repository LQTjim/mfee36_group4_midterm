<?php
$pageName = 'add';
$title = 'add'
?>
<?php include "./parts/db-connect.php"; ?>

<?php
$sql = "SELECT `sid`, `product_type` FROM `order_product_type`";
$data = $pdo->query($sql)->fetchAll();
?>
<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">新增資料</h5>
                <form name="formadd" onsubmit="checkForm(event)">
                    <div class="mb-3">
                        <label for="member_sid" class="form-label">會員編號</label>
                        <input type="text" class="form-control member_sid" id="member_sid" name="member_sid" value="">
                        <div class="form-text"></div>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text " for="inputGroupSelect01">產品類型</label>
                        <select name="products_type_sid" id="products_type_sid" class="products_type_sid">
                            <option value="0" selected>--請選擇--</option>
                            <?php foreach ($data as $d) : ?>
                                <option value="<?= $d['sid'] ?>"><?= $d['product_type'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="item_sid" class="form-label">產品編號</label>
                        <input type="text" class="form-control item_sid" id="item_sid" name="item_sid">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">單價</label>
                        <input type="text" class="form-control price" id="price" name="price">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">數量</label>
                        <input type="text" class="form-control quantity" id="quantity" name="quantity">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">小計</label>
                        <input type="text" class="form-control amount" id="amount" name="amount">
                        <div class="form-text"></div>
                    </div>
                    <button type="submit" class="btn btn-primary back">新增</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // 前端欄位驗證
    const checkms = document.querySelector('.member_sid')
    const products_type_sid = document.querySelector('.products_type_sid')
    const item_sid = document.querySelector('.item_sid')
    const quantity = document.querySelector('.quantity')

    function checkForm(event) {
        event.preventDefault();
        let isPass = true;
        if (quantity.value.length < 1) {
            isPass = false
            Swal.fire({
                text: "請輸入數量",
                icon: "error",
                showCancelButton: false,
                showConfirmButton: false,
            });
        }
        if (item_sid.value.length < 1) {
            isPass = false
            Swal.fire({
                text: "請輸入產品編號",
                icon: "error",
                showCancelButton: false,
                showConfirmButton: false,
            });
        }

        if (products_type_sid.value < 1) {
            isPass = false
            Swal.fire({
                text: "請選擇商品類型",
                icon: "error",
                showCancelButton: false,
                showConfirmButton: false,
            });
        }

        if (checkms.value.length < 1) {
            isPass = false;
            Swal.fire({
                text: "請輸入會員編號",
                icon: "error",
                showCancelButton: false,
                showConfirmButton: false,
            });
        }


        // 驗證通過後取資料
        const fd = new FormData(document.formadd);
        if (isPass) {
            fetch('./api/order_cart_add_api.php', {
                    method: "POST",
                    body: fd,
                }).then(r => r.text())
                .then(obj => {
                    console.log(obj);
                    Swal.fire({
                        text: "新增成功",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: false,
                    });
                    setTimeout(() => {
                        window.location.replace('order_cart.php')
                    }, 2000)
                })
                .catch(ex => {
                    console.log(ex)
                })
        }
    }
</script>
<?php include "./parts/html-footer.php"; ?>