<?php
$pageName = 'member';
$title = '修改會員';
if (!isset($_GET['sid'])) {
    header('Location: index.php');
    exit;
}
include './parts/db-connect.php';
include './parts/html-head.php';
include './parts/html-navbar.php';
$sql = "SELECT 
m.`sid`,
m.`email`,
m.`password`,
m.`name`,
m.`mobile`,
m.`birth`,
m.`address`,
m.sex_sid AS `sex`,
m.`member_level_sid` AS `level`,
m.`hero_icon`,
m.`role_sid` AS `role` ,
m.`active`
FROM
`member` m
WHERE m.`sid` =?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['sid']]);

$r = $stmt->rowCount();
if ($r == 0) {
    header('Location: index.php');
    exit;
}
$r = $stmt->fetch();
?>
<link rel="stylesheet" href="./css/member.css">
<div class="w-100 d-flex justify-content-center align-items-center">
    <form name="form1" style="display: none">
        <input type="file" name="hero_icon" id="avatar" accept="image/jpeg">
    </form>
    <form class=" row w-100" name="update-member">

        <div class="border border-secondary rounded p-5 col">
            <div class="fs-3">修改會員</div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input disabled type="text" class="form-control" id="email" value="<?= $r['email'] ?>">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">姓名</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= $r['name'] ?>">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">電話</label>
                <input type="text" name="mobile" class="form-control" id="mobile" value="<?= $r['mobile'] ?>">
            </div>
            <div class="mb-3">
                <label for="birth" class="form-label">生日</label>
                <input type="date" name="birth" class="form-control" id="birth" value="<?= $r['birth'] ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">地址</label>
                <select class="form-select d-inline" style="width:auto;" id="cityName"></select>
                <select class="form-select d-inline" style="width:auto;" id="areaName">
                    <option>請選擇</option>
                </select>
                <select class="form-select d-inline" style="width:auto;" id="roadName">
                    <option>請選擇</option>
                </select>
                <input type="text" name="address" class="form-control mt-2" id="address" value="<?= $r['address'] ?>">
            </div>
            <div class="mb-3">
                <label for="sex" class="form-label">性別</label>
                <select class="form-select" name="sex" id="sex">
                    <option value="1" <?= $r['sex'] == 1 ? 'selected' : "" ?>>男</option>
                    <option value="2" <?= $r['sex'] == 2 ? 'selected' : "" ?>>女</option>
                    <option value="3" <?= $r['sex'] == 3 ? 'selected' : "" ?>>不透露</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">會員等級</label>
                <select class="form-select" name="level" id="level">
                    <option value="1" <?= $r['level'] == 1 ? 'selected' : "" ?>>銅牌會員</option>
                    <option value="2" <?= $r['level'] == 2 ? 'selected' : "" ?>>銀牌會員</option>
                    <option value="3" <?= $r['level'] == 3 ? 'selected' : "" ?>>金牌會員</option>
                    <option value="4" <?= $r['level'] == 4 ? 'selected' : "" ?>>白金會員</option>
                    <option value="5" <?= $r['level'] == 5 ? 'selected' : "" ?>>鑽石會員</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">會員權限</label>
                <select class="form-select" name="role" id="role">
                    <option value="1" <?= $r['role'] == 1 ? 'selected' : "" ?>>用戶</option>
                    <option value="2" <?= $r['role'] == 2 ? 'selected' : "" ?>>教練</option>
                    <option value="3" <?= $r['role'] == 3 ? 'selected' : "" ?>>管理員</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="active" class="form-label">啟用狀態</label>
                <select class="form-select" name="active" id="active">
                    <option value="0" <?= $r['active'] == 0 ? 'selected' : "" ?>>未啟用</option>
                    <option value="1" <?= $r['active'] == 1 ? 'selected' : "" ?>>已啟用</option>
                </select>
            </div>
            <img class="member-update-img" src="<?= $r['hero_icon'] ?>" alt="">
            <button type="button" class="btn btn-primary" onclick="selectFile()">上傳圖片</button>
        </div>
        <button type="button" class="btn btn-info text-secondary mt-2" id="updateBtn">確認送出</button>
    </form>
</div>
<script src="js/address.js"></script>
<script>
    const inp_avatar = document.querySelector('#avatar');
    inp_avatar.addEventListener('change', function(event) {
        event.preventDefault();
        const fd = new FormData(document.form1);
        fd.append('sid', <?= $_GET['sid'] ?>)
        fetch('./api/member-list-update-icon-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json())
            .then(obj => {
                if (obj.filename) {
                    document.querySelector('.member-update-img').src = './imgs/member_imgs/' + obj.filename;
                }
            })
            .catch(ex => {
                console.log(ex);
            })
    });

    function selectFile() {
        inp_avatar.click();
    }
    (function() {
        const cityName = document.querySelector('#cityName');
        const areaName = document.querySelector('#areaName');
        const roadName = document.querySelector('#roadName');
        const form = document.querySelector('form[name=update-member]');
        const updateBtn = document.querySelector('#updateBtn');
        addressData.forEach((el) => {
            cityName.innerHTML += `<option class="city-name">${el.CityName}</option>`
        })
        cityName.addEventListener('change', (e) => {
            areaName.innerHTML = "";
            const city = addressData.filter((el) => el.CityName === e.target.value)[0];
            city.AreaList.forEach((el) => {
                areaName.innerHTML += `<option class="city-name">${el.AreaName}</option>`
            });
        })
        areaName.addEventListener('change', (e) => {
            roadName.innerHTML = ""
            const city = addressData.filter((el) => el.CityName === cityName.value)[0];
            (city.AreaList.filter((el) => el.AreaName === e.target.value)[0]).RoadList.forEach((el) => {
                roadName.innerHTML += `<option class="city-name">${el.RoadName}</option>`
            })
            document.querySelector("#address").value = ""
            document.querySelector("#address").value = `${cityName.value}${areaName.value}${roadName.value}`
        });
        roadName.addEventListener('change', () => {
            document.querySelector("#address").value = ""
            document.querySelector("#address").value = `${cityName.value}${areaName.value}${roadName.value}`
        })
        updateBtn.addEventListener('click', () => {
            const fd = new FormData(form)
            fd.append('sid', <?= $_GET['sid'] ?>)
            for (var pair of fd.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }
            fetch('./api/member-list-update-api.php', {
                method: "POST",
                body: fd
            }).then((r) => r.json()).then(async (d) => {
                console.log(d);
                await Swal.fire({
                    text: '修改成功',
                    icon: 'success',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                })
                location.reload();
            }).catch((err) => {
                console.log(err)
                Swal.fire({
                    text: '修改失敗，請聯絡工程師',
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false
                })
            })
        })
    })()
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>