<?php
$pageName = 'Cart';
$title = 'Cart'
?>
<?php include "./parts/db-connect.php"; ?>

<?php include "./parts/admin-required.php"; ?>
<?php include "./parts/html-head.php"; ?>
<?php include "./parts/html-navbar.php"; ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
    </tbody>
</table>


<?php include "./parts/html-navbar-end.php"; ?>
<?php include "./parts/html-scripts.php"; ?>
<?php include "./parts/html-footer.php"; ?>