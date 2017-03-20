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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/jquery.dataTables.css" rel="stylesheet">
    <script src="/js/jquery.dataTables.js" type="text/javascript"></script>

    <script type="text/javascript">
        bkLib.onDomLoaded(function () {
            nicEditors.allTextAreas()
        });
    </script>
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
                        that.search( this.value ? '^'+this.value+'$' : '', true, false ).draw();
                    }
                });
            });
        });
    </script>
    <style>
        #table_filter{
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
    <a href="javascript:actionNav()">
        <i class="fa fa-bars"></i>
    </a>
    <ul class="nav navbar-nav navbar-right">
        <?php if(Auth::guest()): ?>
            <li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
        <?php else: ?>
        <li class="dropdown">
            <a class="dropdown-toggle top-menu" data-toggle="dropdown" href="#"><?php echo e(\Illuminate\Support\Facades\Auth::user()->fullname); ?>

                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo e(route('logout')); ?>"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: black !important;">Đăng xuất</a></li>
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
        <div class="left-head">
            CÔNG VIỆC
        </div>
        <div class="list-menu">
            <?php if(\App\Roles::checkPermission()): ?>
            <div class="cate-menu">NGƯỜI DÙNG</div>
            <ul>
                <li><a href="<?php echo e(@route('user-index')); ?>">Người sử dụng</a></li>
                <li><a href="<?php echo e(@route('unit-index')); ?>">Ban - Đơn vị</a></li>
                <li><a href="<?php echo e(@route('viphuman-index')); ?>">Người chủ trì</a></li>
            </ul>
            <div class="cate-menu">Ý KIẾN CHỈ ĐẠO</div>
            <ul>
                <li><a href="<?php echo e(@route('sourcesteering-index')); ?>">Nguồn chỉ đạo</a></li>
                <li><a href="<?php echo e(@route('steeringcontent-index')); ?>">Nội dung chỉ đạo</a></li>
            </ul>
            <?php endif; ?>
            <div class="cate-menu">XỬ LÝ CÔNG VIỆC</div>
            <ul>
                <li><a href="<?php echo e(@route('xuly-daumoi')); ?>">Công việc đầu mối</a></li>
                <li><a href="<?php echo e(@route('xuly-phoihop')); ?>">Công việc phối hợp</a></li>
                <li><a href="<?php echo e(@route('xuly-duocgiao')); ?>">Công việc mới được giao</a></li>
                <li><a href="<?php echo e(@route('xuly-nguonchidao')); ?>">Nguồn chỉ đạo</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>
<footer class="footer">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-sm-4">
                <img src="/img/moet-logo.jpg" width="150" height="auto" border="0" />
            </div>
            <div class="col-sm-8 pull-right" style="text-align: right">
                <div class="footer-text">
                    <p><strong>BẢN QUYỀN THUỘC VỀ: BỘ GIÁO DỤC VÀ ĐÀO TẠO</strong></p>
                    <p>Địa chỉ: Số 35 Đại Cồ Việt, Hà Nội</p>
                    <p>Điện thoại: 04.38695144; Fax: 04.38694085;</p>
                    <p>Email: bogddt@moet.gov.vn</p>
                    <p><strong>Thiết kế bởi Cục Công nghệ thông tin - Bộ Giáo dục và Đào tạo</strong></p>
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
</script>
</html>