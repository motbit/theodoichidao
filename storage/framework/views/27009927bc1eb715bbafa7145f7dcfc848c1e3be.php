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
    

    <link rel="stylesheet" type="text/css"
          href="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript"
            src="<?php echo e($_ENV['ALIAS']); ?>/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>

    
    <script src="<?php echo e($_ENV['ALIAS']); ?>/js/bootstrap-datepicker.js"></script>
    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/datepicker.css" rel="stylesheet">


    <link href="<?php echo e($_ENV['ALIAS']); ?>/css/select2.css" rel="stylesheet"/>
    <script src="<?php echo e($_ENV['ALIAS']); ?>/js/select2.js"></script>






<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yy',
                dateFormat: 'dd/mm/yy',
                monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                    'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Th.Mười Một', 'Th.Mười Hai'],
                monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'TH 10', 'TH 11', 'TH 12'],
                dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
                dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            });
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
                        <li class="<?php echo e((strpos(\Request::path(), $nd->path)  !== false )? 'active' : ''); ?>"><a
                                    href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($nd->path); ?>"><?php echo e($nd->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
            <?php if(\App\Roles::accessView('steeringcontent')): ?>
                <div class="left-head"><a href="/" style="color: #43aa76 !important;">NHIỆM VỤ CỦA BỘ</a></div>
                <ul>
                    <li><a href="#">Phân loại theo nguồn</a></li>
                    <ul style="padding-left: 20px">
                        <?php $__currentLoopData = \App\Utils::listTypeSource(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="s-type <?php echo e((strpos(\Request::path(), "steeringcontent")  !== false && isset($parram) && $parram == 't'.$type->id)? 'active' : ''); ?>"
                                id="s-type-<?php echo e($type->id); ?>"><a
                                        href="<?php echo e($_ENV['ALIAS']); ?>/steeringcontent?type=<?php echo e($type->id); ?>"><?php echo e($type->name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <li><a href="#">Lãnh đạo Bộ phụ trách</a></li>
                    <ul style="padding-left: 20px">
                        <?php $__currentLoopData = \App\Utils::listConductor(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conductor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="s-type <?php echo e((strpos(\Request::path(), "steeringcontent")  !== false  && isset($parram) && $parram == 'c'.$conductor->id)? 'active' : ''); ?>">
                                <a
                                        href="<?php echo e($_ENV['ALIAS']); ?>/steeringcontent?conductor=<?php echo e($conductor->id); ?>"><?php echo e($conductor->name); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </ul>
            <?php endif; ?>
            <?php $menu_xlnv = \App\Roles::getMenu('XLNV'); ?>
            <?php if(count($menu_xlnv) > 0): ?>
                <div class="left-head">NHIỆM VỤ CỦA ĐƠN VỊ</div>
                <ul>
                    <?php $__currentLoopData = $menu_xlnv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e((strpos(\Request::path(), $xl->path)  !== false )? 'active' : ''); ?>"><a
                                    href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($xl->path); ?>"><?php echo e($xl->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
            <?php $menu_bc = \App\Roles::getMenu('BC'); ?>
            <?php if(count($menu_bc) > 0): ?>
                <div class="left-head">THỐNG KÊ BÁO CÁO</div>
                <ul>
                    <?php $__currentLoopData = $menu_bc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e((strpos(\Request::path(), $xl->path)  !== false )? 'active' : ''); ?>"><a
                                    href="<?php echo e($_ENV['ALIAS']); ?>/<?php echo e($xl->path); ?>"><?php echo e($xl->name); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
            <div class="left-head">THÔNG TIN HỖ TRỢ</div>
            <ul class="mnu-hotro">
                <li>Mr. Hà: <strong>0904.069.966</strong> (đầu mối)</li>
                <li>Mr. Tiến: <strong>0989.268.118</strong></li>
                <li>Mr. Tú: <strong>0972.541.665</strong></li>
                <li>Email: <strong>theodoichidao@moet.gov.vn</strong></li>
                <li><a style="color: #337ab7 !important; font-weight: bold" href="<?php echo e($_ENV['ALIAS']); ?>/file/hdsd.pdf"
                       download>Tải về hướng dẫn sử dụng</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <div id="modal-show-detail" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thông tin Nhiệm vụ</h4>
                </div>
                <div class="modal-body" style="padding-top: 0px !important;">
                    <div id="table-steering-detail"></div>
                </div>
            </div>
        </div>
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

    function highlightSourceType(id) {
        $(".s-type").removeClass('active');
        $("#s-type-" + id).addClass('active');
    }

    function createCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name,"",-1);
    }

    function resetcookiefiter() {
        // Get an array of cookies
        var arrSplit = document.cookie.split(";");

        for(var i = 0; i < arrSplit.length; i++)
        {
            var cookie = arrSplit[i].trim();
            var cookieName = cookie.split("=")[0];

            // If the prefix of the cookie's name matches the one specified, remove it
            if(cookieName.indexOf("filter:") === 0) {

                // Remove the cookie
                document.cookie = cookieName + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        }
    }

    /*
     Danh mục nhiệm vụ
     */

    var data_export = {};
    function reloadDataExport() {
        var data = new Array();
        $(".id-export").each(function (idx) {
            data.push($(this).html());
        });
        data_export = data;
    }

    function exportExcel(rowsort, typesort, filetype) {
        $(".loader").show();
        rowsort = rowsort || "id";
        typesort = typesort || "DESC";
        filetype = filetype || 'xlsx';

        if(filetype != 'pdf') filetype = 'xlsx';

        console.log(data_export);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "<?php echo e($_ENV['ALIAS']); ?>/report/exportsteering",
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                'filetype': filetype,
                data: data_export, rowsort: rowsort, typesort: typesort
            },
            async: false,
            success: function (result) {
                $(".loader").hide();
                console.log(result);
                window.location.href = "<?php echo e($_ENV['ALIAS']); ?>" + result.file;
            },
            error: function () {
                $(".loader").hide();
                alert("Xảy ra lỗi nội bộ");
            },
        });
    }

    function showDetail(id) {
        $(".loader").show();
        $.ajax({
            url: "<?php echo e($_ENV['ALIAS']); ?>/api/steering?id=" + id,
            success: function (result) {
                $(".loader").hide();
                var html_table = "";
                console.log(result);
                html_table += "<div class='alert alert-info'>" + result["content"] + "</div>";
                html_table += "<dl class=\"dl-horizontal\">";
                html_table += "<dt>Người tạo:</dt><dd>" + result['created_by'] + "</dd>";
                html_table += "<dt>Ngày tạo:</dt><dd>" + result['created_at'] + "</dd>";
                html_table += "<dt>Người theo dõi:</dt><dd>" + result['manager'] + "</dd>";
                if(result["conductor"][1] !== "undefined ") {
                    html_table += "<dt>LĐ Bộ phụ trách:</dt><dd>" + result["conductor"][1] + "</dd>";
                }

                html_table += "<dt>Ngày chỉ đạo:</dt><dd>" + result["steer_time"] + "</dd>";

                if(Object.keys(result["steeringSourceNotes"]).length > 0) {
                    html_table += "<dt>Nguồn chỉ đạo:</dt><dd>";
                    $.each( result["steeringSourceNotes"], function( key, value ) {
                        html_table += value;
                        if (key < result["steeringSourceNotes"].length - 1){
                            html_table += ", ";
                        }
                    });
                    html_table += "<dd>";
                }

                html_table += "<dt>Đơn vị đầu mối:</dt><dd>";
                $.each(result["unit"],function( index, element ) {
                    html_table += element.name;
                    if (index < result["unit"].length - 1){
                        html_table += ", ";
                    }
                });
                html_table += "<dd>";

                if(result["follow"].length > 0) {
                    html_table += "<dt>Đơn vị phối hợp:</dt><dd>";
                    $.each(result["follow"],function( index, element ) {
                        html_table += element.name;
                        if (index < result["follow"].length - 1){
                            html_table += ", ";
                        }
                    });
                    html_table += "<dd>";
                }else{
                    html_table += "<dt>Đơn vị phối hợp:</dt><dd>Không có</dd>";
                }

                html_table += "<dt>Phân loại:</dt><dd>" + result["priority"][1] + "</dd>";
                $("#table-steering-detail").html(html_table);
                $("#modal-show-detail").modal("show");
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
                $(".loader").hide();
            }
        });
    }
    function formatExport(data) {
        return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ').replace(/•/g, "\r\n•").replace(/[+] Xem thêm/g, "").trim();
    }
</script>
</html>