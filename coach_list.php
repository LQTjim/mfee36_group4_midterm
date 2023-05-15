<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<style>

    .c_li_container * {
        box-sizing: border-box;
    }

    .c_li_container .card{
        padding: 20px;
        min-width: 200px;
        height: 250px;
    }

    @media (max-width: 767px) {
        .c_li_container .card{
            height: 100%;
        }
    }

    .c_li_container .img-box {
        position: relative;
        height: 100%;
    }

    .c_li_container .img-box img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .c_li_container .edit-img {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 4.5rem;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow: hidden;
        opacity: 0;
        cursor: pointer;
    }
    
    .c_li_container .edit-img:hover {
        opacity: 0.5;
    }

    /* style for Swal below*/

    .c_l_spinner {
        width: 5rem !important;
        height: 5rem !important;
    }

    .c_l_progressBar {
        height: .5rem;
    }

    /* style for Swal above*/

    @media (max-width: 1340px) {
        .c_li_container .coach_name_field {
            flex-direction: column;
        }

        .c_li_container .coach_name_field .edit_field:last-child {
            margin: 0 !important;
        } 
    }

    .c_li_container .coach_name_field {
        display: flex;
        justify-content: start;
    }


    .c_li_container .edit_button {
        all: unset;
        cursor: pointer;
    }

    .c_li_container .edit_field {
        font-size: 1.2rem;
    }

    .c_li_container .name_input {
        position: absolute;
        line-height: 1;
        border-radius: 3px;
        top: 0;
        left: 0;
        width: 6rem;
        transition: width .5s, border-width 0s .5s;
    }
    
    .c_li_container .hide {
        border-width: 0;
        padding: 0;
        width: 0;
    }

    .c_li_container .hide_text {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .c_li_container .long_text:disabled {
        background-color: transparent;
    }

    /* Modal style below*/
    
    dialog {
        border-radius: 8px;
        border: 0;
    }
    
    /* Modal style above*/
</style>

<?php

    $sql = "SELECT *, coach.sid FROM `c_l_coach` AS coach 
            JOIN `member` AS member WHERE coach.member_sid = member.sid"
    ;
    
    $statment = $pdo->query($sql) ;
    $rows = $statment->fetchAll() ;

?>

<pre><?php
    // print_r($rows) ;
    // exit ;
?></pre>

<div class="c_li_container container">
    <?php foreach($rows as $row): ?>
    <div class="card mb-3">
        <div class="row g-0 h-100">
            <div class="col-lg-2 col-md-3 col-sm-4 img-box">
                <img src="<?= $row['photo'] ?>" class="img-fluid rounded" alt="...">
                <i class="fa-solid fa-pen-to-square edit-img" onclick="document.getElementById('photo_<?= $row['sid'] ?>').click()"></i>
                <input type="file" accept="image/png, image/jpeg, image/webp" id="photo_<?= $row['sid'] ?>" onchange="edit({
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
                                <span><?= explode(' ',$row['created_at'])[0] ?></span>
                                <i class="fa-solid fa-pen-to-square ms-2"></i>
                                <input type="date" style="visibility: hidden; position: absolute; left: -5rem;"
                                onchange="edit({  
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
                                    edit({  'sid': <?= $row['sid'] ?>,
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
                    <div class="row edit_field">
                        <div class="col-1 lh-lg mb-1 fw-bold pe-0">
                            <?= $label == 'experience' ? '經歷' : '介紹' ?>:
                        </div>
                        <input id="<?= $label ?>_<?= $row[$label] ?>" class="col-10 hide_text lh-base align-self-center border border-0" type="text" value="<?= $row[$label] ?>" onkeyup="
                            if(event.which !== 13) return; 
                            edit({  'sid': <?= $row['sid'] ?>,
                                    'type': '<?= $label ?>',
                                    'data': this.value
                            });
                            this.blur();
                        ">
                        <div class="col-1 text-end"><i class="fa-solid fa-pen-to-square ms-1" style="cursor: pointer" onclick="document.getElementById('<?= $label ?>_<?= $row[$label] ?>').focus()"></i></div>
                    </div>
                    <?php endforeach ; ?>
                    <div class="edit_field lh-lg mb-1">
                        <button class="me-2 btn btn-primary" type="button" onclick="EditExpertise()">專項與證照
                            <i class="fa-solid fa-pen-to-square ms-1"></i>
                        </button>
                        <button class="me-2 btn btn-secondary" type="button">課程列表
                            <i class="fa-solid fa-pen-to-square ms-1"></i>
                        </button>
                        <button class="me-2 btn btn-secondary" type="button">文章列表
                            <i class="fa-solid fa-pen-to-square ms-1"></i>
                        </button>
                        <button class="me-2 btn btn-dark" type="button">查看評論</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ; ?>
</div>

<dialog id="certi_modal">
    <div class="modal_monitor" style="height: 200px; width:400px; border:1px solid;"></div>
    <button onclick="document.getElementById('certi_modal').close()">Close</button>
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

    async function edit(obj) {

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

    async function EditExpertise() {

        // LoadingModal.fire()

        return document.getElementById('certi_modal').showModal()

        const response = await fetch("./api/c_l_get_certifications.php", {
                method: "GET",
        })

        const data = await response.json()

        // console.log(data)
    }

</script>

<?php
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>