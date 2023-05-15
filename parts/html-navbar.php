<?php
if (!isset($pageName)) {
  $pageName = '';
}
include './parts/admin-required.php';
?>

<div class="d-flex ">
  <aside class="sidebar vh-100 border-end pt-3 d-flex bg-white flex-column">
    <!-- 1. 後台名稱 -->
    <div class="px-4">
      <strong>Group4</strong>
      - 後台管理
    </div>
    <!-- 2. 選單 -->
    <div class="overflow-auto mt-3">
      <div><!-- 不包含子選單 -->
        <a class="sidebar-link <?= $pageName === 'homepage' ? 'active' : '' ?>" href="./index.php" role="button">
          <div class="px-4 ">
            <i class="bi bi-house me-2"></i>
            首頁
          </div>
        </a>
      </div>
      <div><!-- 包含子選項 -->
        <a data-bs-toggle="collapse" class="sidebar-link <?= $pageName === 'member' ? 'active' : '' ?>" href="#menu-member" role="button">
          <div class="d-flex justify-content-between px-4">
            <p class="mb-0">
              會員管理
            </p>
            <i class="fa-solid fa-caret-down"></i>
          </div>
        </a>
        <div class="collapse" id="menu-member" role="button">
          <a href="./member_list.php" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            會員列表
          </a>
          <a href="/order.html" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            新增會員
          </a>
        </div>
      </div>
      <div><!-- 包含子選項 -->
        <?php $c_l_pages = ['Lessions', 'Coachs', 'Blogs', 'Details Management'] ?>
        <a data-bs-toggle="collapse" class="sidebar-link <?= in_array($pageName, $c_l_pages) ? 'active' : '' ?>" href="#coach-lession" role="button">
          <div class="d-flex justify-content-between px-4">
            <p class="mb-0">
              教練與課程系統
            </p>
            <i class="fa-solid fa-caret-down"></i>
          </div>
        </a>
        <div class="collapse" id="coach-lession" role="button">
          <a href="./coach_list.php" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            教練列表
          </a>
          <a href="./lession_list.php" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            課程列表
          </a>
          <a href="./blog_list.php" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            部落格列表
          </a>
          <a href="./details_manage.php" class="d-block ps-5 text-dark text-decoration-none sidebar-link">
            細項管理
          </a>
        </div>
      </div>
      <div><!-- 不包含子選單 -->
        <a class="sidebar-link" href="/" role="button">
          <div class="px-4">
            參考連結
          </div>
        </a>
      </div>
    </div>
    <div class="d-flex justify-content-around align-items-center px-1 pb-2 mt-auto w-100">
      <img src="<?= isset($_SESSION['admin']['hero_icon']) ? $_SESSION['admin']['hero_icon'] : "./imgs/defalut_icon.jpg" ?>" alt="<?= isset($_SESSION['admin']['name']) ? $_SESSION['admin']['name'] : '使用者' ?>" class="navbar-icon" />
      <div class="ps-2">Hi,<?= isset($_SESSION['admin']['name']) ? $_SESSION['admin']['name'] : '使用者'  ?> 您好</div>
    </div>
    <div class="d-flex px-2 pb-1">
      <a class="w-100 btn btn-primary " href="./api/logout-api.php" role="button">登出</a>
    </div>
  </aside>
  <main class="main">
    <!-- <div class="bg-white w-100 border-bottom sticky-top">
                <a href="#" class="d-inline-block py-3 px-4 border-end" id="toggle-btn">
                    <i class="bi bi-arrows-angle-expand"></i>
                </a>
            </div> -->
    <div class="p-4">