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
// if (COUNT($r) == 0) {
//     header('Location: index.php');
//     exit;
// }
?>
<link rel="stylesheet" href="./css/member.css">
<div class="w-100 d-flex justify-content-center align-items-center">
    <form class=" row w-100" name="update-member">

        <div class="border border-secondary rounded p-5 col">
            <div class="fs-3">修改會員</div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="email" value="<?= $r['email'] ?>">
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
                <input type="text" name="address" class="form-control" id="address" value="<?= $r['address'] ?>">
            </div>
            <div class="mb-3">
                <label for="sex" class="form-label">性別</label>
                <select class="form-select" name="sex" id="sex">
                    <option value="1" <?= $r['sex'] == 1 ? 'selected' : "" ?>>男</option>
                    <option value="2" <?= $r['sex'] == 2 ? 'selected' : "" ?>>女</option>
                    <option value="3" <?= $r['sex'] == 3 ? 'selected' : "" ?>>不透漏</option>
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
                <label for="hero_icon" class="form-label">會員頭像</label>
                <input type="file" name="hero_icon" id="hero_icon" />
            </div>
        </div>
        <button type="button" class="btn btn-info text-secondary mt-2" id="updateBtn">確認送出</button>
    </form>
</div>
<script>
    (function() {
        const form = document.querySelector('form');
        const updateBtn = document.querySelector('#updateBtn');
        updateBtn.addEventListener('click', () => {
            const fd = new FormData(form)
            fd.append('sid', <?= $_GET['sid'] ?>)
            fetch('./api/member-list-update-api.php', {
                method: "POST",
                body: fd
            }).then((r) => r.json()).then((d) => console.log(d)).catch((err) => {
                console.log(err)
            })
            for (var pair of fd.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
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