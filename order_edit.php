<?php include "./parts/db-connect.php"; ?>

<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <form>
            <div class="mb-3">
                <label for="" class="form-label">會員姓名(name)</label>
                <input type="text" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">產品類型</label>
                <input type="text" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">數量</label>
                <input type="text" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">數量</label>
                <input type="text" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">小計(NTD)</label>
                <input type="text" class="form-control" id="">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="text" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <input type="text" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<?php include "./parts/html-footer.php"; ?>