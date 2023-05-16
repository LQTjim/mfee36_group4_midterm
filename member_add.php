<?php
$pageName = 'member';
$subPageName = 'member_add';
$title = '新增會員';
include './parts/db-connect.php';
include './parts/html-head.php';
include './parts/html-navbar.php';
?>
<link rel="stylesheet" href="./css/member.css">
<div>
    <a href="index.php">首頁</a>
    >>
    <a href="javascript: return;">新增會員</a>
</div>
<div class="w-100 d-flex justify-content-center align-items-center">
    <form class=" row w-100" name="add-member">
        <div class="col-12 "><button type="button" class="btn btn-primary w-100" id="addBtn">確認新增</button></div>
        <div class="p-2 col-6">
            <div class="border border-secondary rounded p-5 ">
                <div class="fs-3">新增使用者</div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email[]" class="form-control" id="email" placeholder="name@example.com">
                    <div class="error-div"></div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">姓名</label>
                    <input type="text" name="name[]" class="form-control" id="name" placeholder="請輸入姓名">
                    <div class="error-div"></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="text" name="password[]" class="form-control" id="password" placeholder="請輸入密碼">
                    <div class="error-div"></div>
                </div>
            </div>
        </div>
        <div class="p-2 col-6 align-self-stretch add-form-btn" data-add-form>
            <div class="border border-secondary rounded p-5 h-100 d-flex justify-content-center align-items-center">
                <i class="fa-solid fa-plus"></i>
            </div>
        </div>

    </form>
</div>
<script>
    (function() {
        let additionForm = 1;
        const form = document.querySelector('form')
        const addBtn = document.querySelector('#addBtn')
        addFormBtn = document.querySelector("[data-add-form]");
        addFormBtn.addEventListener('click', () => {
            if (form.children.length === 4) {
                addFormBtn.classList.add('d-none')
            }
            if (form.children.length <= 5) {
                const newForm = document.createElement("div");
                newForm.setAttribute("class", "p-2 col-6");
                newForm.innerHTML = `<div class="border border-secondary rounded p-5 ">
                <div class="d-flex justify-content-between"><span class="fs-3">新增使用者</span><button type="button" class="btn btn-danger delete-col">刪除此欄位</button></div>
                <div class="mb-3">
                    <label for="email${additionForm+1}" class="form-label">Email</label>
                    <input type="text" name="email[]" class="form-control" id="email${additionForm+1}" placeholder="name@example.com">
                    <div class="error-div"></div>
                </div>
                <div class="mb-3">
                    <label for="name${additionForm+1}" class="form-label">姓名</label>
                    <input type="text" name="name[]" class="form-control" id="name${additionForm+1}" placeholder="請輸入姓名">
                    <div class="error-div"></div>
                </div>
                <div class="mb-3">
                    <label for="password${additionForm+1}" class="form-label">密碼</label>
                    <input type="text" name="password[]" class="form-control" id="password${additionForm+1}" placeholder="請輸入密碼">
                    <div class="error-div"></div>
                </div>
                
                
            </div>`
                form.insertBefore(newForm, form.children[form.children.length - 1])
                additionForm++;
            }

        });
        form.addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-col')) {
                console.log(form.children.length)
                e.target.closest(".p-2.col-6").remove();
                if (form.children.length === 4) {
                    addFormBtn.classList.remove('d-none')
                }
            }
        })
        addBtn.addEventListener("click", () => {
            let validation
            document.querySelectorAll('input').forEach((el) => {
                if (el.value.trim() === "") {
                    validation = false
                    el.nextElementSibling.classList.add('error');
                    el.nextElementSibling.innerText = "不得為空"

                }
            })
            if (validation) {
                const fd = new FormData(form)
                for (var pair of fd.entries()) {
                    console.log(pair[0] + ', ' + pair[1]);
                }
                fetch('./api/member-add-api.php', {
                        method: 'POST',
                        body: fd
                    }).then((r) => r.json())
                    .then((d) => {
                        if (d.success === true) {
                            // 登入成功->顯示登入成功->sleep(1秒)->跳轉
                            Swal.fire({
                                text: '新增成功',
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                            setTimeout(() => {
                                location.href = "member_add.php"
                            }, 1000)
                        }
                    }).catch((err) => {
                        Swal.fire({
                            text: '新增失敗',
                            icon: 'danger',
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    })
            }

        })
    })()
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>