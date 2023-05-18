<div class="card-footer bg-transparent py-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end mb-0">
            <!-- ===  << button, disable when current page smaller than page per side === -->
            <li class="page-item <?= $page <= $pagePerSide ? 'disabled' : '' ?> ">
                <a class="page-link" href="?page=<?= 1 ?>">
                    <i class="fa-solid fa-angles-left"></i>
                </a>
            </li>
            <!-- === < button, disable in the 1st page ======================================== -->
            <li class="page-item <?= 1 == $page ? 'disabled' : '' ?> ">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>

            <!-- === pagination ======================================== -->
            <?php for ($i = $page - $pagePerSide; $i <= $page + $pagePerSide; $i++) :
                if ($i >= 1 and $i <= $totPages) : ?>
                    <!-- only add class=activate to the current page -->
                    <li class="page-item <?= $i == $page ? 'active' : "" ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
            <?php endif;
            endfor; ?>
            <!-- === > button, disble when current page is last page =========================== -->
            <li class="page-item <?= $totPages == $page ? 'disabled' : '' ?> ">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <!-- === >> button, disable when current page larger than total page minus page per side === -->
            <li class="page-item <?= $page >= $totPages - $pagePerSide ? 'disabled' : '' ?> ">
                <a class="page-link" href="?page=<?= $totPages ?>">
                    <i class="fa-solid fa-angles-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>