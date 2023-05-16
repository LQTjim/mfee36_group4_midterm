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
        <div class="p-2 col-6">
            <div class="border border-secondary rounded p-5 ">
                <div class="fs-3">新增使用者 1</div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email[]" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="text" name="password[]" class="form-control" id="password" placeholder="請輸入密碼">
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">電話</label>
                    <input type="text" name="mobile[]" class="form-control" id="mobile" placeholder="請輸入電話">
                </div>
                <div class="mb-3">
                    <label for="birth" class="form-label">生日</label>
                    <input type="date" name="birth[]" class="form-control" id="birth">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">地址</label>
                    <input type="text" name="address[]" class="form-control" id="address" placeholder="請輸入地址">
                </div>
                <div class="mb-3">
                    <label for="sex" class="form-label">性別</label>
                    <select name="sex[]" id="sex">
                        <option value="0">男</option>
                        <option value="1">女</option>
                        <option value="2">不透漏</option>
                        <option value="">無</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">會員等級</label>
                    <select name="level[]" id="level">
                        <option value="1" selected>銅牌會員</option>
                        <option value="2">銀牌會員</option>
                        <option value="3">金牌會員</option>
                        <option value="4">白金會員</option>
                        <option value="5">鑽石會員</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">會員權限</label>
                    <select name="level[]" id="role">
                        <option value="1" selected>用戶</option>
                        <option value="2">教練</option>
                        <option value="3">管理員</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hero_icon" class="form-label">會員頭像</label>
                    <input type="file" name="hero_icon[]" id="hero_icon" />
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
                </div>
                <div class="mb-3">
                    <label for="password${additionForm+1}" class="form-label">密碼</label>
                    <input type="text" name="password[]" class="form-control" id="password${additionForm+1}" placeholder="請輸入密碼">
                </div>
                <div class="mb-3">
                    <label for="mobile${additionForm+1}" class="form-label">電話</label>
                    <input type="text" name="mobile[]" class="form-control" id="mobile${additionForm+1}" placeholder="請輸入電話">
                </div>
                <div class="mb-3">
                    <label for="birth${additionForm+1}" class="form-label">生日</label>
                    <input type="date" name="birth[]" class="form-control" id="birth${additionForm+1}">
                </div>
                <div class="mb-3">
                    <label for="address${additionForm+1}" class="form-label">地址</label>
                    <input type="text" name="address[]" class="form-control" id="address${additionForm+1}" placeholder="請輸入地址">
                </div>
                <div class="mb-3">
                    <label for="sex${additionForm+1}" class="form-label">性別</label>
                    <select name="sex[]" id="sex${additionForm+1}">
                        <option value="0">男</option>
                        <option value="1">女</option>
                        <option value="2">不透漏</option>
                        <option value="">無</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="level${additionForm+1}" class="form-label">會員等級</label>
                    <select name="level[]" id="level${additionForm+1}">
                        <option value="1" selected>銅牌會員</option>
                        <option value="2">銀牌會員</option>
                        <option value="3">金牌會員</option>
                        <option value="4">白金會員</option>
                        <option value="5">鑽石會員</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="role${additionForm+1}" class="form-label">會員權限</label>
                    <select name="role[]" id="role${additionForm+1}">
                        <option value="1" selected>用戶</option>
                        <option value="2">教練</option>
                        <option value="3">管理員</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hero_icon${additionForm+1}" class="form-label">會員頭像</label>
                    <input type="file" name="hero_icon[]" id="hero_icon${additionForm+1}" />
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
    })()
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>