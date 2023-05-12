<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<style>

    * {
        box-sizing: border-box;
    }

    .c_l_container .card{
        /* max-height: 100px; */
        padding: 20px;
        height: 220px;
    }

    .c_l_container .img-box {
        position: relative;
        height: 100%;
    }

    .c_l_container .img-box img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .c_l_container .edit-img {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 450%;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow: hidden;
        opacity: 0;
        cursor: pointer;
    }
    
    .c_l_container .edit-img:hover {
        opacity: 0.5;
    }

    .c_l_container .card-body p {
        padding: 2px 0;
        margin: 2px 0;
    }

    .c_l_container .card-body .expereince {
        font-style: oblique;
    }

</style>

<?php

    $sql = "SELECT * FROM `c_l_coach`" ;
    $statment = $pdo->query($sql) ;
    $rows = $statment->fetchAll() ;

?>

<div class="c_l_container container">

    <?php foreach($rows as $row): ?>
    <div class="card mb-3">
        <div class="row g-0 h-100">
            <div class="col-md-2 img-box">
                <img src="<?= $row['photo'] ?>" class="img-fluid rounded" alt="...">
                <i class="fa-solid fa-pen-to-square edit-img" onclick="document.getElementById('photo_<?= $row['sid'] ?>').click()"></i>
                <input type="file" accept="image/*" id="photo_<?= $row['sid'] ?>" onchange="edit({
                    'sid': <?= $row['sid'] ?>,
                    'type': 'photo',
                    'data': this.files[0]
                })" hidden>
            </div>
            <div class="col-md-10">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['nickname'] ?></h5>
                    <p class="card-text expereince"><?= $row['experience'] ?></p>
                    <p class="card-text"><?= $row['introduction'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach ; ?>

</div>


<script>

    async function edit(obj) {

        const formdata = new FormData()

        for(let key in obj){
            formdata.append(key, obj[key])
        }

        try {
            const response = await fetch("./api/c_l_handle_edit.php", {
                method: "POST",
                body: formdata,
            })

            const data = await response.json()

            Swal.fire({
                text: data.success ? 'Edit Success' : 'Data not modified',
                icon: data.success ? 'success' : 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1000
            })

            data.success && setTimeout(() => window.location.reload(), 1000)

        } catch (err) {
            console.log(err)
        }
    }

</script>

<?php
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>