<?php
$pageName = 'edit';
$title = 'edit'
?>
<?php include "./parts/db-connect.php"; ?>
<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>
<?php
$sql_sel = "SELECT `sid`, `product_type` FROM `order_product_type`";
$data = $pdo->query($sql_sel)->fetchAll();
?>
<?php
$sid = isset($_GET['sid']) ? ($_GET['sid']) : 0;
$sql = "SELECT * FROM order_cart WHERE sid = {$sid}";
$r = $pdo->query($sql)->fetch();
// echo json_encode($r);
// exit;




if (empty($r)) {
    header('Location: order_cart.php');
    exit;
};
?>

<div class="container">
    <div class="row">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">新增資料</h5>
                <form name="formedit" onsubmit="checkForm(event)">
                    <input type="number" hidden name="sid" value="<?= htmlentities($r['sid']) ?>">
                    <div class="mb-3">
                        <label for="member_sid" class="form-label">會員編號</label>
                        <input type="text" class="form-control member_sid" id="member_sid" name="member_sid" value="<?= htmlentities($r['member_sid']) ?>">
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
                        <input type="text" class="form-control item_sid" id="item_sid" name="item_sid" value="<?= htmlentities($r['item_sid']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">單價</label>
                        <input type="text" class="form-control price" id="price" name="price" value="<?= htmlentities($r['price']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">數量</label>
                        <input type="text" class="form-control quantity" id="quantity" name="quantity" value="<?= htmlentities($r['quantity']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">小計</label>
                        <input type="text" class="form-control amount" id="amount" name="amount" value="<?= htmlentities($r['amount']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <button type="submit" class="btn btn-primary back">編輯</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function checkForm(event) {
        event.preventDefault();
        const fd = new FormData(document.formedit); //純資料
        fetch('./api/order_cart_edit_api.php', {
                method: "post",
                body: fd,
            }).then(r => r.text())
            .then(txt => {
                console.log(txt);
                Swal.fire({
                    text: "編輯成功",
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
</script>
<?php include "./parts/html-footer.php"; ?>