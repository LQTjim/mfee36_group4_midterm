<script>
    'use strict'

    // start === add form button ===
    const addBtn = document.querySelector(".add-btn");
    const addForm = document.querySelector(".add-form");

    if (addBtn) {
        addBtn.addEventListener("click", () => {
            addForm.classList.toggle('display-toggle');
        })
    }
    // end === add form button ===

    // start === cancel add data ===
    const cancelBtn = document.querySelector(".cancelBtn");

    cancelBtn.addEventListener("click", () => {
        addForm.classList.toggle('display-toggle');

        const input = addForm.querySelectorAll("input");

        for (let i = 0; i < input.length; i++) {

            // Check if the element is an input field (excluding checkboxes and radio buttons)
            if (input[i].type !== "checkbox" && input[i].type !== "radio") {
                input[i].value = ""; // Clear the value
            }
        }

    })
    // end === cancel add data ===

    // start === add form data ===
    const subDataBtn = document.querySelector(".formBtn");


    function addData() {
        const addApi = subDataBtn.dataset["addApi"];
        // console.log(addApi);

        const fm = document.querySelector("#addForm");
        const fd = new FormData(fm);
        // console.log(fd);

        fetch(addApi, {
            method: 'POST',
            body: fd
        }).then((res) => res.json()).then(
            (data) => {
                if (data.success) {
                    Swal.fire({
                        text: '新增成功',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    setTimeout(() => {
                        location.href = `?page=<?= $page ?>`
                    }, 1500)
                } else {
                    Swal.fire({
                        text: '新增失敗',
                        icon: 'error',
                        showCancelButton: false,
                        showConfirmButton: true
                    })
                    // setTimeout(() => {
                    //     location.href = `?page=<?= $page ?>`
                    // }, 1500)
                }
            }
        ).catch((err) => {
            console.log(err);
            Swal.fire({
                text: '錯誤，請聯絡工程師',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: true
            })
        })
    }
    // end === add form data ===



    // start === delete ===
    const modalByDelete = document.querySelector('#deleteModal');
    modalByDelete.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const orderId = button.dataset.bsOrderId;
        // console.log(button, orderId);
        modalByDelete.setAttribute('data-sid', orderId); //=== set 'sid' attribute
        const modalText = modalByDelete.querySelector('#deleteText');
        modalText.textContent = orderId;
    })


    const del1 = document.querySelector(".btn.btn-danger");
    del1.addEventListener('click', () => {
        const fd = new FormData();
        fd.append("sid", modalByDelete.dataset['sid']);
        fd.append("db", '<?= $data ?>');
        // console.log(fd);

        fetch('./api/record-deleteBySid-api.php', {
            method: 'POST',
            body: fd
        }).then((res) => res.json()).then(
            (data) => {
                if (data.success) {
                    Swal.fire({
                        text: '刪除成功',
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                    setTimeout(() => {
                        location.href = `?page=<?= $page ?>`
                    }, 1500)
                } else {
                    Swal.fire({
                        text: '刪除失敗',
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false
                    })
                    // setTimeout(() => {
                    //     location.href = `?page=<?= $page ?>`
                    // }, 1500)
                }
            }
        ).catch((err) => {
            console.log(err);
            Swal.fire({
                text: '錯誤，請聯絡工程師',
                icon: 'error',
                showCancelButton: true,
                showConfirmButton: false
            })
        })
    })
    // end === delete ===

    // start === toggle description ===
    const description = document.querySelectorAll("div.sean_description");
    description.forEach(
        (ele) => {
            ele.addEventListener('click', e => {
                e.target.classList.toggle('sean_ellipsis');
                // console.log(e.target);
            })
        }
    )
    // end === toggle description ===

    //=== for popover ===
    // const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    // const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    // //=== for tooltips ===
    // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>