<?php
include './parts/admin-required.php';
include './parts/db-connect.php';
$pageName = 'product_add';
$title = '新增商品';
include './parts/html-head.php';
include './parts/html-navbar.php'; ?>
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
                    <h5 class="card-title">新增商品</h5>
                    <form name="form1" onsubmit="checkForm(event)">
                        <div class="mb-3">
                            <label for="name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="name" name="name" data-required="1">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">商品描述</label>
                            <textarea class="form-control" id="address" name="address" data-required="1"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="alert alert-danger" role="alert" id="infoBar" style="display:none"></div>

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include './parts/html-navbar-end.php';
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>a