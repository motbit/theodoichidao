<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/slide.css" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <title>@section('page-title')
        @show</title>
</head>
<body>
<img src="img/top-baner.png" width="100%" height="auto">
<nav class="navbar navbar-my">
    <a href="javascript:actionNav()">
        <i class="fa fa-bars"></i>
    </a>
</nav>
<div class="main">
    <div id="mySidenav" class="sidenav">
        <div class="left-head">
            CÔNG VIỆC
        </div>
        <div class="list-menu">
            <div class="cate-menu">NGƯỜI DÙNG</div>
            <ul>
                <li>Người sử dụng</li>
                <li>Ban - Đơn vị</li>
                <li>Người chủ trì</li>
            </ul>
            <div class="cate-menu">Ý KIẾN CHỈ ĐẠO</div>
            <ul>
                <li>Nguồn chỉ đạo</li>
                <li>Nội dung chỉ đạo</li>
            </ul>
            <div class="cate-menu">XỬ LÝ CÔNG VIỆC</div>
            <ul>
                <li>Công việc đầu mối</li>
                <li>Công việc phối hợp</li>
                <li>Công việc mới được giao</li>
                <li>Nguồn chỉ đạo</li>
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
    if (window.innerWidth < window.innerHeight || window.innerWidth < 800){
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

    function actionNav(){
        if (open){
            open = false;
            closeNav();
        }else{
            open = true;
            openNav();
        }
    }
</script>
</html>