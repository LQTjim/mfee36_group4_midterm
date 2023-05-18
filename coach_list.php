<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<link rel="stylesheet" href="./css/coach.css">

<?php

    $sql_all = "SELECT *, coach.sid, coach.created_at FROM `c_l_coach` AS coach 
             JOIN `member` AS member WHERE coach.member_sid = member.sid"
    ;

    $stmt_all = $pdo->query($sql_all) ;
    $rows_all = $stmt_all->fetchAll() ;

    $u_id = isset($_GET['id']) ? $_GET['id'] : '' ;

    $u_sql = isset($_GET['id']) ? 
        "SELECT *, coach.sid, coach.created_at FROM `c_l_coach` AS coach 
         JOIN `member` AS member ON coach.member_sid = member.sid
         WHERE coach.sid = {$_GET['id']}" : $sql_all
    ;
    
    $u_stmt = $pdo->query($u_sql) ;
    $rows = $u_stmt->fetchAll() ;

?>

<div class="c_li_container container">
    <div class="d-flex justify-content-between mb-3">
        <select class="form-select" style="width: 5rem;" onchange="
            window.location.replace(`coach_list.php${this.value ? '?id=' : '' }${this.value}`);
        ">
            <option value="" <?= $u_id ? '' : 'selected' ?>>All</option>
            <?php foreach($rows_all as $row): ?>
                <option value="<?= $row['sid'] ?>" <?= $u_id == $row['sid'] ? 'selected' : '' ?> ><?= $row['sid'] ?></option>
            <?php endforeach ; ?>
        </select>
        <button class="btn btn-primary" type="button" onclick="window.location='coach_add.php'">新增教練</button>
    </div>
    <?php foreach($rows as $row): ?>
    <div class="card mb-3">
        <div class="row g-0 h-100">
            <div class="col-lg-2 col-md-3 col-sm-4 img-box">
                <img src="<?= $row['photo'] ?>" class="img-fluid rounded" alt="coach img">
                <i class="fa-solid fa-pen-to-square edit-img" onclick="document.getElementById('photo_<?= $row['sid'] ?>').click()"></i>
                <input type="file" accept="image/png, image/jpeg, image/webp" id="photo_<?= $row['sid'] ?>" onchange="Edit({
                    'sid': <?= $row['sid'] ?>,
                    'type': 'photo',
                    'data': this.files[0]
                })" hidden>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8">
                <div class="card-body py-0">
                    <span class="edit_field lh-lg mb-1 fw-bold d-flex justify-content-start">
                        <span class="me-3">
                            <label for="" class="me-1 fw-bold">教練編號:</label>
                            <span class=""><?= $row['sid'] ?></span>
                        </span>
                        <span class="me-3">
                            <label for="" class="me-1 fw-bold">會員編號:</label>
                            <span class=""><?= $row['member_sid'] ?></span>
                        </span>
                        <span class="ms-auto">
                            <label for="" class="me-1 fw-bold">加入時間:</label>
                            <button class="edit_button" type="button" style="position:relative"
                            onclick="
                                const dateInput = this.querySelector('input');
                                dateInput.showPicker();
                            ">
                                <?php $create_time = explode(' ',$row['created_at'])[0] ?>
                                <span><?= explode(' ',$row['created_at'])[0] ?></span>
                                <i class="fa-solid fa-pen-to-square ms-2"></i>
                                <input type="date" style="visibility: hidden; position: absolute; left: -5rem;"
                                onchange="Edit({  
                                    'sid': <?= $row['sid'] ?>,
                                    'type': 'date',
                                    'data': this.value
                                })">
                            </button>
                        </span>
                    </span>
                    <div class="coach_name_field">
                        <?php 
                            $list = ['name','nickname'] ;
                            foreach($list as $label) :
                        ?>
                        <span class="edit_field me-3">
                            <label for="" class="me-1 fw-bold">
                                <?= $label == 'name' ? '姓名' : '暱稱' ?>:
                            </label>
                            <button class="edit_button position-relative align-middle" type="button" onclick="
                                const inputEl = this.querySelector('input');
                                const spanEl = this.querySelector('span');
                                inputEl.classList.remove('hide');
                                inputEl.focus();
                                inputEl.value = spanEl.textContent;
                                inputEl.addEventListener('blur', () => {
                                    inputEl.classList.add('hide');
                                    inputEl.value = '';
                                }, {'once': true});
                            ">
                                <span class="d-inline-block hide_text" style="width: 6rem;  line-height: 1.2"><?= $row[$label] ?></span>
                                <input class="name_input hide" type="text" onkeyup="
                                    if(event.which !== 13) return; 
                                    Edit({  'sid': <?= $row['sid'] ?>,
                                            'type': '<?= $label ?>',
                                            'data': this.value
                                    });
                                    this.blur();
                                ">
                                <i class="fa-solid fa-pen-to-square ms-1"></i>
                            </button>
                        </span>
                        <?php endforeach ; ?>
                    </div>
                    <?php 
                        $list = ['experience','introduction'] ;
                        foreach($list as $label) :
                    ?>
                    <div class="row edit_field align-middle">
                        <div class="col-1 lh-lg mb-1 fw-bold pe-0">
                            <?= $label == 'experience' ? '經歷' : '介紹' ?>:
                        </div>
                        <input id="<?= $label ?>_<?= $row[$label] ?>" class="col-10 hide_text lh-base align-self-center border border-0" type="text" value="<?= $row[$label] ?>" onkeyup="
                            if(event.which !== 13) return; 
                            Edit({  'sid': <?= $row['sid'] ?>,
                                    'type': '<?= $label ?>',
                                    'data': this.value
                            });
                            this.blur();
                        ">
                        <div class="col-1 text-end"><i class="fa-solid fa-pen-to-square ms-1" style="cursor: pointer" onclick="document.getElementById('<?= $label ?>_<?= $row[$label] ?>').focus()"></i></div>
                    </div>
                    <?php endforeach ; ?>
                    <div class="edit_field lh-lg d-flex mt-1 align-items-center">
                        <button class="me-2 btn btn-primary" type="button" onclick="OpenCertiModal(<?= $row['sid'] ?>)">編輯證照
                            <i class="fa-solid fa-pen-to-square ms-1"></i>
                        </button>
                        <button class="me-2 btn btn-secondary" type="button">課程列表
                            <i class="fa-solid fa-pen-to-square ms-1"></i>
                        </button>
                        <button class="ms-auto btn btn-dark" type="button">
                            <span>刪除教練</span>
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ; ?>
</div>

