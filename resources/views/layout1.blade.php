<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/js/jquery-3.1.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/img/fa-icon.png">

    <script src="/js/bootstrap.min.js"></script>
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/slide.css" rel="stylesheet" type="text/css">
    {{--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <link href="/css/jquery.dataTables.css" rel="stylesheet">
    <script src="/js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="/js/dataTables.buttons.js" type="text/javascript"></script>
    <script src="/js/buttons.flash.js" type="text/javascript"></script>
    <script src="/js/pdfmake.js" type="text/javascript"></script>
    <script src="/js/vfs_fonts.js" type="text/javascript"></script>
    <script src="/js/jszip.js" type="text/javascript"></script>
    <script src="/js/button.html5.js" type="text/javascript"></script>
    {{--<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>--}}
    <script src="/js/bootstrap-datepicker.js"></script>
    <link href="/css/datepicker.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
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
    </script>
    <script>
        $(document).ready(function () {
            // Setup - add a text input to each footer cell

            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
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
    <title>@section('page-title')
        @show</title>
</head>
<body>
<img src="/img/top-baner.png" width="100%" class="hidden-xs hidden-sm" height="auto">
<img src="/img/mobile-banner.png" width="100%" class="visible-xs visible-sm" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()" class="btn ico ico-menu">
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
            @if(\App\Roles::checkPermission())
                <div class="left-head">NGƯỜI DÙNG</div>
                <ul>
                    <li><a href="{{@route('user-index')}}">Người sử dụng</a></li>
                    <li><a href="{{@route('unit-index')}}">Ban - Đơn vị</a></li>
                    <li><a href="{{@route('viphuman-index')}}">Người chủ trì</a></li>
                </ul>
                <div class="left-head">Ý KIẾN CHỈ ĐẠO</div>
                <ul>
                    <li><a href="{{@route('sourcesteering-index')}}">Nguồn chỉ đạo</a></li>
                    <li><a href="{{@route('steeringcontent-index')}}">Danh mục nhiệm vụ</a></li>
                </ul>
            @endif
            <div class="left-head">XỬ LÝ NHIỆM VỤ</div>
            <ul>
                <li><a href="{{@route('xuly-daumoi')}}">Nhiệm vụ đầu mối</a></li>
                <li><a href="{{@route('xuly-phoihop')}}">Nhiệm vụ phối hợp</a></li>
                {{--<li><a href="{{@route('xuly-duocgiao')}}">Nhiệm vụ mới được giao</a></li>--}}
                {{--<li><a href="{{@route('xuly-nguonchidao')}}">Nguồn chỉ đạo</a></li>--}}
            </ul>
            <div class="left-head">THỐNG KÊ BÁO CÁO</div>
            <ul>
                <li><a href="#">Báo cáo thống kê</a></li>
                <li><a href="#">Báo cáo chi tiết</a></li>
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
            {{--<img src="/img/moet-logo.jpg" width="120" height="auto" border="0" />--}}
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

    $(document).ready(function () {
        // Handler for .ready() called.
        $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
    });
</script>
</html>