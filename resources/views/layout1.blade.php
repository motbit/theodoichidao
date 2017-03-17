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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function () {
            nicEditors.allTextAreas()
        });
    </script>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <title>@section('page-title')
        @show</title>
</head>
<body>
<img src="/img/top-baner.png" width="100%" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()">
        <i class="fa fa-bars"></i>
    </a>
    <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Đăng nhập</a></li>
        @else
        <li class="dropdown">
            <a class="dropdown-toggle top-menu" data-toggle="dropdown" href="#">{{\Illuminate\Support\Facades\Auth::user()->fullname}}
                <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: black !important;">Đăng xuất</a></li>
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
        <div class="left-head">
            CÔNG VIỆC
        </div>
        <div class="list-menu">
            @if(\App\Roles::checkPermission())
            <div class="cate-menu">NGƯỜI DÙNG</div>
            <ul>
                <li><a href="{{@route('user-index')}}">Người sử dụng</a></li>
                <li><a href="{{@route('unit-index')}}">Ban - Đơn vị</a></li>
                <li><a href="{{@route('viphuman-index')}}">Người chủ trì</a></li>
            </ul>
            <div class="cate-menu">Ý KIẾN CHỈ ĐẠO</div>
            <ul>
                <li><a href="{{@route('sourcesteering-index')}}">Nguồn chỉ đạo</a></li>
                <li><a href="{{@route('steeringcontent-index')}}">Nội dung chỉ đạo</a></li>
            </ul>
            @endif
            <div class="cate-menu">XỬ LÝ CÔNG VIỆC</div>
            <ul>
                <li><a href="{{@route('xuly-daumoi')}}">Công việc đầu mối</a></li>
                <li><a href="{{@route('xuly-phoihop')}}">Công việc phối hợp</a></li>
                <li><a href="{{@route('xuly-duocgiao')}}">Công việc mới được giao</a></li>
                <li><a href="{{@route('xuly-nguonchidao')}}">Nguồn chỉ đạo</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        @yield('content')
    </div>
</div>
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