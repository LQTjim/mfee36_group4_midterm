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
                        <form class="needs-validation login-form" novalidate="" name="login">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="email">E-mail</label>
                                <input id="email" type="text" class="login-input form-control" name="email" value="" autofocus autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="password">密碼</label>
                                <input id="password" type="password" class="login-input form-control" name="password" autocomplete="off">
                            </div>
                            <div class="mb-3">

                                <label class="mb-2 text-muted" for="password">驗證碼</label>
                                <div class="d-flex align-items-center captcha-container mb-3">
                                    <div class="captcha text-center text-muted  rounded px-4"></div>
                                    <i class="fa-solid fa-repeat ms-auto captcha-btn"></i>
                                </div>
                                <input id="captcha" type="text" class="login-input form-control" autocomplete="off">
                            </div>
                            <div class="mb-3" data-error></div>
                            <div class=" d-flex align-items-center justify-content-center">
                                <button type="button" data-login-btn class="btn btn-primary w-50">
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
    (function() {
        const loginBtn = document.querySelector("[data-login-btn]")
        const inputs = document.querySelectorAll('.login-input');
        const errorDiv = document.querySelector('[data-error]');
        const captchaBtn = document.querySelector('.captcha-btn');
        const captchaInput = document.querySelector('#captcha');
        let curCaptcha = ""
        //input輸入時解除錯誤訊息的框框
        inputs.forEach((el) => {
            el.addEventListener('input', () => {
                errorDiv.innerHTML = ''
                errorDiv.classList.remove("error-on")
                el.classList.remove("error-on")

            })
        })
        // inputs.forEach((el) => {
        //     el.addEventListener('click', () => {
        //         errorDiv.remove("error-on")
        //         el.classList.remove("error-on")
        //     })
        // })
        //登入後訊息提交
        loginBtn.addEventListener('click', forSubmit)
        async function forSubmit(e) {
            e.preventDefault();
            //如果都沒填東西就什麼都不做
            if (inputs[0].value.trim() === "" || inputs[1].value.trim() === "" || captchaInput.value.trim() === "") {
                errorDiv.innerHTML = '輸入框不得為空'
                errorDiv.classList.add('error-on')
                inputs.forEach((el) => el.classList.add('error-on'))
                return
            }

            if (captchaInput.value !== curCaptcha) {
                errorDiv.innerHTML = '驗證碼錯誤請再試一次'
                errorDiv.classList.add('error-on')
                inputs[2].classList.add('error-on')
                console.log("asdf")
                return
            }
            try {
                const fd = new FormData(document.login)
                const res = await fetch("./api/login-api.php", {
                    method: "POST",
                    body: fd,
                    // Content-Type 可省略, 當傳進去的是FormData 自動辨別為multipart/form-data 
                });
                const obj = await res.json();
                console.log(obj)
                if (obj.success === true) {
                    // 登入成功->顯示登入成功->sleep(1秒)->跳轉
                    Swal.fire({
                        text: '登入成功',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    setTimeout(() => {
                        location.href = "index.php"
                    }, 1000)
                } else {
                    // console.log(obj.error[0])
                    //登入失敗->顯示可自己按關閉的提示訊息 ->確認後回到PANEL


                    errorDiv.innerHTML = `${obj.error[0]}`
                    errorDiv.classList.add('error-on')
                    inputs.forEach((el, i) => {
                        if (i !== 2) {
                            el.classList.add('error-on')
                        }
                    })
                }
            } catch (err) {
                console.log(err)
            }
        }
        captchaBtn.addEventListener('click', () => {
            generateCaptcha()

        })

        function generateCaptcha() {
            let allChars = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z']
            captcha = document.querySelector('.captcha')
            captcha.innerHTML = ""
            curCaptcha = ""
            for (let i = 0; i < 5; i++) {
                const randChar = allChars[Math.floor(Math.random() * allChars.length)]
                curCaptcha += randChar
                captcha.innerHTML += `<span style="transform:rotate(${-20+Math.trunc(Math.random()*30)}deg);">${randChar}</span>`
            }
        }
        generateCaptcha()
    })()
</script>
<?php include './parts/html-footer.php' ?>