<dialog id="certi_modal">
    <label class="fw-bold" >證照列表 ( 點擊登錄 )</label>
    <div class="modal_monitor mb-2"></div>
    <label class="fw-bold" >已登錄證照 ( 點擊移除 )</label>
    <div class="modal_body mb-3"></div>
    <div class="text-center">
        <button class="btn btn-primary me-2" onclick="
            const [...items] = document.querySelector('.modal_body').querySelectorAll('.modal_item');
            const data = items.map(item => parseInt(item.dataset.cid));
            let sid = document.getElementById('certi_modal').dataset.sid;
            // return console.log({'sid': parseInt(sid),'type': 'certification','data': data});
            Edit({  'sid': parseInt(sid),
                    'type': 'certification',
                    'data': data
            });
            CloseCertiModal();
        ">修改</button>
        <button class="btn btn-secondary" onclick="CloseCertiModal()">取消</button>
    </div>
</dialog>

<dialog id="newcoach_modal">
    <div class="text-center">
        <button class="btn btn-primary me-2" onclick="">新增</button>
        <button class="btn btn-secondary" onclick="CloseCertiModal()">取消</button>
    </div>
</dialog>

<script>

    const LoadingModal = Swal.mixin({
        titleText: '請稍候...',
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            loader: 'c_l_spinner'
        },
        willOpen: () => Swal.showLoading()
    })

    async function Edit(obj) {

        LoadingModal.fire()

        const formdata = new FormData()

        for(let key in obj) {
            formdata.append(key, obj[key])
        }

        try {

            const response = await fetch("./api/c_l_handle_edit.php", {
                method: "POST",
                body: formdata,
            })

            const data = await response.json()

            Swal.fire({
                titleText: data.success ? '編輯成功' : '資料未修改',
                icon: data.success ? 'success' : 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                customClass: {
                    timerProgressBar: 'c_l_progressBar'
                },
                didClose: () => {
                    data.success && window.location.reload()
                }
            })
        } catch (err) {
            console.log(err)
        }
    }

    async function OpenCertiModal(sid) {

        LoadingModal.fire()

        let modal = document.getElementById('certi_modal')
        modal.setAttribute('data-sid', sid)

        const response = await fetch(`./api/c_l_get_certifications.php?id=${sid}`, {
            method: "GET",
        })

        const items = await response.json()

        LoadingModal.close()

        let moni_frag = document.createDocumentFragment()
        let body_frag = document.createDocumentFragment()
        let monitor = document.querySelector('.modal_monitor')
        let modalBody = document.querySelector('.modal_body')

        for (let item of items['all']) {
            let div = document.createElement('div')
            div.classList.add('modal_item')
            div.textContent = item['name']
            div.setAttribute('data-cid', item['sid'])
            div.addEventListener('click', () => {
                detectOwn(div)
            })
            moni_frag.appendChild(div)
        }
        monitor.appendChild(moni_frag)

        for (let item of items['data']) {
            let div = document.createElement('div')
            div.classList.add('modal_item')
            div.textContent = item['name']
            div.setAttribute('data-cid', item['certification_sid'])
            div.setAttribute('data-own', '')
            div.addEventListener('click', () => {
                detectOwn(div)
            })
            body_frag.appendChild(div)
        }
        modalBody.appendChild(body_frag)

        modal.showModal()

        function detectOwn(element) {
            if ('own' in element.dataset) {
                delete element.dataset.own 
                monitor.appendChild(element)
                return
            } 
            element.setAttribute('data-own', '')
            modalBody.appendChild(element)
        }

        // console.log(data)
    }

    function CloseCertiModal() {
        let parents = [
                document.querySelector('.modal_body'),
                document.querySelector('.modal_monitor')
            ];

        for(let parent of parents ) {
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        }
        
        let certi_modal = document.getElementById('certi_modal');
        certi_modal.removeAttribute('data-sid');
        certi_modal.close();
    }

</script>

<?php
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>