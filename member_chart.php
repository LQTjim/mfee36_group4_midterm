<?php
$pageName = 'member';
$subPageName = 'member_chart';
$title = '會員分析';
include './parts/db-connect.php';
include './parts/html-head.php';
include './parts/html-navbar.php';
//輸入起訖年->自動算出起訖年--今年的數據->結果是陣列
$year = isset($_GET['year']) ? $_GET['year'] : 2020;

function generateYears($y)
{
    $arr = [];
    for ($i = 2023; $i >= $y; $i--) {
        $arr[] = $i;
    }
    return array_reverse($arr);
}
// echo json_encode(generateYears($year));
function countSex($sid, $y)
{
    global $pdo;
    $arr = [];
    foreach ($y as $v) {
        $sql = "SELECT COUNT(*) FROM `member` WHERE `sex_sid` = {$sid} AND `created_at` BETWEEN '{$v}-01-01' AND '{$v}-12-31';";
        $r = $pdo->query($sql)->fetch();

        $arr[] = intval(array_pop($r));
    }

    return $arr;
};

function countOtherSex($y)
{
    global $pdo;
    $arr = [];
    foreach ($y as $v) {
        $sql = "SELECT COUNT(*) FROM `member` WHERE (`sex_sid` = 3 OR `sex_sid` IS NULL) AND `created_at` BETWEEN '{$v}-01-01' AND '{$v}-12-31';";
        $r = $pdo->query($sql)->fetch();
        $arr[] = intval(array_pop($r));
    }
    return $arr;
};
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<link rel="stylesheet" href="./css/member.css">
<div>

    <a href="index.php">首頁</a>
    >>
    <a href="javascript: return;">會員分析</a>
</div>
<div class="w-100 d-flex flex-column justify-content-center align-items-center">
    <button class="btn btn-primary mb-2" id="dl-btn">下載圖表成PDF</button>
    <label>
        請輸入起訖年分
        <input min="2000" max="2023" type="number" id="year" value="<?= $year ?>">
    </label>
    <div class="member-mychart">
        <canvas id="myChart"></canvas>
    </div>
</div>
<script>
    (function() {
        const selectedYear = document.querySelector('#year');
        selectedYear.addEventListener('change', (e) => {
            location.href = `member_chart.php?year=${e.target.value}`
        })
        const {
            jsPDF
        } = window.jspdf;
        document.querySelector("#dl-btn").addEventListener("click", function() {
            var canvas = document.querySelector("#myChart");
            var canvas_img = canvas.toDataURL("image/png", 1.0); //JPEG will not match background color
            var pdf = new jsPDF("landscape", "in", "letter"); //orientation, units, page size
            pdf.addImage(canvas_img, "png", 0.5, 1.75, 10, 5); //image, type, padding left, padding top, width, height
            pdf.autoPrint(); //print window automatically opened with pdf
            var blob = pdf.output("bloburl");
            window.open(blob);
        });
        const type = "line";
        const options = {
            // maintainAspectRatio: false,
            // responsive: true,
            scales: {
                x: {

                },
                y: {
                    // min: 0,
                    // max: 2000,
                    // suggestedMin: 0,
                    // suggestedMax: 2000,
                    ticks: {
                        stepSize: 5,
                        callback: function(val, i, vals) {
                            return val + "人";
                        },
                    },
                },
            },
            plugins: {
                title: {
                    display: true,
                    text: "會員性別分析",

                    font: {
                        size: 50,
                    },
                    position: "top",
                },
                tooltip: {
                    callbacks: {
                        beforeTitle: (ctx) =>
                            '',
                    },
                },
            },
            animations: {

            },
            // animation: {
            //   duration: 10000,
            //   easing: "easeOutQuart",
            // },
        };
        /* const options = {
          responsive: true,
          plugins: {
            tooltip: {
              mode: "index",
              intersect: false,
            },
            title: {
              display: true,
              text: "Chart.js Line Chart",
            },
          },
          hover: {
            mode: "index",
            intersec: false,
          },
          scales: {
            x: {
              title: {
                display: true,
                text: "Month",
              },
            },
            y: {
              min: 0,
              max: 100,
              ticks: {
                // forces step size to be 50 units
                stepSize: 50,
              },
            },
          },
        }; */

        const data = {
            labels: <?= json_encode(generateYears($year)) ?>,
            datasets: [{
                    label: "男",
                    data: <?= json_encode(countSex(1, generateYears($year))) ?>
                },
                {
                    label: "女",
                    data: <?= json_encode(countSex(2, generateYears($year))) ?>
                },
                {
                    label: "其他",
                    data: <?= json_encode(countOtherSex(generateYears($year))) ?>
                },
            ],
        };
        let ctx = document.querySelector("#myChart").getContext("2d");
        const chart = new Chart(ctx, {
            type,
            data,
            options,
            //: {
            //   title: {
            //     display: true,
            //     text: "QT DRAWING",
            //     fontColor: "red",
            //     fontSize: "24",
            //   },
            // },
        });

    })()
</script>
<?php
include './parts/html-navbar-end.php'; ?>
<?php
include './parts/html-scripts.php';
include './parts/html-footer.php';
?>