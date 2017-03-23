@extends('layout1')

@section('page-title')
    Danh mục nhiệm vụ
@stop

@section('content')

    <div class="text-center title">Danh mục nhiệm vụ</div>

    @if ($steering != false)
        <p><u>Nguồn chỉ đạo:</u> [{{$steering->code}}] - {{$steering->name}}</p>
    @endif
    @if(\App\Roles::accessAction(Request::path(), 'add'))
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
    <div class="row">
        <div class="col-xs-3"><div class="note-cl cl5"></div><span class="note-tx">Nhiệm vụ sắp hết hạn</span> (<span class="count-st" id="row-st-5"></span>)</div>
        <div class="col-xs-3"><div class="note-cl cl6"></div><span class="note-tx">Nhiệm vụ đã bị hủy</span> (<span class="count-st" id="row-st-6"></span>)</div>
    </div>
    <div class="row">
        <div class="row col-xs-6">
            <div class="label-note">Nhiệm vụ đã hoàn thành: </div>
            <div class=" col-xs-6">
                <div class="note-cl cl2"></div><span class="note-tx">Đúng hạn</span> (<span class="count-st" id="row-st-2"></span>)<br>
                <div class="note-cl cl3"></div><span class="note-tx">Quá hạn</span> (<span class="count-st" id="row-st-3"></span>)
            </div>
        </div>
        <div class="row col-xs-6">
            <div class="label-note">Nhiệm vụ chưa hoàn thành: </div>
            <div class=" col-xs-6">
                <div class="note-cl cl1"></div><span class="note-tx">Đang tiến hành</span> (<span class="count-st" id="row-st-1"></span>)<br>
                <div class="note-cl cl4"></div><span class="note-tx">Quá hạn</span> (<span class="count-st" id="row-st-4"></span>)
            </div>
        </div>
    </div>
    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th></th>
            <th> Tên nhiệm vụ<br><input type="text" style="width: 100%"></th>
            <th> Nguồn chỉ đạo<br><input type="text" style="max-width: 100px"></th>
            <th> Đơn vị đầu mối<input type="text" style="max-width: 100px"></th>
            <th> Đơn vị phối hợp<br><input type="text" style="width: 100%"></th>
            <th> Thời hạn HT<input type="text" class="datepicker" style="max-width: 80px"></th>
            <th> Tiến độ<br><input type="text" style="max-width: 100px"></th>
            @if(\App\Roles::checkPermission())
                <th class="td-action"></th>
                <th class="td-action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $idx=>$row)
            @if(\App\Roles::accessRow(Request::path(), $row->created_by))
            <?php
            $st = 1;
            if($row->status == 1){
                if ($row->complete_time < $row->deadline){
                    $st = 2;
                }else{
                    $st = 3;
                }
            }else if ($row->status == -1){
                $st = 6;
            }else{
                if (date('Y-m-d') < $row->deadline){
                    $st = 1;
                }else{
                    $st = 4;
                }
            }
            ?>

            <tr class="row-st-{{$st}}">
                <td>{{$idx + 1}}</td>
                <td> {{$row->content}} </td>
                <td> {{ $row->source }} </td>
                <td> {{ $unit[$row->unit] }} </td>
                <td>
                    @foreach(explode(',', $row->follow) as $i)
                        @if (isset($unit2[$i]))
                            {{$unit2[$i]}},
                        @endif
                    @endforeach
                </td>
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/Y') }}</td>
                <td id="progress-{{$row->id}}"> {{$row->progress}}
                    @if(\App\Roles::accessAction(Request::path(), 'status'))
                    <a href="javascript:showDetailProgress({{$row->id}})">Cập nhật</a>
                    @endif
                </td>
                {{--<td>--}}
                {{--@if($row->status === 1)--}}
                {{--<span class="label label-sm label-success"> Hoàn thành </span>--}}
                {{--@elseif($row->status === 0)--}}
                {{--<span class="label label-sm label-warning"> Chưa hoàn thành </span>--}}
                {{--@elseif($row->status === -1)--}}
                {{--<span class="label label-sm label-danger"> Hủy </span>--}}
                {{--@else--}}
                {{--<span class="label label-sm label-info"> Mới </span>--}}
                {{--@endif--}}
                {{--</td>--}}
                @if(\App\Roles::accessAction(Request::path(), 'edit'))
                    <td>
                        <a href="/steeringcontent/update?id={{$row->id}}"><img height="20" border="0"
                                                                               src="/img/edit.png"></a>
                    </td>
                @endif
                @if(\App\Roles::accessAction(Request::path(), 'delete'))
                    <td>
                        <a href="javascript:removebyid('{{$row->id}}')"><img height="20" border="0"
                                                                             src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div class="panel-button"></div>
    <div id="modal-progress" class="modal fade" role="dialog">
        <div class="modal-dialog"  style="min-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Theo dõi tiến độ</h4>
                </div>
                <div class="modal-body" style="padding-top: 0px !important;">
                    <form id="form-progress">
                        <input id="steering_id" type="hidden" name="steering_id">;
                        <div class="form-group from-inline">
                            <label>Ghi chú tiến độ</label>
                            <textarea name="note" required id="pr-note" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="form-group  from-inline">
                            <label>Tình trạng</label>
                            <input type="radio" name="pr_status" value="1">  Nhiệm vụ đã hoàn thành&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="pr_status" value="-1"> Nhiệm vụ bị hủy
                        </div>
                        <div class="form-group form-inline">
                            <label>Ngày cập nhật</label>
                            <input name="time_log" type="text" class="datepicker form-control" id="progress_time"
                                   required value="{{date('d/m/Y')}}">
                            <input class="btn btn-my pull-right" type="submit" value="Lưu">
                        </div>
                    </form>
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
    <script>
        var current_date = "{{date('d/m/Y')}}";
