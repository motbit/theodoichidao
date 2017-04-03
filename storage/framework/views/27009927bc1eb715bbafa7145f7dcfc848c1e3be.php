<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?php echo e($_ENV['ALIAS']); ?>/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e($_ENV['ALIAS']); ?>/img/fa-icon.png">

    <script src="<?php echo e($_ENV['ALIAS']); ?>/js/bootstrap.min.js"></script>
    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/slide.css" rel="stylesheet" type="text/css">
    

    <link rel="stylesheet" type="text/css" href="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>

    
    <script src="<?php echo e($_ENV['ALIAS']); ?>/js/bootstrap-datepicker.js"></script>
    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/datepicker.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    
    
    
    
    
            <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        $(document).ready(function () {
            $('.datepicker').on('changeDate', function (ev) {
                // do what you want here
                $(this).datepicker('hide');
            });
        });
    </script>
    <title><?php $__env->startSection('page-title'); ?>
        <?php echo $__env->yieldSection(); ?></title>
</head>
<body>
<img src="<?php echo e($_ENV['ALIAS']); ?>/img/top-baner.png" width="100%" class="hidden-xs hidden-sm" height="auto">
<img src="<?php echo e($_ENV['ALIAS']); ?>/img/mobile-banner.png" width="100%" class="visible-xs visible-sm" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()" class="ico ico-menu" style="margin-top: 5px;">
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
                    <li><a href="<?php echo e(route('user-changepass')); ?>" style="color: black !important;">Sửa mật khẩu</a></li>
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
            <?php $menu_nd = \App\Roles::getMenu('ND'); ?>
            <?php if(count($menu_nd) > 0): ?>
                <div class="left-head">NGƯỜI DÙNG</div>
                <ul>
                    <?php $__currentLoopData = $menu_nd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e((strpos(\Request::path(), $nd->path)  !== false )? 'active' : ''); ?>"><a href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($nd->path); ?>"><?php echo e($nd->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
            <?php $menu_ykcd = \App\Roles::getMenu('YKCD'); ?>
            <?php if(count($menu_ykcd) > 0): ?>
                <div class="left-head">Ý KIẾN CHỈ ĐẠO</div>
                <ul>
                    <?php $__currentLoopData = $menu_ykcd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e((strpos(\Request::path(), $yk->path)  !== false || (Request::path() == '/' && $yk->path == 'steeringcontent'))? 'active' : ''); ?>"><a href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($yk->path); ?>"><?php echo e($yk->name); ?></a></li>
                        <?php if($yk->path == 'steeringcontent' && (strpos(\Request::path(), $yk->path)  !== false || (Request::path() == '/' && $yk->path == 'steeringcontent'))): ?>
                            <ul style="padding-left: 20px">
                            <?php $__currentLoopData = \App\Utils::listTypeSource(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="s-type" id="s-type-<?php echo e($type->id); ?>"><a href="javascript:filterTypeSource('<?php echo e($type->id); ?>','<?php echo e($type->name); ?>')"><?php echo e($type->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
                <?php $menu_xlnv = \App\Roles::getMenu('XLNV'); ?>
                <?php if(count($menu_xlnv) > 0): ?>
                    <div class="left-head">XỬ LÝ NHIỆM VỤ</div>
                    <ul>
                        <?php $__currentLoopData = $menu_xlnv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="<?php echo e((strpos(\Request::path(), $xl->path)  !== false )? 'active' : ''); ?>"><a href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($xl->path); ?>"><?php echo e($xl->name); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            <div class="left-head">THỐNG KÊ BÁO CÁO</div>
            <ul>
                <li class="<?php echo e((\Request::path() == 'report')? 'active' : ''); ?>"><a href="<?php echo e($_ENV['ALIAS']); ?>/report">Báo cáo thống kê chi tiết</a></li>
                <li class="<?php echo e((strpos(\Request::path(), 'report/unit')  !== false )? 'active' : ''); ?>"><a href="<?php echo e($_ENV['ALIAS']); ?>/report/unit">Báo cáo thống kê đơn vị</a></li>
            </ul>
            <div style="padding: 15px; border-top: solid 1px #ccc; color: #818181; font-size: 0.9em">
                <div style="color: #43aa76; font-size: 1.2em"><strong>THÔNG TIN HỖ TRỢ</strong></div>
                Mr. Hà: <strong>0904.069.966</strong> <br>
                Mr. Tiến: <strong>0989.268.118</strong> <br>
                Mr. Tú: <strong>0972.541.665</strong><br>
                EMAIL: <strong>theodoichidao@moet.gov.vn</strong>
            </div>
        </div>
    </div>
    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <div class="loader"></div>
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

    function highlightSourceType(id){
        $(".s-type").removeClass('active');
        $("#s-type-" + id).addClass('active');
    }

    /*
    Danh mục nhiệm vụ
     */

    var data_export = {};
    function reloadDataExport(){
        var data =  new Array();
        $(".row-export").each(function(){
            var td = $(this).children();
            data.push({
                "idx" : formatExport(td.get(0).innerHTML),
                "content" : formatExport(td.get(1).innerHTML),
                "source" : formatExport(td.get(2).innerHTML),
                "unit" : formatExport(td.get(3).innerHTML),
                "follow" : formatExport(td.get(4).innerHTML),
                "deadline" : formatExport(td.get(5).innerHTML),
                "status" : formatExport(td.get(6).innerHTML),
            });
        });
        data_export = data;
    }

    function exportExcel(){
        console.log(data_export);
        $.ajax({
            url: "<?php echo e($_ENV['ALIAS']); ?>/report/exportsteering",
            type: 'POST',
            dataType: 'json',
            data: {filename: "Danh mục Nhiệm vụ", data: data_export},
            async: false,
            success: function (result) {
                console.log(result);
                window.location.href = "<?php echo e($_ENV['ALIAS']); ?>" + result.file;
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
            },
        });
    }

    /*
    Danh mục chi tiết báo cáo
     */

    var data_report = {};
    function reloadDataReport(){
        var data =  new Array();
        $(".row-export").each(function(){
            var td = $(this).children();
            data.push({
                "idx" : formatExport(td.get(0).innerHTML),
                "content" : formatExport(td.get(1).innerHTML),
                "conductor" : formatExport(td.get(2).innerHTML),
                "time" : formatExport(td.get(3).innerHTML),
                "source" : formatExport(td.get(4).innerHTML),
                "unit" : formatExport(td.get(5).innerHTML),
                "follow" : formatExport(td.get(6).innerHTML),
                "deadline" : formatExport(td.get(7).innerHTML),
                "status" : formatExport(td.get(8).innerHTML),
            });
        });
        data_report = data;
    }

    function exportReportExcel(){
        console.log(data_report);
        $.ajax({
            url: "<?php echo e($_ENV['ALIAS']); ?>/report/exportreport",
            type: 'POST',
            dataType: 'json',
            data: {filename: "Danh mục Nhiệm vụ", data: data_report},
            async: false,
            success: function (result) {
                console.log(result);
                window.location.href = "<?php echo e($_ENV['ALIAS']); ?>" + result.file;
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
            },
        });
    }

    function formatExport(data){
        return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ').replace(/•/g, "\r\n•").replace(/[+] Xem thêm/g, "").trim();
    }
</script>
</html>