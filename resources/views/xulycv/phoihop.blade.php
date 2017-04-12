@extends('layout1')

@section('page-title')
    Nhiệm vụ phối hợp
@stop

@section('content')

    <div class="text-center title">Nhiệm vụ phối hợp</div>


    <div class="row note-contain">
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl2"></div><a id="a2" class="a-status" href="javascript:filterStatus(2)"><span class="note-tx">Đã hoàn thành</span>(Đúng hạn, <span class="count-st" id="row-st-2"></span>)</a><br>
            <div class="note-cl cl3"></div><a id="a3" class="a-status" href="javascript:filterStatus(3)"><span class="note-tx">Đã hoàn thành</span>(Quá hạn, <span class="count-st" id="row-st-3"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl1"></div><a id="a1" class="a-status" href="javascript:filterStatus(1)"><span class="note-tx">Đang thực hiện</span>(Trong hạn, <span class="count-st" id="row-st-1"></span>)</a><br>
            <div class="note-cl cl4"></div><a id="a4" class="a-status" href="javascript:filterStatus(4)"><span class="note-tx">Đang thực hiện</span>(Quá hạn, <span class="count-st" id="row-st-4"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl5"></div><a id="a5" class="a-status" href="javascript:filterStatus(5)"><span class="note-tx">Nhiệm vụ sắp hết hạn(7 ngày)</span> (<span class="count-st" id="row-st-5"></span>)</a><br>
            <div class="note-cl cl6"></div><a id="a6" class="a-status" href="javascript:filterStatus(6)"><span class="note-tx">Nhiệm vụ đã bị hủy</span> (<span class="count-st" id="row-st-6"></span>)</a>
        </div>
    </div>
    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th class="hidden"></th>
            <th style="width: 15px"></th>
            <th style="min-width: 150px">Tên nhiệm vụ<br><input type="text"></th>
            <th style="min-width: 100px">Đv/cn đầu mối<input type="text"></th>
            <th style="min-width: 130px">Tình hình thực hiện<br><input type="text"></th>
            <th style="min-width: 130px">Ý kiến của đơn vị<br><input type="text"></th>
            <th style="min-width: 100px">Đv/cn phối hợp<br><input type="text"></th>
            <th style="min-width: 100px">Nguồn chỉ đạo<br><input type="text"></th>
            <th style="width: 50px">Hạn HT<br><input type="text" class="datepicker"></th>
            <th class="hidden">Trạng thái</th>
            <th class="hidden"><input type="text" id="filter-status"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $idx=>$row)
            <?php
            $st = 1;
            if($row->status == 1){
                if ($row->deadline == "" || $row->complete_time < $row->deadline){
                    $st = 2;
                }else{
                    $st = 3;
                }
            }else if ($row->status == -1){
                $st = 6;
            }else if($row->deadline == ""){
                $st = 1;
            }else{
                if (date('Y-m-d') > $row->deadline){
                    $st = 4;
                }else if (date('Y-m-d',strtotime("+7 day")) > $row->deadline){
                    $st = 5;
                }else{
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
            <tr class="row-export row-st-{{$st}}">
                <td class="hidden id-export">{{$row->id}}</td>
                <td>{{$idx + 1}}</td>
                <td> {{$row->content}} </td>
                <td onclick="showunit({{$idx}})">
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
                <td id="progress-{{$row->id}}" data-id="{{$row->id}}" class="progress-view"> {{$row->progress}}</td>
                <td id="unit-note-{{$row->id}}" data-id="{{$row->id}}"
                    class="unit-update"> {{$row->unitnote}}</td>
                <td class="hidden-xs hidden-sm " onclick="showfollow({{$idx}})">
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
                <td class="hidden-xs hidden-sm "> @foreach(explode('|', $row->source) as $s)
                        <ul class="unit-list">
                            @if($s != '')
                                <li> {{ $s }} </li>
                            @endif
                        </ul>
                    @endforeach  </td>
                <td class="hidden-xs hidden-sm "> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/y') }}</td>
                <td class="hidden">{{$name_stt[$st]}}</td>
                <td class="hidden">{{$st}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        <span><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="table" href="javascript:exportExcel()"><span>Xuất ra Excel</span></a></span>
        <span class="panel-button"></span>
    </div>
    <div id="modal-progress" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Theo dõi tiến độ</h4>
                </div>
                <div class="modal-body">
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
                    <h4 class="modal-title">Ý kiến của đơn vị</h4>
                </div>
                <div class="modal-body" style="padding-top: 0px !important;">
                    {!! Form::open(array('route' => 'add-unit-note', 'id' => 'form-unit-note', 'files'=>'true')) !!}
                    <input id="steering_id_note" type="hidden" name="steering_id">
                    <div class="form-group from-inline">
                        <label>Ý kiến</label>
                        <textarea name="note" required id="unit-note" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="form-group form-inline">
                        <label>Ngày cập nhật</label>
                        <input name="time_log" type="text" class="datepicker form-control" id="unit_time"
                               required value="{{date('d/m/y')}}">
                        <input class="btn btn-my pull-right" type="submit" value="Lưu">
                    </div>
                    {!! Form::close() !!}
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
    <script>
        var current_date = "{{date('d/m/y')}}";
        function showDetailProgress(id) {
            $(".loader").show();
            $("#steering_id").val(id);
            $.ajax({
                url: "{{$_ENV['ALIAS']}}/api/progress?s=" + id,
                success: function (result) {
                    $(".loader").hide();
                    var html_table = "";
                    for (var i = 0; i < result.length; i++) {
                        var r = result[i];
                        html_table += "<tr>";
                        html_table += "<td>" + r.note
                        if (r.file_attach != null) {
                            html_table += " (<a href='{{$_ENV['ALIAS']}}/file/status_file_" + r.id + "." + r.file_attach + "'>File đính kèm</a>)"
                        }
                        html_table += "</td>"
                        html_table += "<td>" + r.created + "</td>"
                        html_table += "<td>" + r.time_log + "</td>"
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

        $(document).ready(function () {

            $( ".progress-view" ).on( "click", function() {
                showDetailProgress($( this ).attr("data-id"))
                console.log( "#ID: " + $( this ).attr("data-id") );
            });

            $(".unit-update").on("click", function () {
                showDetailUnitNote($(this).attr("data-id"))
            });


            reCount();
            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8],
                            modifier: {
                                page: 'all'
                            },
                            format: {
                                body: function (data, row, column, node) {

                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm,"").replace(/ +(?= )/g,'').replace(/&amp;/g,' & ').replace(/&nbsp;/g,' ').replace(/•/g,"\r\n•").replace(/\[\+\] Xem thêm/g,"").trim();

                                }
                            }
                        },
                        orientation: 'landscape',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                        },
                        text: 'Xuất ra PDF',
                    },
                ],
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{$_ENV['ALIAS']}}/js/datatables/Vietnamese.json"
                },
                "initComplete": function () {
                    $("#table_wrapper > .dt-buttons").appendTo("span.panel-button");
                }
            });

            var oSettings = table.settings();

            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change changeDate', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                        oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                        table.draw();
                        if (this.id != "filter-status") {
                            reCount();
                        }else{
                            reloadDataExport();
                        }
                        oSettings[0]._iDisplayLength=20;
                        table.draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                        oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                        table.draw();
                        reCount();
                        oSettings[0]._iDisplayLength=20;
                        table.draw();
                    }
                });
            });


        });

        function showunit(unit) {
            if($("#unit-list" + unit + " .more-link").attr("hide") == 1) {
                $("#unit-list" + unit + " .more").show();
                $("#unit-list" + unit + " .more-link a").text("[-] Thu gọn");
                $("#unit-list" + unit + " .more-link").attr("hide",0);
            } else {
                $("#unit-list" + unit + " .more").hide();
                $("#unit-list" + unit + " .more-link a").text("[+] Xem thêm");
                $("#unit-list" + unit + " .more-link").attr("hide",1);
            }

        }
        function showfollow(unit) {

            if($("#follow-list" + unit + " .more-link").attr("hide") == 1) {
                $("#follow-list" + unit + " .more").show();
                $("#follow-list" + unit + " .more-link a").text("[-] Thu gọn");
                $("#follow-list" + unit + " .more-link").attr("hide",0);
            } else {
                $("#follow-list" + unit + " .more").hide();
                $("#follow-list" + unit + " .more-link a").text("[+] Xem thêm");
                $("#follow-list" + unit + " .more-link").attr("hide",1);
            }

        }

        function reCount(){
            reloadDataExport();
            $(".count-st").each(function() {
                $(this).html($('.' + $(this).attr('id')).length);
            });
        }

        function resetFromProgress(){
            $("#pr-note").val("");
            $("#progress_time").val(current_date);
            $("input[name=pr_status][value='-2']").prop('checked', true);
            $("#form-progress").hide();
        }
        //loc theo trang thai
        function filterStatus(status){
            $(".a-status").css('font-weight', 'normal');
            $("#a" + status).css('font-weight', 'bold');
            $("#filter-status").val(status);
            $("#filter-status").trigger("change");
        }

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
        function resetFromUnitNote() {
            $("#unit-note").val("");
            $("#unit_time").val(current_date);
            $("input[name=pr_status][value='0']").prop('checked', true);
            $("#input-file-note").hide();
            $('input[name=file]').val("");
        }
    </script>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop