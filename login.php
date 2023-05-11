<?php include './parts/html-head.php' ?>
<?php require './parts/db-connect.php';
if (isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
} #有登入就導回到首頁
?>
<link rel="stylesheet" href="./css/login.css">
<div class="position-fixed top-0 start-0 end-0 bottom-0 login-background"></div>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4 text-center login-title">G4後台登入</h1>
                        <form class="needs-validation login-form" novalidate="" name="login" onsubmit="forSubmit(event)">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-mail</label>
                                <input id="email" type="text" class="login-input form-control" name="email" value="" autofocus autocomplete="off">
                                <div class="invalid-feedback">
                                    Email格式錯誤
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password">密碼</label>
                                <input id="password" type="password" class="login-input form-control" name="password" autocomplete="off">
                                <div class="invalid-feedback">
                                    密碼錯誤
                                </div>
                            </div>

                            <div class=" d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn btn-primary w-50">
                                    登入
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2017-2023 &mdash; Ggoup4 Company
                </div>
            </div>
        </div>
    </div>
</section>
<?php include './parts/html-scripts.php' ?>
<script>
    async function forSubmit(e) {
        e.preventDefault();
        const fd = new FormData(document.login)
        try {
            const res = await fetch("./api/login-api.php", {
                method: "POST",
                body: fd,
                // Content-Type 可省略, 當傳進去的是FormData 自動辨別為multipart/form-data 
            });
            const obj = await res.json();
            console.log(obj);
        } catch (err) {
            console.log(err)
        }
    }
</script>
<?php include './parts/html-footer.php' ?>