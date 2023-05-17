<?php
$pageName = 'edit';
$title = 'edit'
?>
<?php include "./parts/db-connect.php"; ?>
<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>
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
                <form name="formadd" onsubmit="checkForm(event)">
                    <div class="mb-3">
                        <label for="member_sid" class="form-label">會員編號</label>
                        <input type="text" class="form-control" id="member_sid" name="member_sid" value="<?= htmlentities($r['member_sid']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="products_type_sid" class="form-label">產品類型</label>
                        <input type="text" class="form-control" id="products_type_sid" name="products_type_sid" value="<?= htmlentities($r['products_type_sid']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="item_sid" class="form-label">產品編號</label>
                        <input type="text" class="form-control" id="item_sid" name="item_sid" value="<?= htmlentities($r['item_sid']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">單價</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= htmlentities($r['price']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">數量</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="<?= htmlentities($r['quantity']) ?>">
                        <div class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">小計</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="<?= htmlentities($r['amount']) ?>">
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
    function checkForm(event) {
        event.preventDefault();
        const fd = new FormData(document.formadd); //純資料

        fetch('./api/order_cart_edit_api.php', {
                method: "post",
                body: fd,
            }).then(r => r.text())
            .then(txt => {
                console.log(txt);
                Swal.fire({
                    text: "新增成功",
                    icon: "success",
                    showCanelButton: false,
                    showConfirmButton: false,
                });
                setTimeout(() => {
                    history.go(-1)
                }, 2000)
                // window.alert('新增成功')
            })
            .catch(ex => {
                console.log(ex)
            })
    }


    // document.querySelector('.back').addEventListener('click', function() {
    //     window.alert('新增成功')
    //     // location.href = ' ./order_cart.php?page=1'
    //     history.go(-1)
    // })
</script>
<?php include "./parts/html-footer.php"; ?>