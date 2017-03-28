@extends('layout1')

@section('page-title')
    Công việc phối hợp
@stop

@section('content')

    <div class="text-center title">Công việc phối hợp</div>


    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl2"></div><span class="note-tx">Đã hoàn thành</span>(Đúng hạn, <span class="count-st" id="row-st-2"></span>)<br>
            <div class="note-cl cl3"></div><span class="note-tx">Đã hoàn thành</span>(Quá hạn, <span class="count-st" id="row-st-3"></span>)
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl1"></div><span class="note-tx">Chưa hoàn thành</span>(Trong hạn, <span class="count-st" id="row-st-1"></span>)<br>
            <div class="note-cl cl4"></div><span class="note-tx">Chưa hoàn thành</span>(Quá hạn, <span class="count-st" id="row-st-4"></span>)
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl5"></div><span class="note-tx">Nhiệm vụ sắp hết hạn</span> (<span class="count-st" id="row-st-5"></span>)<br>
            <div class="note-cl cl6"></div><span class="note-tx">Nhiệm vụ đã bị hủy</span> (<span class="count-st" id="row-st-6"></span>)
        </div>
    </div>
    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th></th>
            <th> Tên nhiệm vụ<br><input type="text" style="width: 100%; min-width: 120px"></th>
            <th> Nguồn chỉ đạo<br><input type="text" style="max-width: 100px"></th>
            <th> Đơn vị đầu mối<input type="text" style="width: 100%; min-width: 120px;"></th>
            <th> Đơn vị phối hợp<br><input type="text" style="width: 100%; min-width: 120px;"></th>
            <th> Thời hạn HT<br><input type="text" class="datepicker" style="max-width: 80px"></th>
            <th> Tiến độ<br><input type="text" style="max-width: 100px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $idx=>$row)
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
                if (date('Y-m-d') > $row->deadline){
                    $st = 4;
                }else if (date('Y-m-d',strtotime("+7 day")) > $row->deadline){
                    $st = 5;
                }else{
                    $st = 1;
                }
            }
            ?>
            <tr class="row-st-{{$st}}">
                <td>{{$idx + 1}}</td>
                <td> {{$row->content}} </td>
                <td> {{ $row->source }} </td>
                <td>
                    <ul class="unit-list" id="unit-list{{$idx}}">
                        @foreach(explode(',', $row->unit) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = false;
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])){
                                $validate = true;
                                $val = $unit[$spl[1]];
                            }else if ($spl[0] == 'h' && isset($user[$spl[1]])){
                                $validate = true;
                                $val = $user[$spl[1]];
                            }
                            ?>
                            @if ($validate)
                                @if ($loop->iteration < 3)
                                    <li> • {{$val}}</li>
                                @else
                                    @if ($loop->iteration == 3)
                                        <li class="more-link"><a href="javascript:showunit({{$idx}})"> Xem thêm...</a></li>
                                    @endif
                                    <li class="more"> • {{$val}}</li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </td>
                <td>
                    <ul class="unit-list" id="follow-list{{$idx}}">
                        @foreach(explode(',', $row->follow) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = false;
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])){
                                $validate = true;
                                $val = $unit[$spl[1]];
                            }else if ($spl[0] == 'h' && isset($user[$spl[1]])){
                                $validate = true;
                                $val = $user[$spl[1]];
                            }
                            ?>
                            @if ($validate)
                                @if ($loop->iteration < 3)
                                    <li> • {{$val}}</li>
                                @else
                                    @if ($loop->iteration == 3)
                                        <li class="more-link"><a href="javascript:showfollow({{$idx}})"> Xem thêm...</a></li>
                                    @endif
                                    <li class="more"> • {{$val}}</li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </td>
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/Y') }}</td>
                <td id="progress-{{$row->id}}"> {{$row->progress}} <a
                            href="javascript:showDetailProgress({{$row->id}})">Chi tiết</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="panel-button"></div>
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
    <script>
        var current_date = "{{date('d/m/Y')}}";
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
            reCount();
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
                            format: {
                                body: function (data, row, column, node) {

                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm,"").replace(/ +(?= )/g,'').replace(/&amp;/g,' & ').replace(/&nbsp;/g,' ');

                                }
                            }
                        },
                        orientation: 'landscape',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                        },
                        text: 'Xuất ra PDF',
                    },
                    {
                        extend: 'excel',
                        text: 'Xuất ra Excel',
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

                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm,"").replace(/ +(?= )/g,'').replace(/&amp;/g,' & ').replace(/&nbsp;/g,' ');

                                }
                            }
                        }
                    }
                ],
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{$_ENV['ALIAS']}}/js/datatables/Vietnamese.json"
                },
                "initComplete": function () {
                    $("#table_wrapper > .dt-buttons").appendTo("div.panel-button");
                }
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change changeDate', function () {
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

        function showunit(unit) {
            $("#unit-list" + unit + " .more").show();
            $("#unit-list" + unit + " .more-link").hide();
        }
        function showfollow(unit) {
            $("#follow-list" + unit + " .more").show();
            $("#follow-list" + unit + " .more-link").hide();
        }


        function reCount(){
            $(".count-st").each(function() {
                console.log($(this).attr('id'));
                $(this).html($('.' + $(this).attr('id')).length);
            });
        }

        function resetFromProgress(){
            $("#pr-note").val("");
            $("#progress_time").val(current_date);
            $("input[name=pr_status][value='-2']").prop('checked', true);
            $("#form-progress").hide();
        }
    </script>
    <style>
        #table_filter {
            display: none;
        }
    </style>
@stop