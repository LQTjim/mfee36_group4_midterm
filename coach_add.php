<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<link rel="stylesheet" href="./css/coach.css">

<div class="c_li_container container">
<div class="d-flex mb-3">
    <button class="btn btn-primary ms-auto" type="button" onclick="window.location='coach_list.php'">教練列表</button>
</div>
<div class="card mb-3">
    <form class="row g-0 h-100" onsubmit="CreateCoach(event)">
        <div class="col-lg-2 col-md-3 col-sm-4 img-box">
            <img src="./imgs/coach_imgs/coach.png" id="photo" class="img-fluid rounded" alt="coach img">
            <i class="fa-solid fa-pen-to-square edit-img" onclick="document.getElementById('photo_').click()"></i>
            <input name="photo" type="file" accept="image/png, image/jpeg, image/webp" id="photo_" hidden onchange="
                const [file] = this.files 
                if(!file) return
                document.getElementById('photo').src = window.URL.createObjectURL(file)
            ">
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div id="search_card" class="card-body h-100 d-flex justify-content-start align-items-center">
            <span class="ms-5 me-3 edit_field lh-lg">
                <label for="" class="me-1 fw-bold">會員編號:</label>
                <input name="member_sid" id="search_id" class="lh-base" value='0' type="number" style="width: 8rem" oninput="
                    const numReg = /^\d+$/ ;
                    this.value = numReg.test(this.value) ? parseInt(this.value) : 0;
                ">
                <button class="btn btn-secondary align-self-start" type="button" onclick="SearchMember(document.getElementById('search_id').value)">搜尋</button>
            </span>
            </div>
            <div class="card-body py-0" id="coach_card" hidden>
                <div class="coach_name_field">
                    <span class="edit_field me-3">
                        <label class="me-1 fw-bold lh-lg">會員編號:</label>
                        <span id="member_id" class="d-inline-block hide_text" style="width: 6rem; vertical-align:sub;"></span>
                    </span>
                    <span class="edit_field me-3">
                        <label class="me-1 fw-bold lh-lg">姓名:</label>
                        <span id="member_name" class="d-inline-block hide_text" style="width: 6rem; vertical-align:sub;"></span>
                    </span>
                    <span class="edit_field ms-auto">
                        <label for="" class="me-1 fw-bold">加入時間:</label>
                        <button class="edit_button" type="button" style="position:relative"
                        onclick="
                            const dateInput = this.querySelector('input');
                            dateInput.showPicker();
                        ">
                            <span></span>
                            <i class="fa-solid fa-pen-to-square ms-2"></i>
                            <input name="created_at" type="date" style="visibility: hidden; position: absolute; left: -5rem;"
                            onchange="">
                        </button>
                    </span>
                </div>
                <?php 
                    $list = [
                        'nickname' => '暱稱',
                        'experience' => '經歷',
                        'introduction' => '介紹'
                    ] ;
                    foreach($list as $key => $label) :
                ?>
                <div class="row edit_field align-middle">
                    <div class="col-1 lh-lg mb-1 fw-bold pe-0">
                        <?= $label ?>:
                    </div>
                    <input name="<?= $key ?>" id="<?= $key ?>" class="col-10 hide_text lh-base align-self-center" type="text" <?= $key == 'nickname' ? 'style="width: 12rem;"' : '' ?> >
                    <div class="col-1 <?= $key == 'nickname' ? '' : 'text-end' ?>">
                        <i class="fa-solid fa-pen-to-square ms-1" style="cursor: pointer" onclick="document.getElementById('<?= $key ?>').focus()"></i>
                    </div>
                </div>
                <?php endforeach ; ?>
                <div class="edit_field lh-lg d-flex mt-1 align-items-center">
                    <button class="me-2 btn btn-primary" type="button" onclick="OpenCertiModal()">編輯證照
                        <i class="fa-solid fa-pen-to-square ms-1"></i>
                    </button>
                    <input name="certification" id="certi_ids" type="text" hidden>
                    <button class="me-2 btn btn-secondary" type="button">課程列表
                        <i class="fa-solid fa-pen-to-square ms-1"></i>
                    </button>
                    <button class="ms-auto btn btn-dark" type="submit">
                        確定新增
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
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
            document.getElementById('certi_ids').value = data
            CloseCertiModal();
        ">新增</button>
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

    async function SearchMember(id) {

        LoadingModal.fire()

        const response = await fetch(`./api/c_l_get_members.php?id=${id}`, {
            method: "GET",
        })

        const data = await response.json()

        await Swal.fire({
            titleText: data['success'] ? '會員資料搜尋成功' : data['error'],
            icon: data['success'] ? 'success' : 'error',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            customClass: {
                timerProgressBar: 'c_l_progressBar'
            }
        })

        if(!data['success']) return

        document.getElementById('member_name').textContent = data['data']
        document.getElementById('member_id').textContent = id
        document.getElementById('search_card').className = ''
        document.getElementById('search_card').setAttribute('hidden', '')
        document.getElementById('coach_card').removeAttribute('hidden')

    }

    async function CreateCoach(event) {
        event.preventDefault()

        const card_hide = document.getElementById('coach_card').hasAttribute('hidden')

        if(card_hide) {
            SearchMember(document.getElementById('search_id').value)
            return false
        } 
        
        LoadingModal.fire()

        const formData = new FormData(event.target)

        const response = await fetch("./api/c_l_handle_addCoach.php", {
            method: "POST",
            body: formData,
        })

        const data = await response.json()

        Swal.fire({
            titleText: data['success'] ? '成功新增教練資料' : '新增失敗',
            icon: data['success'] ? 'success' : 'error',
            showCancelButton: false,
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            customClass: {
                timerProgressBar: 'c_l_progressBar'
            },
            didClose: () => {
                if(!data.success) return
                window.location = `coach_list.php`
            }
        })
    }

    // check if already get certifications data
    let getCertied = false

    async function OpenCertiModal() {
        let modal = document.getElementById('certi_modal')

        if(getCertied) return modal.showModal()

        LoadingModal.fire()

        const response = await fetch(`./api/c_l_get_certifications.php`, {
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
        getCertied = true

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
    }

    function CloseCertiModal() {
        // let parents = [
        //         document.querySelector('.modal_body'),
        //         document.querySelector('.modal_monitor')
        //     ];

        // for(let parent of parents ) {
        //     while (parent.firstChild) {
        //         parent.removeChild(parent.firstChild);
        //     }
        // }
        
        // let certi_modal = document.getElementById('certi_modal');
        // certi_modal.removeAttribute('data-sid');
        certi_modal.close();
    }

</script>

<?php 
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>