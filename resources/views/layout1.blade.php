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

    <link rel="stylesheet" type="text/css"
          href="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/css/buttons.bootstrap.min.css"/>

    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/JSZip-2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/pdfmake-0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="{{$_ENV['ALIAS']}}/js/datatables/pdfmake-0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/DataTables-1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.flash.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript"
            src="{{$_ENV['ALIAS']}}/js/datatables/Buttons-1.2.4/js/buttons.print.min.js"></script>

    {{--<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>--}}
    <script src="{{$_ENV['ALIAS']}}/js/bootstrap-datepicker.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/datepicker.css" rel="stylesheet">


    <link href="{{$_ENV['ALIAS']}}/css/select2.css" rel="stylesheet"/>
    <script src="{{$_ENV['ALIAS']}}/js/select2.js"></script>

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
                        <li class="{{ substr(\Request::path(), 0, strlen($nd->path)) === $nd->path? 'active' : '' }}"><a
                                    href="{{$_ENV['ALIAS']}}/{{$nd->path}}">{{$nd->name}}</a></li>
                    @endforeach
                </ul>
            @endif
            @if(\App\Roles::accessView('steeringcontent'))
                <div class="left-head"><a href="{{env('ALIAS') == '' ? '/':env('ALIAS')}}"
                                          style="color: #43aa76 !important;">{{env('MENU_NV')}}</a></div>
                <ul>
                    <li><a href="#">{{env('SRC_FILTER')}}</a></li>
                    <ul style="padding-left: 20px">
                        @foreach(\App\Utils::listTypeSource() as $type)
                            <li class="s-type {{(strpos(\Request::path(), "steeringcontent")  !== false && isset($parram) && $parram == 't'.$type->id)? 'active' : ''}}"
                                id="s-type-{{$type->id}}"><a
                                        href="{{$_ENV['ALIAS']}}/steeringcontent?type={{$type->id}}">{{$type->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <li><a href="#">{{env('LD_FULL')}}</a></li>
                    <ul style="padding-left: 20px">
                        @foreach(\App\Utils::listConductor() as $conductor)
                            <li class="s-type {{(strpos(\Request::path(), "steeringcontent")  !== false  && isset($parram) && $parram == 'c'.$conductor->id)? 'active' : ''}}">
                                <a
                                        href="{{$_ENV['ALIAS']}}/steeringcontent?conductor={{$conductor->id}}">{{$conductor->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </ul>
            @endif
            <?php $menu_xlnv = \App\Roles::getMenu('XLNV'); ?>
            @if(count($menu_xlnv) > 0)
                <div class="left-head">NHIỆM VỤ CỦA ĐƠN VỊ</div>
                <ul>
                    @foreach($menu_xlnv as $xl)
                        <li class="{{ (strpos(\Request::path(), $xl->path)  !== false )? 'active' : '' }}"><a
                                    href="{{$_ENV['ALIAS']}}/{{$xl->path}}">{{$xl->name}}</a></li>
                    @endforeach
                </ul>
            @endif
            <?php $menu_bc = \App\Roles::getMenu('BC'); ?>
            @if(count($menu_bc) > 0)
                <div class="left-head">THỐNG KÊ BÁO CÁO</div>
                <ul>
                    @foreach($menu_bc as $xl)
                        <li class="{{ (\Request::path() == $xl->path) ? 'active' : '' }}"><a
                                    href="{{$_ENV['ALIAS']}}/{{$xl->path}}">{{$xl->name}}</a></li>
                    @endforeach
                </ul>
            @endif
            <div class="left-head">THÔNG TIN HỖ TRỢ</div>
            <ul class="mnu-hotro">
                <li>Mr. Hà: <strong>0904.069.966</strong> (đầu mối)</li>
                <li>Mr. Tiến: <strong>0989.268.118</strong></li>
                <li>Mr. Tú: <strong>0972.541.665</strong></li>
                <li>Email: <strong>theodoichidao@moet.gov.vn</strong></li>
                <li><a style="color: #337ab7 !important; font-weight: bold" href="{{$_ENV['ALIAS']}}/file/hdsd.pdf"
                       download>Tải về hướng dẫn sử dụng</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        @yield('content')
    </div>
    <div id="modal-edit-progress" tabindex="-1" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa tiến độ</h4>
                </div>
                <div class="modal-body" style="padding-top: 0px !important;">
                    {!! Form::open(array('route' => 'edit-progress', 'id' => 'form-edit-progress', 'files'=>'true')) !!}
                    <input id="edit_steering_id" type="hidden" name="edit_steering_id">
                    <input id="edit_progress_id" type="hidden" name="edit_progress_id">
                    <input id="edit_process_deadline" type="hidden" name="edit_process_deadline">
                    <div class="form-group from-inline">
                        <label>Ghi chú tiến độ</label>
                        <textarea name="edit_pr_note" required id="edit_pr_note" rows="2"
                                  class="form-control"></textarea>
                    </div>
                    <div class="form-group form-inline">
                        <label>Ngày cập nhật</label>
                        <input name="edit_time_log" type="text" class="datepicker form-control" id="edit_progress_time"
                               required value="">
                        <input class="btn btn-my pull-right" type="submit" value="Lưu">&nbsp;
                        <button type="button" data-dismiss="modal" class="btn btn-default pull-right">Hủy</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
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
    @if (isset($role))
        <div id="modal-progress" class="modal fade" role="dialog">
            <div class="modal-dialog" style="min-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Theo dõi tiến độ</h4>
                    </div>
                    <div class="modal-body" style="padding-top: 0px !important;">
                        @if(\App\Roles::accessAction($role, 'status'))
                            {!! Form::open(array('route' => 'add-progress', 'id' => 'form-progress', 'files'=>'true')) !!}
                            <input id="steering_id" type="hidden" name="steering_id">
                            <div class="form-group from-inline">
                                <label>Ghi chú tiến độ</label>
                                <textarea name="note" required id="pr-note" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group  from-inline">
                                <label>Tình trạng</label>
                                <input type="radio" name="pr_status" value="0"> Nhiệm vụ Đang thực hiện&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="pr_status" value="1"> Nhiệm vụ đã hoàn thành&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="pr_status" value="-1"> Nhiệm vụ bị hủy
                            </div>
                            <div class="form-group form-inline" id="input-file" style="display: none">
                                <label style="float: left">File đính kèm:</label>
                                <input type="file" name="file">
                            </div>
                            <div class="form-group form-inline">
                                <label>Ngày cập nhật</label>
                                <input name="time_log" type="text" class="datepicker form-control" id="progress_time"
                                       required value="{{date('d/m/y')}}">
                                <input class="btn btn-my pull-right" type="submit" value="Lưu">
                            </div>
                            {!! Form::close() !!}
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nội dung</th>
                                <th>Người cập nhật</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody id="table-progress"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-unit-note" class="modal fade" role="dialog">
            <div class="modal-dialog" style="min-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ý kiến của đơn vị chủ trì/phối hợp</h4>
                    </div>
                    <div class="modal-body" style="padding-top: 0px !important;">
                        @if(\App\Roles::accessAction($role, 'note'))
                            {!! Form::open(array('route' => 'add-unit-note', 'id' => 'form-unit-note', 'files'=>'true')) !!}
                            <input id="steering_id_note" type="hidden" name="steering_id">
                            <div class="form-group from-inline">
                                <label>Nội dung ý kiến</label>
                                <textarea name="note" required id="unit-note" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group form-inline hidden">
                                <label>Ngày cập nhật</label>
                                <input name="time_log" type="text" class="datepicker form-control" id="unit_time"
                                       required value="{{date('d/m/y')}}">
                            </div>
                            <div class="form-group form-inline">
                                <input class="btn btn-my pull-right" type="submit" value="Lưu">
                            </div>
                            {!! Form::close() !!}
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nội dung</th>
                                <th>Người cập nhật</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody id="table-unit-note"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-conductor-note" class="modal fade" role="dialog">
            <div class="modal-dialog" style="min-width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{env('LDCD')}}</h4>
                    </div>
                    <div class="modal-body" style="padding-top: 0px !important;">
                        @if(\App\Roles::accessAction($role, 'conductornote'))
                            {!! Form::open(array('route' => 'add-conductor-note', 'id' => 'form-conductor-note', 'files'=>'true')) !!}
                            <input id="steering_id_conductor" type="hidden" name="steering_id">
                            <div class="form-group from-inline">
                                <label>Nội dung ý kiến</label>
                                <textarea name="note" required id="conductor-note" rows="2"
                                          class="form-control"></textarea>
                            </div>
                            <div class="form-group form-inline hidden">
                                <label>Ngày cập nhật</label>
                                <input name="time_log" type="text" class="datepicker form-control" id="conductor_time"
                                       required value="{{date('d/m/y')}}">
                            </div>
                            <div class="form-group form-inline">
                                <input class="btn btn-my pull-right" type="submit" value="Lưu">
                            </div>
                            {!! Form::close() !!}
                        @endif
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nội dung</th>
                                <th>Người cập nhật</th>
                                <th>Thời gian</th>
                            </tr>
                            </thead>
                            <tbody id="table-conductor-note"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
        document.getElementById("content").style.marginLeft = "250px";
    }
    function closeNav() {
        document.getElementById("mySidenav").style.left = "-250px";
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

    /*
     * Chỉnh sửa tiến độ
     */
    function formatToDMY(date) {
        var tmp = date.split("-");
        return tmp[2] + "/" + tmp[1] + "/" + tmp[0].substr(2, 2);
    }

    function editDetailProgress(obj) {
//            $("#modal-progress").modal("hide");
        resetFormEdit();
        $("#edit_steering_id").val(parseInt($(obj).data("steering-id")));
        $("#edit_progress_id").val(parseInt($(obj).data("progress-id")));
        $("#edit_process_deadline").val($.trim($(obj).data("deadline")));
        $("#edit_pr_note").val($.trim($(obj).data("note")));
        $("#edit_progress_time").val($.trim($(obj).data("time")));
    }

    function resetFormEdit() {
        $("#edit_steering_id").val("");
        $("#edit_progress_id").val("");
        $("#edit_process_deadline").val("");
        $("#edit_pr_note").val("");
        $("#edit_progress_time").val("");
    }

    $("#form-edit-progress").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var note = $("#edit_pr_note").val();
        var steering_id = $("#edit_steering_id").val();
        var progress_id = $("#edit_progress_id").val();
//                var status = $('input[name="pr_status"]:checked').val()
        var time_log = $("#edit_progress_time").val();
        var time_deadline = $("#edit_process_deadline").val();

        datediff = getDateDiff(time_log, time_deadline);
        console.log("#date: " + time_log + "-" + time_deadline + "=" + datediff);

        if (datediff < 0) {
            alert("Ngày cập nhật không hợp lệ!");
            return false;
        }

        $(".loader").show();
        var url = $(this).attr("action");

        console.log(url);
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: false,
            success: function (result) {
                console.log(result);
                $(".loader").hide();
                $("#modal-edit-progress").modal("hide");
                if (result.update) {
                    $("#progress-" + steering_id).html(note)
                }
                resetFromProgress();
                resetFormEdit();
                $("#form-progress").show();
                showDetailProgress(steering_id, time_deadline)
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    /*
     * Kết thúc Chỉnh sửa tiến độ
     */

    function highlightSourceType(id) {
        $(".s-type").removeClass('active');
        $("#s-type-" + id).addClass('active');
    }

    function createCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    function resetcookiefiter() {
        // Get an array of cookies
        var arrSplit = document.cookie.split(";");

        for (var i = 0; i < arrSplit.length; i++) {
            var cookie = arrSplit[i].trim();
            var cookieName = cookie.split("=")[0];

            // If the prefix of the cookie's name matches the one specified, remove it
            if (cookieName.indexOf("filter:") === 0) {

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

        if (filetype != 'pdf') filetype = 'xlsx';

        console.log(data_export);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{$_ENV['ALIAS']}}/report/exportsteering",
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
                window.location.href = "{{$_ENV['ALIAS']}}" + result.file;
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
            url: "{{$_ENV['ALIAS']}}/api/steering?id=" + id,
            success: function (result) {
                $(".loader").hide();
                var html_table = "";
                console.log(result);
                html_table += "<div class='alert alert-info'>" + result["content"] + "</div>";
                html_table += "<dl class=\"dl-horizontal\">";
                html_table += "<dt>Người tạo:</dt><dd>" + result['created_by'] + "</dd>";
                html_table += "<dt>Ngày tạo:</dt><dd>" + result['created_at'] + "</dd>";
                html_table += "<dt>Người theo dõi:</dt><dd>" + result['manager'] + "</dd>";
                if (result["conductor"][1] !== "undefined ") {
                    html_table += "<dt>{{env('LD_MEDIUM')}}:</dt><dd>" + result["conductor"][1] + "</dd>";
                }

                html_table += "<dt>Ngày chỉ đạo:</dt><dd>" + result["steer_time"] + "</dd>";

                if (Object.keys(result["steeringSourceNotes"]).length > 0) {
                    html_table += "<dt>{{env('SRC_UC')}}:</dt><dd>";
                    $.each(result["steeringSourceNotes"], function (key, value) {
                        if (value != null) {
                            html_table += value;
                            if (key < result["steeringSourceNotes"].length - 1) {
                                html_table += ", ";
                            }
                        }
                    });
                    html_table += "<dd>";
                }

                html_table += "<dt>Đơn vị đầu mối:</dt><dd>";
                $.each(result["unit"], function (index, element) {
                    html_table += element.name;
                    if (index < result["unit"].length - 1) {
                        html_table += ", ";
                    }
                });
                html_table += "<dd>";

                if (result["follow"].length > 0) {
                    html_table += "<dt>Đơn vị phối hợp:</dt><dd>";
                    $.each(result["follow"], function (index, element) {
                        html_table += element.name;
                        if (index < result["follow"].length - 1) {
                            html_table += ", ";
                        }
                    });
                    html_table += "<dd>";
                } else {
                    html_table += "<dt>Đơn vị phối hợp:</dt><dd>Không có</dd>";
                }

//                html_table += "<dt>Phân loại:</dt><dd>" + (result["priority"][1] === undefined)?'':result["priority"][1] + "</dd>";
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
<script>
    $(document).ready(function () {
        $(".loader").hide();
    });
    $('input:radio[name=pr_status]').change(function () {
        var stt = $('input:radio[name=pr_status]:checked').val();
        var nt = $("#pr-note").val();
        if (stt == "1") {
            $("#input-file").show();
//            $("#st-file").prop("required", true);
            if (nt == "") {
                $("#pr-note").val("Đã hoàn thành");
            }
        } else {
            $("#input-file").hide();
//            $("#st-file").prop("required", false);
        }
    });
</script>

<!-- TienCH script show modal progress -->
<script>
    function showDetailProgress(id, deadline) {
        resetFromProgress();
        $(".loader").show();
        $("#steering_id").val(id);
        $.ajax({
            url: "{{$_ENV['ALIAS']}}/api/progress?s=" + id,
            success: function (result) {
                console.log(result);
                $(".loader").hide();
                $("#process-deadline").val(deadline);
                var html_table = "";
                for (var i = 0; i < result.length; i++) {
                    var r = result[i];

                    var time = current_date;
                    if (r.time_log != null) {
                        var time = formatToDMY(r.time_log);
                    }
                    html_table += "<tr>";
                    html_table += "<td>" + r.note
                    if (r.file_attach != null) {
                        html_table += " (<a href='{{$_ENV['ALIAS']}}/file/status_file_" + r.id + "." + r.file_attach + "'>File đính kèm</a>)"
                    }
                    html_table += "</td>"
                    html_table += "<td>" + r.created + "</td>"
                    html_table += "<td>" + r.time_log + "</td>"
                    html_table += "<td>" + "<a type='button' data-toggle='modal' data-steering-id='" + id + "' " +
                        "data-progress-id='" + r.id + "' " +
                        "data-deadline='" + deadline + "' data-note='" + r.note + "' data-time='" + time + "'  " +
                        "onclick='editDetailProgress(this)' " +
                        "href='#modal-edit-progress' class='edit-progress'>" +
                        "<img height='20' border='0' src='/img/edit.png' title='Chỉnh sửa nhiệm vụ'/></a>" + "</td>"
                    html_table += "</tr>"
                }
                $("#table-progress").html(html_table);
                $("#modal-progress").modal("show");
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
                $(".loader").hide();
            }
        });
    }

    function showDetailUnitNote(id) {
        resetFromUnitNote();
        $(".loader").show();
        $("#steering_id_note").val(id);
        $.ajax({
            url: "{{$_ENV['ALIAS']}}/api/unitnote?s=" + id,
            success: function (result) {
                $(".loader").hide();
                var html_table = "";
                for (var i = 0; i < result.length; i++) {
                    var r = result[i];
                    html_table += "<tr>";
                    html_table += "<td>" + r.note
                    if (r.file_attach != null) {
                        html_table += " (<a href='{{$_ENV['ALIAS']}}/file/unit_note_" + r.id + "." + r.file_attach + "'>File đính kèm</a>)"
                    }
                    html_table += "</td>"
                    html_table += "<td>" + r.created + "</td>"
                    html_table += "<td>" + r.time_log + "</td>"
                    html_table += "</tr>"
                }
                $("#table-unit-note").html(html_table);
                $("#modal-unit-note").modal("show");
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
                $(".loader").hide();
            }
        });
    }

    function showDetailConductorNote(id) {
        resetFromConductorNote();
        $(".loader").show();
        $("#steering_id_conductor").val(id);
        $.ajax({
            url: "{{$_ENV['ALIAS']}}/api/conductornote?s=" + id,
            success: function (result) {
                $(".loader").hide();
                var html_table = "";
                for (var i = 0; i < result.length; i++) {
                    var r = result[i];
                    html_table += "<tr>";
                    html_table += "<td>" + r.note + "</td>"
                    html_table += "<td class='text-center'>" + r.created + "</td>"
                    html_table += "<td class='text-center'>" + r.time_log + "</td>"
                    html_table += "</tr>"
                }
                $("#table-conductor-note").html(html_table);
                $("#modal-conductor-note").modal("show");
            },
            error: function () {
                alert("Xảy ra lỗi nội bộ");
                $(".loader").hide();
            }
        });
    }

    function resetFromProgress() {
        $("#pr-note").val("");
        $("#progress_time").val(current_date);
        $("input[name=pr_status][value='0']").prop('checked', true);
        $("#input-file").hide();
        $('input[name=file]').val("");
    }

    function resetFromUnitNote() {
        $("#unit-note").val("");
        $("#unit_time").val(current_date);
    }

    function resetFromConductorNote() {
        $("#conductor-note").val("");
        $("#conductor_time").val(current_date);
    }

    $(document).ready(function () {
        @if(isset($role))
        @if(\App\Roles::accessAction($role, 'status'))
        $(".progress-update").on("click", function () {
            showDetailProgress($(this).attr("data-id"))
        });
        @else
        $(".progress-view").on("click", function () {
            showDetailProgress($(this).attr("data-id"))
        });
        @endif

        @if(\App\Roles::accessAction($role, 'note'))
        $(".unit-update").on("click", function () {
            showDetailUnitNote($(this).attr("data-id"))
        });
        @else
        $(".unit-view").on("click", function () {
            showDetailUnitNote($(this).attr("data-id"))
        });
        @endif

        @if(\App\Roles::accessAction($role, 'conductornote'))
        $(".conductor-update").on("click", function () {
            showDetailConductorNote($(this).attr("data-id"))
        });
        @else
        $(".conductor-view").on("click", function () {
            showDetailConductorNote($(this).attr("data-id"))
        });
        @endif

        $("#form-progress").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var note = $("#pr-note").val();
            var steering_id = $("#steering_id").val();
            var status = $('input[name="pr_status"]:checked').val()
            var time_log = $("#progress_time").val();
            $(".loader").show();
            var url = $(this).attr("action");
            console.log(url);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function (result) {
                    console.log(result);
                    $(".loader").hide();
                    $("#modal-progress").modal("hide");
                    $("#progress-" + steering_id).html(note)
                    resetFromProgress();
                    reStyleRow(steering_id, status, time_log);
                },
                error: function () {
                    alert("Xảy ra lỗi nội bộ");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        $("#form-unit-note").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var note = $("#unit-note").val();
            var steering_id = $("#steering_id_note").val();
            var status = $('input[name="pr_status"]:checked').val()
            var time_log = $("#unit_time").val();
            $(".loader").show();
            var url = $(this).attr("action");
            console.log(url);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function (result) {
                    console.log(result);
                    $(".loader").hide();
                    $("#modal-unit-note").modal("hide");
                    console.log(steering_id + " : " + note);
                    $("#unit-note-" + steering_id).html(note)
                    resetFromUnitNote();
                    reStyleRow(steering_id, status, time_log);
                },
                error: function () {
                    alert("Xảy ra lỗi nội bộ");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $("#form-conductor-note").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var note = $("#conductor-note").val();
            var steering_id = $("#steering_id_conductor").val();
            $(".loader").show();
            var url = $(this).attr("action");
            console.log(url);
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                success: function (result) {
                    console.log(result);
                    $(".loader").hide();
                    $("#modal-conductor-note").modal("hide");
                    $("#conductor-note-" + steering_id).html(note)
                    resetFromConductorNote();
                },
                error: function () {
                    alert("Xảy ra lỗi nội bộ");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        @endif
    });
</script>
</html>