@extends('layout1')

@section('page-title')
    Danh mục nhiệm vụ
@stop

@section('content')
    <style>
        #table {
            display: none;
        }
    </style>
    <div class="text-center title">Danh mục nhiệm vụ<span id="title-filter"></span></div>
    @if ($sourceinfo != false && !empty($sourceinfo))
        <div class="text-center">
            <div>Danh sách các nhiệm vụ theo nguồn chỉ dạo: <span style="color: red">{{$sourceinfo->name}}</span></div>

        </div>
    @endif
    @if ($conductor != false && !empty($conductor))
        <div class="text-center">
            <div>Danh sách các nhiệm vụ theo {{env('LD_FULL')}}: <span
                        style="color: #ff0000">{{$conductor->name}}</span></div>
        </div>
    @endif

    @if ($steering != false && !empty($steering))
        <div class="text-center">
            <div>Danh sách các nhiệm vụ theo nguồn chỉ dạo: <span style="color: red">{{$steering->code}}
                    - {{$steering->name}}</span></div>
        </div>
    @elseif(\App\Roles::accessAction($role, 'add'))
        {{ Html::linkAction('SteeringcontentController@edit', 'Thêm nhiệm vụ', array('id'=>0), array('class' => 'btn btn-my')) }}
    @endif
    <script language="javascript">
        function removebyid(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }
        }
    </script>

    {!! Form::open(array('route' => 'steeringcontent-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <div class="row note-contain">
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl2"></div>
            <a id="a2" class="a-status" href="javascript:filterStatus(2)"><span class="note-tx">Đã hoàn thành</span>(Đúng
                hạn, <span class="count-st" id="row-st-2"></span>)</a><br>
            <div class="note-cl cl3"></div>
            <a id="a3" class="a-status" href="javascript:filterStatus(3)"><span class="note-tx">Đã hoàn thành</span>(Quá
                hạn, <span class="count-st" id="row-st-3"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl1"></div>
            <a id="a1" class="a-status" href="javascript:filterStatus(1)"><span class="note-tx">Đang thực hiện</span>(Trong
                hạn, <span class="count-st" id="row-st-1"></span>)</a><br>
            <div class="note-cl cl4"></div>
            <a id="a4" class="a-status" href="javascript:filterStatus(4)"><span class="note-tx">Đang thực hiện</span>(Quá
                hạn, <span class="count-st" id="row-st-4"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl5"></div>
            <a id="a5" class="a-status" href="javascript:filterStatus(5)"><span class="note-tx">Nhiệm vụ sắp hết hạn(7 ngày)</span>
                (<span class="count-st" id="row-st-5"></span>)</a><br>
            <div class="note-cl cl6"></div>
            <a id="a6" class="a-status" href="javascript:filterStatus(6)"><span
                        class="note-tx">Nhiệm vụ đã bị hủy</span> (<span class="count-st" id="row-st-6"></span>)</a>
        </div>
    </div>
    <div>
        <div class="pull-right">
        <span><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="table"
                 href="javascript:exportExcel()"><span class="hidden-xs hidden-sm">Xuất ra </span>Excel</a></span>
            <span><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="table"
                     href="javascript:exportExcel(null,null,'pdf')"><span class="hidden-xs hidden-sm">Xuất ra </span>PDF</a></span>
        </div>
    </div>
    <div class="total-nv">(<span class="hidden-xs hidden-sm">Tổng số: </span>{{count($lst)}} nhiệm vụ)</div>

    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th class="hidden"></th>
            <th style="width: 15px"></th>
            <th style="min-width: 150px">Tên nhiệm vụ<br><input name="tennhiemvu" type="text"></th>
            <th style="min-width: 90px">Đv/cn đầu mối<input name="daumoi" type="text"></th>
            <th class="hidden" style="min-width: 100px">Đv/cn phối hợp<br><input name="phoihop" type="text"></th>
            <th style="width: 110px">Nội dung công việc<br><input name="ykien" type="text"></th>
            <th style="min-width: 130px">Tiến độ triển khai<br><input name="tinhhinhthuchien" type="text"></th>
            <th style="width: 130px">{{env('LDCD')}}<br><input name="conductornote" type="text"></th>
            <th style="width: 65px">{{env('LD_SHORT')}}<br><input type="text" id="conductor"></th>
            <th style="min-width: 50px">Hạn HT<br><input type="text" name="thoihan" class="datepicker"></th>
            <th class=" hidden">Trạng thái</th>
            <th style="width: 100px">Người theo dõi<br><input name="nguoitheodoi" type="text"></th>
            @if(\App\Roles::accessAction($role, 'edit'))
                <th class=" td-action"></th>
            @endif
            @if(\App\Roles::accessAction($role, 'trans'))
                <th class=" td-action"></th>
            @endif
            @if(\App\Roles::accessAction($role, 'delete'))
                <th class=" td-action"></th>
            @endif
            <th class=" hidden"><input type="text" id="filter-status"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $idx=>$row)
            <?php
            $st = 1;
            if ($row->status == 1) {
                if ($row->deadline == "" || $row->complete_time <= $row->deadline) {
                    $st = 2;
                } else {
                    $st = 3;
                }
            } else if ($row->status == -1) {
                $st = 6;
            } else if ($row->deadline == "") {
                $st = 1;
            } else {
                if (date('Y-m-d') > $row->deadline) {
                    $st = 4;
                } else if (date('Y-m-d', strtotime("+7 day")) > $row->deadline) {
                    $st = 5;
                } else {
                    $st = 1;
                }
            }
            $name_stt = array();
            $name_stt[1] = "Đang thực hiện (trong hạn)";
            $name_stt[2] = "Đã hoàn thành (đúng hạn)";
            $name_stt[3] = "Đã hoàn thành (quá hạn)";
            $name_stt[4] = "Đang thực hiện (quá hạn)";
            $name_stt[5] = "Sắp hết hạn (7 ngày)";
            $name_stt[6] = "Bị hủy";
            ?>

            <tr class="row-export row-st-{{$st}}" id="row-{{$row->id}}" deadline="{{$row->deadline}}">
                <td class="hidden id-export">{{$row->id}}</td>
                <td>{{$idx + 1}}</td>
                <td title="Xem thông tin chi tiết nhiệm vụ" class="click-detail"
                    onclick="showDetail({{$row->id}})"> {{\App\Utils::strunc($row->content, 200)}} </td>
                <td onclick="javascript:showunit({{$idx}})">
                    <ul class="unit-list" id="unit-list{{$idx}}">
                        @php ($n = 0)
                        @foreach($units = explode(',', $row->unit) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = ($i != "");
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                                $val = $unit[$spl[1]];
                                $n++;
                            } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                                $val = $user[$spl[1]];
                                $n++;
                            } else {
                                $validate = false;
                                $val = $i;
                            }
                            ?>
                            @if($validate)
                                @if ($loop->iteration < 3)
                                    <li> • {{$val}}</li>
                                @else
                                    <li class="more"> • {{$val}}</li>
                                @endif
                            @endif
                        @endforeach
                        @if ($n > 2)
                            <li class="more-link" hide="1"><a name="more-link-{{$idx}}">[+] Xem thêm</a></li>
                        @endif
                    </ul>
                </td>
                @if(\App\Roles::accessAction($role, 'note') && \App\Roles::accessRow($role, $row->manager))
                    <td id="unit-note-{{$row->id}}" data-id="{{$row->id}}"
                        class="unit-update ac-update"> {{\App\Utils::strunc($row->unitnote)}}</td>
                @else
                    <td id="unit-note-{{$row->id}}" data-id="{{$row->id}}"
                        class="unit-view ac-view"> {{\App\Utils::strunc($row->unitnote)}}</td>
                @endif

                @if(\App\Roles::accessAction($role, 'status') && \App\Roles::accessRow($role, $row->manager))
                    <td id="progress-{{$row->id}}" data-id="{{$row->id}}"
                        data-deadline="{{ ($row->steer_time != '')?Carbon\Carbon::parse($row->steer_time)->format('d/m/y'):'' }}"
                        class="progress-update ac-update"> {{\App\Utils::strunc($row->progress)}}</td>
                @else
                    <td id="progress-{{$row->id}}" data-id="{{$row->id}}"
                        class="progress-view ac-view"> {{\App\Utils::strunc($row->progress)}}</td>
                @endif

                @if(\App\Roles::accessAction($role, 'conductornote') && \App\Roles::accessRow($role, $row->manager))
                    <td id="conductor-note-{{$row->id}}" data-id="{{$row->id}}"
                        class="conductor-update ac-update"> {{\App\Utils::strunc($row->conductornote)}}</td>
                @else
                    <td id="conductor-note-{{$row->id}}" data-id="{{$row->id}}"
                        class="conductor-view ac-view"> {{\App\Utils::strunc($row->conductornote)}}</td>
                @endif

                <td class="hidden" onclick="javascript:showfollow({{$idx}})">
                    <ul class="unit-list" id="follow-list{{$idx}}">
                        @php ($n = 0)
                        @foreach($units = explode(',', $row->follow) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = ($i != "");
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                                $validate = true;
                                $val = $unit[$spl[1]];
                                $n++;
                            } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                                $validate = true;
                                $val = $user[$spl[1]];
                                $n++;
                            } else {
                                $validate = false;
                                $val = $i;
                            }
                            ?>
                            @if($validate)
                                @if ($loop->iteration < 3)
                                    <li> • {{$val}}</li>
                                @else
                                    <li class="more"> • {{$val}}</li>
                                @endif
                            @endif
                        @endforeach
                        @if ($n > 2)
                            <li class="more-link" hide="1"><a name="more-link-{{$idx}}">[+] Xem thêm</a></li>
                        @endif
                    </ul>
                </td>
                <td class="text-center">
                    <?php $arrConductor = explode(',', $row->conductor)?>
                    @foreach($arrConductor as $idx => $cd)
                            {!! isset($dtconductor[$cd])?$dtconductor[$cd]:'' !!} {!!$idx < count($arrConductor) - 1?'<br><br>':'' !!}
                    @endforeach
                </td>
                <td class=""> {{ ($row->deadline != '')?Carbon\Carbon::parse($row->deadline)->format('d/m/y'):'' }}</td>
                <td class="hidden">{{$name_stt[$st]}}</td>
                <td>{{isset($user[$row->manager])?$user[$row->manager]:''}}</td>
                @if(\App\Roles::accessAction($role, 'edit'))
                    <td class="">
                        @if(\App\Roles::accessRow($role, $row->manager))
                            <a href="{{$_ENV['ALIAS']}}/steeringcontent/update?id={{$row->id}}"><img height="20"
                                                                                                     border="0"
                                                                                                     src="{{$_ENV['ALIAS']}}/img/edit.png"
                                                                                                     title="Chỉnh sửa nhiệm vụ"></a>
                        @endif
                    </td>
                @endif
                @if(\App\Roles::accessAction($role, 'trans'))
                    <td class="">
                        @if(\App\Roles::accessRow($role, $row->manager))
                            <a href="javascript:showTranfer('{{$row->id}}', '{{$row->content}}')"><img
                                        title="Chuyển nhiệm vụ"
                                        height="20" border="0"
                                        src="{{$_ENV['ALIAS']}}/img/tranfer.png"></a>
                        @endif
                    </td>
                @endif
                @if(\App\Roles::accessAction($role, 'delete'))
                    <td class="">
                        @if(\App\Roles::accessRow($role, $row->manager))
                            <a href="javascript:removebyid('{{$row->id}}')"><img height="20" border="0"
                                                                                 src="{{$_ENV['ALIAS']}}/img/delete.png"
                                                                                 title="Xóa nhiệm vụ"></a>
                        @endif
                    </td>
                @endif
                <td class=" hidden">{{$st}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        <span><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="table"
                 href="javascript:exportExcel()"><span>Xuất ra Excel</span></a></span>
        <span><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="table"
                 href="javascript:exportExcel(null,null,'pdf')"><span>Xuất ra PDF</span></a></span>
    </div>

    <div id="modal-tranfer" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chuyển nhiệm vụ</h4>
                </div>
                <div class="modal-body" style="padding-top: 10px !important; padding-bottom: 50px !important;">
                    <div id="content-tranfer" style="padding-bottom: 10px"></div>
                    {!! Form::open(array('route' => 'steering-tranfer', 'id' => 'form-tranfer', 'files'=>'true')) !!}
                    <input id="sid" type="hidden" name="sid">
                    <div class="form-group from-inline">
                        <label>Người tiếp nhận</label>
                        <select class="js-example-basic-single js-states form-control" name="receiver" id="receiver"
                                required>
                            <option value="0"></option>
                            @foreach($datauser as $u)
                                @if($u->group != 4)
                                    <option id="reciever-{{$u->id}}" value="{{$u->id}}">{{$u->fullname}}
                                        ({{$u->username}})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group from-inline">
                        <label>Ghi chú</label>
                        <textarea name="note" id="tranfer-note" rows="2" class="form-control"></textarea>
                    </div>
                    <input class="btn btn-my pull-right" type="submit" value="Xác nhận chuyển">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        var table = "";
        var current_date = "{{date('d/m/y')}}";

        function showTranfer(id, content) {
            $("#content-tranfer").html("\"" + content + "\"")
            $("#modal-tranfer").modal("show");
            $("#sid").val(id);
        }


        function getDateDiff(time1, time2) {
            var str1 = time1.split('/');
            var str2 = time2.split('/');

            var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            var date1 = new Date(str1[2], str1[1] - 1, str1[0]);
            var date2 = new Date(str2[2], str2[1] - 1, str2[0]);

            var diffDays = parseInt((date1 - date2) / (1000 * 60 * 60 * 24));

            return diffDays;
        }


        function resetFormTranfer() {
            $("#receiver").val("");
            $("#tranfer-note").val("");
            $("#content-tranfer").html("");
        }

        function reCount() {
            reloadDataExport();
            $(".count-st").each(function () {
                $(this).html($('.' + $(this).attr('id')).length);
            });
        }

        function showunit(unit) {
            if ($("#unit-list" + unit + " .more-link").attr("hide") == 1) {
                $("#unit-list" + unit + " .more").show();
                $("#unit-list" + unit + " .more-link a").text("[-] Thu gọn");
                $("#unit-list" + unit + " .more-link").attr("hide", 0);
            } else {
                $("#unit-list" + unit + " .more").hide();
                $("#unit-list" + unit + " .more-link a").text("[+] Xem thêm");
                $("#unit-list" + unit + " .more-link").attr("hide", 1);
            }

        }
        function showfollow(unit) {

            if ($("#follow-list" + unit + " .more-link").attr("hide") == 1) {
                $("#follow-list" + unit + " .more").show();
                $("#follow-list" + unit + " .more-link a").text("[-] Thu gọn");
                $("#follow-list" + unit + " .more-link").attr("hide", 0);
            } else {
                $("#follow-list" + unit + " .more").hide();
                $("#follow-list" + unit + " .more-link a").text("[+] Xem thêm");
                $("#follow-list" + unit + " .more-link").attr("hide", 1);
            }

        }

        function reStyleRow(id, status, time_log) {
            var time_split = time_log.split("/");
            var time = time_split[2] + "-" + time_split[1] + "-" + time_split[0];
            if (status == "-1") {
                $("#row-" + id).attr('class', 'row-st-6');
            } else if (status == "1") {
                if (time <= $("#row-" + id).attr('deadline')) {
                    $("#row-" + id).attr('class', 'row-st-2');
                } else {
                    $("#row-" + id).attr('class', 'row-st-3');
                }
            }
        }

        $(document).ready(function () {
            $(".js-example-basic-single").select2({
                placeholder: "Chọn người tiếp nhận"
            });
            reCount();

            //Chuyen nhiem vu
            $("#form-tranfer").submit(function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                var receiver = $("#receiver").val();
                if (receiver == "0") {
                    alert("Vui lòng chọn người nhận nhiệm vụ!");
                    return;
                }
                var sid = $("#sid").val();
                $(".loader").show();
                var url = $(this).attr("action");
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (result) {
                        $(".loader").hide();
                        console.log(result);
                        alert("Anh chị đã chuyển thành công nhiệm vụ " +
                            $("#content-tranfer").html() + " cho " +
                            $("#reciever-" + receiver).html());
                        $("#modal-tranfer").modal("hide");
                        resetFormTranfer();
                        $("#row-" + sid).remove();
                        oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                        table.draw();
                        reCount();
                        oSettings[0]._iDisplayLength = 20;
                        table.draw();
                    },
                    error: function () {
                        alert("Xảy ra lỗi nội bộ");
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
            //End Chuyen nhiem vu
            // DataTable
            table = $('#table').DataTable({
                autoWidth: false,
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{$_ENV['ALIAS']}}/js/datatables/Vietnamese.json"
                },
            });

            $('#table').on('page.dt', function () {
                var info = table.page.info();
                createCookie("filter:current_page", info.page);
            });
            $(".loader").hide();
            $("#table").show();
            var oSettings = table.settings();

            table.columns().every(function () {

                var that = this;
                $('input', this.header()).on('keyup change changeDate', function () {
                    if (that.search() !== this.value) {

                        createCookie("filter:" + this.name, this.value);

                        that.search(this.value).draw();
                        oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                        table.draw();
                        if (this.id != "filter-status") {
                            reCount();
                        } else {
                            reloadDataExport();
                        }
                        oSettings[0]._iDisplayLength = 20;
                        table.draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                        oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                        table.draw();
                        reCount();
                        oSettings[0]._iDisplayLength = 20;
                        table.draw();
                    }
                });
            });


            @if (Session::has('revertfilter') && Session::get('revertfilter') == 1)
                     $("#table thead input").each(function (index, element) {
                if ($(element).attr("id") != "filter-status")
                    $(element).val(readCookie("filter:" + $(element).attr("name"))).trigger('change');
            })
            if (readCookie("scroll")) {
                $(document).scrollTop(readCookie("scroll"));
            }
            if (readCookie("filter:current_page")) {
                $(".loader").show();
                setTimeout(function () {
                    table.page(parseInt(readCookie("filter:current_page"))).draw('page');
                    $(".loader").hide();
                }, 500);
            }

            @else
                resetcookiefiter();
            @endif


        });

        //loc theo trang thai
        function filterStatus(status) {
            $(".a-status").css('font-weight', 'normal');
            $("#a" + status).css('font-weight', 'bold');
            $("#filter-status").val(status);
            $("#filter-status").trigger("change");
        }
        // loc theo loai nguon
        function filterTypeSource(type, name) {
            highlightSourceType(type);
            $("#filter-type").val(type + "|");
            $("#filter-type").trigger("change");
            $("#title-filter").html(" (theo " + name + ")")
        }

        function resetFromUnitNote() {
            $("#unit-note").val("");
            $("#unit_time").val(current_date);
            $("input[name=pr_status][value='0']").prop('checked', true);
            $("#input-file-note").hide();
            $('input[name=file]').val("");
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
        window.onscroll = function () {
            createCookie('scroll', $(document).scrollTop());
        };

    </script>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop
