<?php
include './parts/html-head.php';
include './parts/html-navbar.php'; ?>
<div class="card shadow-sm">
    <div class="card-header bg-transparent">
        <div class="input-group">
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    操作
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <span class="input-group-text border-0 bg-transparent pe-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="search" class="form-control border-0 shadow-none">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr class="align-middle">
                        <th scope="col" class="ps-4"></th>
                        <th scope="col" class="py-3 ">訂單編號</th>
                        <th scope="col">Email</th>
                        <th scope="col">用戶姓名</th>
                        <th scope="col">購買品項</th>
                        <th scope="col">付款狀態</th>
                        <th scope="col">購買金額</th>
                        <th scope="col" class="pe-4">編輯</th>
                    </tr>
                </thead>
                <tbody class="text-nowrap">
                    <tr>
                        <td class="ps-4">
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td scope="row">TX123456788</td>
                        <td>ab1234@email.com</td>
                        <td>
                            卡小伯
                        </td>
                        <td>六角西餐：大麥克全家餐</td>
                        <td>
                            <div class="text-muted">尚未付款</div>
                        </td>
                        <td class="text-end">900</td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-dark">
                                    編輯 <i class="bi bi-pen"></i></a>
                                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    操作
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">修改狀態</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-order-id="TX123456788">刪除訂單</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td scope="row">TX123456789</td>
                        <td>ab1234@email.com</td>
                        <td>
                            卡小伯
                        </td>
                        <td>六角西餐：大麥克全家餐</td>
                        <td>
                            <div class="text-muted">尚未付款</div>
                        </td>
                        <td class="text-end">900</td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-dark">
                                    編輯 <i class="bi bi-pen"></i></a>
                                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    操作
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">修改狀態</a></li>
                                    <li><a class="dropdown-item" href="#">刪除訂單</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td scope="row">TX123456789</td>
                        <td>ab1234@email.com</td>
                        <td>
                            卡小伯
                        </td>
                        <td>六角西餐：大麥克全家餐</td>
                        <td>
                            <div class="text-muted">尚未付款</div>
                        </td>
                        <td class="text-end">900</td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-dark">
                                    編輯 <i class="bi bi-pen"></i></a>
                                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    操作
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">修改狀態</a></li>
                                    <li><a class="dropdown-item" href="#">刪除訂單</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-4">
                            <input type="checkbox" class="form-check-input">
                        </td>
                        <td scope="row">TX123456789</td>
                        <td>ab1234@email.com</td>
                        <td>
                            卡小伯
                        </td>
                        <td>六角西餐：大麥克全家餐</td>
                        <td>
                            <div class="text-muted">尚未付款</div>
                        </td>
                        <td class="text-end">900</td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-outline-dark">
                                    編輯 <i class="bi bi-pen"></i></a>
                                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    操作
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">修改狀態</a></li>
                                    <li><a class="dropdown-item" href="#">刪除訂單</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent py-3">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">刪除訂單</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確認刪除「<span id="deleteText"></span>」的訂單嗎？</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">確認刪除</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const modalByDelete = document.querySelector('#deleteModal');
        modalByDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const orderId = button.dataset.bsOrderId;
            console.log(button, orderId);
            const modalText = modalByDelete.querySelector('#deleteText');

            modalText.textContent = orderId;
        })
    </script>
</div>
<?php
include './parts/html-navbar-end.php'; ?>

<?php include './parts/html-scripts.php'; ?>
<link rel="stylesheet" href="./css/login.css">

<?php include './parts/html-footer.php'; ?>