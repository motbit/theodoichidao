@extends('layout1')

@section('page-title')
    Công việc phối hợp
@stop

@section('content')

    <div class="text-center title">Công việc phối hợp</div>


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
            <th> Đơn vị phối hợp<br><input type="text" style="width: 100%"></th>
            <th> Thời hạn HT<input type="text" class="datepicker" style="max-width: 80px"></th>
            <th> Tiến độ<br><input type="text" style="max-width: 100px"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $idx=>$row)
            <?php
            $st = 0;
            if($row->status == 1){
                if ($row->complete_time < $row->deadline){
                    $st = 1;
                }else{
                    $st = 2;
                }
            }else{
                if (date('Y-m-d') < $row->deadline){
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
                            href="javascript:showDetailProgress({{$row->id}})">Chi tiết</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="panel-button"></div>
    <div id="modal-progress" class="modal fade" role="dialog">
        <div class="modal-dialog">
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
                "language": {
                    "url": "/js/datatables/Vietnamese.json"
                },
                "initComplete": function () {
                    $("#table_wrapper > .dt-buttons").appendTo("div.panel-button");
                }
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