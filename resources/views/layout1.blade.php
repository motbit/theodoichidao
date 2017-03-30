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
                        <li class="{{ (strpos(\Request::path(), $yk->path)  !== false )? 'active' : '' }}"><a href="{{$_ENV['ALIAS']}}/{{$yk->path}}">{{$yk->name}}</a></li>
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
                <li><a href="{{$_ENV['ALIAS']}}/report">Báo cáo chi tiết</a></li>
                {{--<li><a href="#">Báo cáo chi tiết</a></li>--}}
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

</script>
</html>