//        var showpr = false;
//        $("#form-progress").hide();
//        function showAddProgress() {
//            if (showpr) {
//                showpr = false;
//                $("#form-progress").hide();
//            } else {
//                showpr = true;
//                $("#form-progress").show();
//            }
//        }
        function showDetailProgress(id) {
            $(".loader").show();
            $("#steering_id").val(id);
            $.ajax({
                url: "api/progress?s=" + id,
                success: function (result) {
                    $(".loader").hide();
                    var html_table = "";
                    for (var i = 0; i < result.length; i++) {
                        var r = result[i];
                        html_table += "<tr>";
                        html_table += "<td>" + r.note + "</td>"
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

        function resetFromProgress(){
            $("#pr-note").val("");
            $("#progress_time").val(current_date);
            $("input[name=pr_status][value='-2']").prop('checked', true);
            $("#form-progress").hide();
        }

        function reCount(){
            $(".count-st").each(function() {
                console.log($(this).attr('id'));
                $(this).html($('.' + $(this).attr('id')).length);
            });
        }

        $(document).ready(function () {
            $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
            reCount();
            $("#form-progress").submit(function (e) {
                e.preventDefault();
                var note = $("#pr-note").val();
                var steering_id = $("#steering_id").val();
                var status = $('input[name="pr_status"]:checked').val()
                var time_log = $("#progress_time").val();
                $(".loader").show();
                var url = "api/updateprogress";
                console.log(url);
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {note: note, steering_id: steering_id, status: status, time_log: time_log},
                    success: function (result) {
                        $(".loader").hide();
                        $("#modal-progress").modal("hide");
                        $("#progress-" + steering_id).html(note + " <a href='javascript:showDetailProgress(" + steering_id + ")'>Cập nhật</a>")
                        resetFromProgress();
                    },
                    error: function () {
                        alert("Xảy ra lỗi nội bộ");
                        $(".loader").hide();
                    }
                });
            });
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
                        className: 'btn btn-xs btn-my',
                        text: 'Xuất ra PDF',
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-xs btn-my',
                        text: 'Xuất ra Excel',
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

            $("#table_wrapper > .dt-buttons").appendTo("div.panel-button");


            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                        reCount();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                        reCount();
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
@stop