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
    

    <link rel="stylesheet" type="text/css" href="/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>

    
    <script src="/js/bootstrap-datepicker.js"></script>
    <link href="/css/datepicker.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


        
            
        
    
            <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            var currdate = Date.getDate + "-" + Date.getMonth + "-" + Date.getFullYear;
            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ],
                            modifier: {
                                page: 'current'
                            },
                        },
                        title: 'Danh mục nhiệm vụ (Ngày ' + currdate + ")",
                        orientation: 'landscape',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                        },
                        className: 'btn btn-success',
                        text: 'Export to pdf',
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success',
                        text: 'Export to excel',
                        title: 'Danh mục nhiệm vụ (Ngày ' + currdate + ")",
                        stripHtml: false,
                        decodeEntities: true,
                        columns: ':visible',
                        modifier: {
                            selected: true
                        },
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ],
                            format: {
                                body: function (data, row, column, node) {

                                    return column === 5 ?
                                            data.replace(/[.]/g, 'pooja') :
                                            data;
                                }
                            }
                        }
                    }
                ],
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
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

</script>
</html>