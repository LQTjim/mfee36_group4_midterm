<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    const dbt = document.querySelectorAll('[data-bs-toggle="collapse"]');
    dbt.forEach((el) => {
        el.addEventListener('click', () => {
            const i = el.querySelector('i')
            if (i.classList.contains("fa-caret-up")) {
                i.className = "fa-solid fa-caret-down"
            } else {
                i.className = "fa-solid fa-caret-up"
            }

        })
    })

    // const toggleMenuBtn = document.querySelector('#toggle-btn');
    // const body = document.querySelector('body');
    // toggleMenuBtn.addEventListener('click', (evt) => {
    //     evt.preventDefault();
    //     body.classList.toggle('sidebar-toggled');
    // });
</script>