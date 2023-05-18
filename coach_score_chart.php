<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<link rel="stylesheet" href="./css/coach.css">

<style>
    .c_li_container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-inline: auto;
        position: relative;
        width: 70vw;
        height: 90vh;
    }
</style>

<?php
    if(!isset($_GET['id']) || !isset($_GET['name'])) {
        header('Location: coach_list.php') ;
        exit ;
    }

    $sid = intval($_GET['id']) ;

    $month = [
        '2022-10-01' => '2022-10-31',
        '2022-11-01' => '2022-11-30',
        '2022-12-01' => '2022-12-31',
        '2023-01-01' => '2023-01-31',
        '2023-02-01' => '2023-02-28',
        '2023-03-01' => '2023-03-31',
        '2023-04-01' => '2023-04-30',
    ] ;

    $all = [] ;
    foreach( $month as $begin => $end ) {
        $sql = " SELECT `score` FROM `c_l_coach_likes` 
                 WHERE `coach_sid` = {$sid} AND `created_at` 
                 BETWEEN '{$begin}' AND '{$end}' "
        ;
    
        $statment = $pdo->query($sql) ;
        $rows = $statment->fetchAll() ;

        $sum = 0 ;
        foreach( $rows as $row ) {
            $sum += $row['score'] ;
        } ;
        $avg = $sum == 0 ? 0 : $sum / count($rows) ;

        $all[] = $avg ;
    }

?>

<div class="c_li_container">
    <div class="ms-5 mb-3 fs-4 fw-bold d-flex">
        <label class="me-4">教練編號:
            <span><?= $_GET['id'] ?></span>
        </label>
        <label class="">教練姓名:
            <span><?= $_GET['name'] ?></span>
        </label>
        <button class="btn btn-primary ms-auto" type="button" onclick="
            const url = 'referrer' in document ? document.referrer : 'coach_list.php'
            window.location.replace(url)
        ">返回</button>
    </div>
    <canvas id="scoreChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('scoreChart');
    Chart.defaults.font.size = 16;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [1,2,3,4,5,6,7],
            datasets: [{
                label: '月均評分',
                data: [
                    <?= $all[0] ?>,
                    <?= $all[1] ?>,
                    <?= $all[2] ?>,
                    <?= $all[3] ?>,
                    <?= $all[4] ?>,
                    <?= $all[5] ?>,
                    <?= $all[6] ?>
                ],
                fill: true,
                borderColor: '#aa00b6',
                tension: 0.1,
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '月份',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: '評分',
                    },
                    min: 2,
                    max: 10,
                    ticks: {
                        stepSize: 2
                    }
                },
            }
        }
    })
</script>

<?php
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>