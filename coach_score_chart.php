<?php
    include './parts/admin-required.php';
    include './parts/db-connect.php' ;
    $pageName = 'Coachs';
    include './parts/html-head.php';
    include './parts/html-navbar.php';
?>

<link rel="stylesheet" href="./css/coach.css">

<?php
    isset($_GET)
?>

<div class="c_li_container container">
    <h1>score chart here</h1>
</div>

<?php
    include './parts/html-navbar-end.php';
    include './parts/html-scripts.php';
    include './parts/html-footer.php';
?>