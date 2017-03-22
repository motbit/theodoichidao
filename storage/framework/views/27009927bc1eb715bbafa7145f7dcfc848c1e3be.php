<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="/img/fa-icon.png">

    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/slide.css" rel="stylesheet" type="text/css">
    
    <link href="/css/jquery.dataTables.css" rel="stylesheet">
    <script src="/js/jquery.dataTables.js" type="text/javascript"></script>
    
    <script src="/js/bootstrap-datepicker.js"></script>
    <link href="/css/datepicker.css" rel="stylesheet">

    
        
            
        
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell

            // DataTable
            var table = $('#table').DataTable({
                bSort: false,
                bLengthChange: false,
                "pageLength": 20
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                    }
                });
            });
        });
    </script>
    <style>
        #table_filter {
            display: none;
        }
    </style>
    <title><?php $__env->startSection('page-title'); ?>
        <?php echo $__env->yieldSection(); ?></title>
</head>
<body>
<img src="/img/top-baner.png" width="100%" class="hidden-xs hidden-sm" height="auto">
<img src="/img/mobile-banner.png" width="100%" class="visible-xs visible-sm" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()" class="btn ico ico-menu">
    </a>
    <ul class="nav navbar-nav navbar-right">
        <?php if(Auth::guest()): ?>
            <li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
        <?php else: ?>
            <li class="dropdown">
                <a class="dropdown-toggle top-menu" data-toggle="dropdown"
                   href="#"><?php echo e(\Illuminate\Support\Facades\Auth::user()->fullname); ?>

                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo e(route('logout')); ?>"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                           style="color: black !important;">Đăng xuất</a></li>
                </ul>
            </li>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>
        <?php endif; ?>
    </ul>
</nav>

<div class="main">
    <div id="mySidenav" class="sidenav">
        <div class="list-menu">
            <?php if(\App\Roles::checkPermission()): ?>
                <div class="left-head">NGƯỜI DÙNG</div>
                <ul>
                    <li><a href="<?php echo e(@route('user-index')); ?>">Người sử dụng</a></li>
                    <li><a href="<?php echo e(@route('unit-index')); ?>">Ban - Đơn vị</a></li>
                    <li><a href="<?php echo e(@route('viphuman-index')); ?>">Người chủ trì</a></li>
                </ul>
                <div class="left-head">Ý KIẾN CHỈ ĐẠO</div>
                <ul>
                    <li><a href="<?php echo e(@route('sourcesteering-index')); ?>">Nguồn chỉ đạo</a></li>
                    <li><a href="<?php echo e(@route('steeringcontent-index')); ?>">Danh mục nhiệm vụ</a></li>
                </ul>
            <?php endif; ?>
            <div class="left-head">XỬ LÝ NHIỆM VỤ</div>
            <ul>
                <li><a href="<?php echo e(@route('xuly-daumoi')); ?>">Nhiệm vụ đầu mối</a></li>
                <li><a href="<?php echo e(@route('xuly-phoihop')); ?>">Nhiệm vụ phối hợp</a></li>
                <li><a href="<?php echo e(@route('xuly-duocgiao')); ?>">Nhiệm vụ mới được giao</a></li>
                <li><a href="<?php echo e(@route('xuly-nguonchidao')); ?>">Nguồn chỉ đạo</a></li>
            </ul>
            <div class="left-head">THỐNG KÊ BÁO CÁO</div>
            <ul>
                <li><a href="#">Báo cáo thống kê</a></li>
                <li><a href="#">Báo cáo chi tiết</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>
<footer>
    <!-- Example row of columns -->
    <div class="row footer">
        <div class="col-sm-4">
            
        </div>
        <div class="col-sm-8 pull-right" style="text-align: right">
            <div class="footer-text">
                <p><strong>BẢN QUYỀN THUỘC VỀ: BỘ GIÁO DỤC VÀ ĐÀO TẠO</strong></p>
                <p>Địa chỉ: Số 35 Đại Cồ Việt, Hai Bà Trưng, Hà Nội</p>
                
                
                
            </div>
        </div>
    </div>
</footer>
</body>
<script>
    var open = true;
    console.log(window.innerWidth + "/" + window.innerHeight)
    if (window.innerWidth < window.innerHeight || window.innerWidth < 800) {
        open = false;
    }
    function openNav() {
        document.getElementById("mySidenav").style.left = "0px";
        document.getElementById("content").style.marginLeft = "300px";
    }
    function closeNav() {
        document.getElementById("mySidenav").style.left = "-300px";
        document.getElementById("content").style.marginLeft = "0";
    }

    function actionNav() {
        if (open) {
            open = false;
            closeNav();
        } else {
            open = true;
            openNav();
        }
    }
    $(".main").css('min-height', $("#mySidenav").height() + 20 + "px");

    $(document).ready(function () {
        // Handler for .ready() called.
        $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
    });
</script>
</html>