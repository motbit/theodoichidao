@extends('layout1')

@section('page-title')
    Danh mục nhiệm vụ
@stop

@section('content')

    <div class="text-center title">Danh mục nhiệm vụ</div>

    @if ($steering != false)
        <p><u>Nguồn chỉ đạo:</u> [{{$steering->code}}] - {{$steering->name}}</p>
    @endif
    @if(\App\Roles::checkPermission())
        {{ Html::linkAction('SteeringcontentController@edit', 'Thêm nhiệm vụ', array('id'=>0), array('class' => 'btn btn-my')) }}

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
    @endif

    {{--<script>--}}
    {{--$(document).ready(function() {--}}
    {{--var table = $('#myTable').DataTable();--}}

    {{--$('#myTable tbody')--}}
    {{--.on( 'mouseenter', 'td', function () {--}}
    {{--var colIdx = table.cell(this).index().column;--}}

    {{--$( table.cells().nodes() ).removeClass( 'highlight' );--}}
    {{--$( table.column( colIdx ).nodes() ).addClass( 'highlight' );--}}
    {{--} );--}}
    {{--} );--}}
    {{--</script>--}}
    {{--<style type="text/css">--}}
    {{--td.highlight {--}}
    {{--background-color: whitesmoke !important;--}}
    {{--}--}}
    {{--</style>--}}
    <div class="row">
        <div class="col-xs-2 nopad">
            <div class="note-cl cl0"></div><span class="note-tx">Đang tiến hành</span>
        </div>
        <div class="col-xs-2 nopad">
            <div class="note-cl cl1"></div><span class="note-tx">Hoàn thành đúng hạn</span>
        </div>
        <div class="col-xs-2 nopad">
            <div class="note-cl cl2"></div><span class="note-tx">Hoàn thành quá hạn</span>
        </div>
        <div class="col-xs-2 nopad">
            <div class="note-cl cl4"></div><span class="note-tx">Sắp hết hạn</span>
        </div>
        <div class="col-xs-4 nopad">
            <div class="note-cl cl3"></div><span class="note-tx">Chưa hoàn thành(Quá hạn)</span>
        </div>
    </div>
    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th></th>
            <th> Tên nhiệm vụ<br><input type="text" style="width: 100%"></th>
            <th> Nguồn chỉ đạo<br><input type="text" style="max-width: 100px"></th>
            <th> Đơn vị đầu mối<input type="text" style="max-width: 100px"></th>
            <th> Đơn vị phối hợp<input type="text" style="max-width: 110px"></th>
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
            <?php
            $st = 0;
            if($row->status == 1){
                if ($row->complete_time < $row->deadline){
                    $st = 1;
                }else{
                    $st = 2;
                }
            }else{
                if ($row->complete_time < $row->deadline){
                    $st = 0;
                }else{
                    $st = 3;
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
                <td id="progress-{{$row->id}}"> {{$row->progress}} <a
                            href="javascript:showDetailProgress({{$row->id}})">Cập nhật</a></td>
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
                @if(\App\Roles::checkPermission())
                    <td>
                        <a href="/steeringcontent/update?id={{$row->id}}"><img height="20" border="0"
                                                                               src="/img/edit.png"></a>
                    </td>
                    <td>
                        <a href="javascript:removebyid('{{$row->id}}')"><img height="20" border="0"
                                                                             src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="modal-progress" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Theo dõi tiến độ</h4>
                </div>
                <div class="modal-body">
                    <a class="btn btn-my" href="javascript:showAddProgress()">Cập nhật tiến độ</a>
                    <form id="form-progress">
                        <div class="form-group">
                            <label>Ghi chú tiến độ</label>
                            <textarea name="note" required id="pr-note" rows="2" class="form-control"></textarea>
                        </div>
                        <label>Tình trạng</label>
                        <div class="form-group">
                            <input type="radio" name="pr_status" value="-2" style="display: none" checked>
                            <input type="radio" name="pr_status" value="0"> Chưa hoàn thành&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="pr_status" value="1"> Hoàn thành&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="pr_status" value="-1"> Hủy
                        </div>
                        <div class="form-group form-inline">
                            <label>Ngày cập nhật</label>
                            <input name="time_log" type="text" class="datepicker form-control" id="progress_time"
                                   required value="{{date('d/m/Y')}}">
                        </div>
                        <input id="steering_id" type="hidden" name="steering_id">;
                        <input class="btn btn-my" type="submit" value="Hoàn tất">
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
        var showpr = false;
        $("#form-progress").hide();
        function showAddProgress() {
            if (showpr) {
                showpr = false;
                $("#form-progress").hide();
            } else {
                showpr = true;
                $("#form-progress").show();
            }
        }
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

        $(document).ready(function () {
            $('.datepicker').datepicker({format: 'dd/mm/yyyy'});

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
        });

        function resetFromProgress(){
            $("#pr-note").val("");
            $("#progress_time").val(current_date);
            $("input[name=pr_status][value='-2']").prop('checked', true);
            $("#form-progress").hide();
        }
    </script>
@stop