<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{$_ENV['ALIAS']}}/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{$_ENV['ALIAS']}}/img/fa-icon.png">

    <script src="{{$_ENV['ALIAS']}}/js/bootstrap.min.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{$_ENV['ALIAS']}}/css/main.css" rel="stylesheet" type="text/css">
    <link href="{{$_ENV['ALIAS']}}/css/slide.css" rel="stylesheet" type="text/css">
    {{--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">--}}

    <link rel="stylesheet" type="text/css" href="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>

    {{--<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>--}}
    <script src="{{$_ENV['ALIAS']}}/js/bootstrap-datepicker.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/datepicker.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    {{--<script type="text/javascript">--}}
    {{--bkLib.onDomLoaded(function () {--}}
    {{--nicEditors.allTextAreas()--}}
    {{--});--}}
    {{--</script>--}}
            <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                dateFormat: 'dd/mm/yy',
                monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                    'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Th.Mười Một', 'Th.Mười Hai'],
                monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
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
    <title>@section('page-title')
        @show</title>
</head>
<body>
<img src="{{$_ENV['ALIAS']}}/img/top-baner.png" width="100%" class="hidden-xs hidden-sm" height="auto">
<img src="{{$_ENV['ALIAS']}}/img/mobile-banner.png" width="100%" class="visible-xs visible-sm" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()" class="ico ico-menu" style="margin-top: 5px;">
    </a>
    <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
        @else
            <li class="dropdown">
                <a class="dropdown-toggle top-menu" data-toggle="dropdown"
                   href="#">{{\Illuminate\Support\Facades\Auth::user()->fullname}}
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('user-changepass') }}" style="color: black !important;">Sửa mật khẩu</a></li>
                    <li><a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                           style="color: black !important;">Đăng xuất</a></li>

                </ul>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </ul>
</nav>

<div class="main">
    <div id="mySidenav" class="sidenav">
        <div class="list-menu">
            <?php $menu_nd = \App\Roles::getMenu('ND'); ?>
            @if(count($menu_nd) > 0)
                <div class="left-head">NGƯỜI DÙNG</div>
                <ul>
                    @foreach($menu_nd as $nd)
                        <li class="{{ (strpos(\Request::path(), $nd->path)  !== false )? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/{{$nd->path}}">{{$nd->name}}</a></li>
                    @endforeach
                </ul>
            @endif
            <?php $menu_ykcd = \App\Roles::getMenu('YKCD'); ?>
            @if(count($menu_ykcd) > 0)
                <div class="left-head">Ý KIẾN CHỈ ĐẠO</div>
                <ul>
                    @foreach($menu_ykcd as $yk)
                        <li class="{{ (strpos(\Request::path(), $yk->path)  !== false || (Request::path() == '/' && $yk->path == 'steeringcontent'))? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/{{$yk->path}}">{{$yk->name}}</a></li>
                        @if($yk->path == 'steeringcontent' && (\Request::path() == $yk->path || (Request::path() == '/' && $yk->path == 'steeringcontent')))
                            <ul style="padding-left: 20px">
                            @foreach(\App\Utils::listTypeSource() as $type)
                                <li class="s-type" id="s-type-{{$type->id}}"><a href="javascript:filterTypeSource('{{$type->id}}','{{$type->name}}')">{{$type->name}}</a></li>
                            @endforeach
                            </ul>
                        @endif
                    @endforeach
                </ul>
            @endif
                <?php $menu_xlnv = \App\Roles::getMenu('XLNV'); ?>
                @if(count($menu_xlnv) > 0)
                    <div class="left-head">XỬ LÝ NHIỆM VỤ</div>
                    <ul>
                        @foreach($menu_xlnv as $xl)
                            <li class="{{ (strpos(\Request::path(), $xl->path)  !== false )? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/{{$xl->path}}">{{$xl->name}}</a></li>
                        @endforeach
                    </ul>
                @endif
            <div class="left-head">THỐNG KÊ BÁO CÁO</div>
            <ul>
                <li class="{{ (\Request::path() == 'report')? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/report">Báo cáo thống kê chi tiết</a></li>
                <li class="{{ (strpos(\Request::path(), 'report/unit')  !== false )? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/report/unit">Báo cáo thống kê đơn vị</a></li>
            </ul>
            <div class="left-head">THÔNG TIN HỖ TRỢ</div>
            <ul class="mnu-hotro">
                <li>Mr. Hà:     <strong>0904.069.966</strong> (đầu mối)</li>
                <li>Mr. Tiến:   <strong>0989.268.118</strong> </li>
                <li>Mr. Tú:     <strong>0972.541.665</strong></li>
                <li>Email:      <strong>theodoichidao@moet.gov.vn</strong></li>
                <li><a style="color: #337ab7 !important; font-weight: bold" href="{{$_ENV['ALIAS']}}/file/hdsd.pdf" download>Tải về hướng dẫn sử dụng</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        @yield('content')
    </div>
    <div class="loader"></div>
</div>
<footer>
    <!-- Example row of columns -->
    <div class="row footer">
        <div class="col-sm-4">
            {{--<img src="{{$_ENV['ALIAS']}}/img/moet-logo.jpg" width="120" height="auto" border="0" />--}}
        </div>
        <div class="col-sm-8 pull-right" style="text-align: right">
            <div class="footer-text">
                <p><strong>BẢN QUYỀN THUỘC VỀ: BỘ GIÁO DỤC VÀ ĐÀO TẠO</strong></p>
                <p>Địa chỉ: Số 35 Đại Cồ Việt, Hai Bà Trưng, Hà Nội</p>
                {{--<p>Điện thoại: 04.38695144; Fax: 04.38694085;</p>--}}
                {{--<p>Email: bogddt@moet.gov.vn</p>--}}
                {{--<p><strong>Thiết kế bởi Cục Công nghệ thông tin - Bộ Giáo dục và Đào tạo</strong></p>--}}
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{$_ENV['ALIAS']}}/report/exportsteering",
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), data: data_export},
            async: false,
            success: function (result) {
                console.log(result);
                window.location.href = "{{$_ENV['ALIAS']}}" + result.file;
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{$_ENV['ALIAS']}}/report/exportreport",
            type: 'POST',
            dataType: 'json',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), data: data_report},
            async: false,
            success: function (result) {
                console.log(result);
                window.location.href = "{{$_ENV['ALIAS']}}" + result.file;
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