@extends('layout1')

@section('page-title')
    Báo cáo
@stop
@section('page-toolbar')
@stop

@section('content')
    <div>
        <div class="text-center title">Báo cáo chi tiết</div>
        <a class="btn btn-my pull-right" style="margin-top: -50px;" href="javascript:clearFilter()">Xóa tìm kiếm</a>
    </div>


    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif
    {!! Form::open(array('route' => 'report-index', 'class' => 'form', 'id' => 'form')) !!}


    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group form-inline ">
                <label>Nguồn chỉ đạo:</label>
                {!! Form::text('source', "",
                        array('no-required',
                        'placeholder'=>'Nguồn chỉ đạo',
                        'class'=>'form-control ipw', 'id'=>'source')
                ) !!}
            </div>
            <div class="form-group form-inline">
                <label>Người chỉ đạo:</label>
                {!! Form::text('conductor', "",
                        array('no-required',
                        'placeholder'=>'Người chỉ đạo',
                        'class'=>'form-control ipw', 'id'=>'viphuman')
                ) !!}
            </div>
            <div class="form-group form-inline">
                <label>Đơn vị đầu mối:</label>
                <select id="fList" name="firtunit[]" class="form-control select-single ipw" style="max-width:80%;">
                    <option value="">...</option>
                    @foreach($treeunit as $item)
                        @foreach($item->children as $c)
                            <option value="{{$c->name}}">{{$c->name}}</option>
                        @endforeach
                    @endforeach
                    @foreach($users as $u)
                        <option value="{{$u->fullname}}">{{$u->fullname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-inline">
                <label>Tiến độ:</label>
                <select id="progress" name="progress" class="form-control select-single ipw">
                    <option value="">Toàn bộ</option>
                    <option value="2">Đã hoàn thành(Đúng hạn)</option>
                    <option value="3">Đã hoàn thành(Quá hạn)</option>
                    <option value="1">Chưa hoàn thành(Trong hạn)</option>
                    <option value="4">Chưa hoàn thành(Quá hạn)</option>
                    <option value="5">Nhiệm vụ sắp hết hạn</option>
                    <option value="6">Nhiệm vụ đã bị hủy</option>
                </select>
            </div>

        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group form-inline">
                <label>Ngày chỉ đạo:</label>
                Từ:
                {!! Form::text('steertime_from', "",
                    array('class'=>'form-control datepicker', 'id'=>'steertime_from',
                          'placeholder'=>'Từ ngày')) !!}
                Đến:
                {!! Form::text('steertime_to', "",
                    array('class'=>'form-control datepicker','id'=>'steertime_to',
                          'placeholder'=>'Đến ngày')) !!}
            </div>
            <div class="form-group  form-inline">
                <label>Thời hạn HT:</label>
                Từ: {!! Form::text('deadline_from', "",
                        array('class'=>'form-control datepicker',
                              'placeholder'=>'Từ ngày','id'=>'deadline_from'
                              )) !!}
                Đến: {!! Form::text('deadline_to', "",
                        array('class'=>'form-control datepicker','id'=>'deadline_to',
                              'placeholder'=>'Đến ngày')) !!}
            </div>
            <div class="form-group form-inline">
                <label>Đơn vị phối hợp:</label>
                <select id="sList" name="secondunit[]" class="form-control select-single ipw" style="max-width:80%;">
                    <option value="">...</option>
                    @foreach($treeunit as $item)
                        @foreach($item->children as $c)
                            <option value="{{$c->name}}">{{$c->name}}</option>
                        @endforeach
                    @endforeach
                    @foreach($users as $u)
                        <option value="{{$u->fullname}}">{{$u->fullname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group form-inline pull-right">
                {!! Form::submit('Tìm kiếm',
                  array('class'=>'btn btn-my', 'id'=>'search')) !!}
                <a id="btn-export" class="btn btn-my" href="#" target="_blank">Xuất báo cáo</a>
            </div>
        </div>

    </div>


    {!! Form::close() !!}
    <div class="row note-contain">
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl2"></div><a id="a2" class="a-status" href="javascript:filterStatus(2)"><span class="note-tx">Đã hoàn thành</span>(Đúng hạn, <span class="count-st" id="row-st-2"></span>)</a><br>
            <div class="note-cl cl3"></div><a id="a3" class="a-status" href="javascript:filterStatus(3)"><span class="note-tx">Đã hoàn thành</span>(Quá hạn, <span class="count-st" id="row-st-3"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl1"></div><a id="a1" class="a-status" href="javascript:filterStatus(1)"><span class="note-tx">Chưa hoàn thành</span>(Trong hạn, <span class="count-st" id="row-st-1"></span>)</a><br>
            <div class="note-cl cl4"></div><a id="a4" class="a-status" href="javascript:filterStatus(4)"><span class="note-tx">Chưa hoàn thành</span>(Quá hạn, <span class="count-st" id="row-st-4"></span>)</a>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="note-cl cl5"></div><a id="a5" class="a-status" href="javascript:filterStatus(5)"><span class="note-tx">Nhiệm vụ sắp hết hạn(7 ngày)</span> (<span class="count-st" id="row-st-5"></span>)</a><br>
            <div class="note-cl cl6"></div><a id="a6" class="a-status" href="javascript:filterStatus(6)"><span class="note-tx">Nhiệm vụ đã bị hủy</span> (<span class="count-st" id="row-st-6"></span>)</a>
        </div>
    </div>
    <table id="table" class="table table-bordered table-hover row-border hover order-column">
        <thead>
        <tr>
            <th></th>
            <th> Tên nhiệm vụ<br><input type="text" id="id_content" style="width: 100%; min-width: 250px"></th>
            <th> Người chỉ đạo<br><input type="text" id="id_conductor" style="width: 100%; min-width: 90px"></th>
            <th> Ngày chỉ đạo<br><input type="text" id="id_steertime" style="width: 100%; min-width: 90px"></th>
            <th> Nguồn chỉ đạo<br><input id="id_source" type="text" style="max-width: 100px"></th>
            <th> Đơn vị đầu mối<input id="id_funit" type="text" style="width: 100%; min-width: 120px;"></th>
            <th> Đơn vị phối hợp<br><input id="id_sunit" type="text" style="width: 100%; min-width: 120px;"></th>
            <th> Thời hạn HT<br><input id="id_complete_time" type="text" class="datepicker" style="max-width: 80px"></th>
            <th class="hidden">Trạng thái</th>
            <th class="hidden"><input type="text" id="filter-status"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $idx=>$row)
            {{--@if(\App\Roles::accessRow(Request::path(), $row->created_by))--}}
            <?php
            $st = 1;
            if ($row->status == 1) {
                if ($row->deadline == "" || $row->complete_time < $row->deadline) {
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
            $name_stt[1] = "Chưa hoàn thành (trong hạn)";
            $name_stt[2] = "Đã hoàn thành (đúng hạn)";
            $name_stt[3] = "Đã hoàn thành (quá hạn)";
            $name_stt[4] = "Chưa hoàn thành (quá hạn)";
            $name_stt[5] = "Sắp hết hạn (7 ngày)";
            $name_stt[6] = "Bị hủy";
            ?>

            <tr class="row-st-{{$st}}" id="row-{{$row->id}}" deadline="{{$row->deadline}}">
                <td>{{$idx + 1}}</td>
                <td> {{$row->content}} </td>
                <td> {{$row->conductor}} </td>
                <td> {{ ($row->steer_time != '')?Carbon\Carbon::parse($row->steer_time)->format('d/m/Y'):'' }} </td>
                @if ( !in_array($row->source, $allsteeringcode) )
                    <td> {{ $row->source }} </td>
                @else
                    <td><a href="steeringcontent?source={{$row->source}}"> {{ $row->source }} </a></td>
                @endif

                <td onclick="javascript:showunit({{$idx}})">
                    <ul class="unit-list" id="unit-list{{$idx}}">
                        @php ($n = 0)
                        @foreach($units = explode(',', $row->unit) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = false;
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                                $validate = true;
                                $val = $unit[$spl[1]];
                                $n++;
                            } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                                $validate = true;
                                $val = $user[$spl[1]];
                                $n++;
                            }
                            ?>
                            @if ($validate)
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
                <td onclick="javascript:showfollow({{$idx}})">
                    <ul class="unit-list" id="follow-list{{$idx}}">
                        @php ($n = 0)
                        @foreach($units = explode(',', $row->follow) as $i)
                            <?php
                            $spl = explode('|', $i);
                            $validate = false;
                            $val = "";
                            if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                                $validate = true;
                                $val = $unit[$spl[1]];
                                $n++;
                            } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                                $validate = true;
                                $val = $user[$spl[1]];
                                $n++;
                            }
                            ?>
                            @if ($validate)
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
                <td> {{ ($row->deadline != '')?Carbon\Carbon::parse($row->deadline)->format('d/m/Y'):'' }}</td>
                <td class="hidden">{{$name_stt[$st]}}</td>
                <td class="hidden">{{$st}}</td>
            </tr>
            {{--@endif--}}
        @endforeach
        </tbody>
    </table>
    <div class="panel-button"></div>

    <script src="{{$_ENV['ALIAS']}}/js/jquery-ui.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/jquery-ui.css" rel="stylesheet">
    <script>
        var current_date = "{{date('d/m/Y')}}";
        var sources = [
            @foreach($sourcesteering as $s)
                    '{{$s->code}}',
            @endforeach
        ];
        var viphumans = [
            @foreach($viphuman as $v)
                    '{{$v->name}}',
            @endforeach
        ];
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
        function dateToTime(strDate) {
            var split = strDate.split('/');
            var time = new Date(split[2], split[1] - 1, split[0]);
            return time;
        }

        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                dateFormat: 'dd-mm-yy',
            });
            reCount();
            $("#source").autocomplete({
                source: sources
            });
            $("#viphuman").autocomplete({
                source: viphumans
            });

            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8],
                            format: {
                                body: function (data, row, column, node) {
                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ').replace(/•/g, "\r\n•").replace(/[+] Xem thêm/g, "").trim();
                                }
                            },
                            modifier: {
                                page: 'all'
                            },
                        },
                        title: 'Danh mục nhiệm vụ (Ngày ' + current_date + ")",
                        orientation: 'landscape',
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                        },
                        text: 'Xuất ra PDF',
                    },
                    {
                        extend: 'excel',
                        text: 'Xuất ra Excel',
                        title: 'Danh mục nhiệm vụ (Ngày ' + current_date + ")",
                        stripHtml: true,
                        decodeEntities: true,
                        columns: ':visible',
                        modifier: {
                            selected: true
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5,6,7,8],
                            format: {
                                body: function (data, row, column, node) {
                                    return data.replace(/<(?:.|\n)*?>/gm, '').replace(/(\r\n|\n|\r)/gm, "").replace(/ +(?= )/g, '').replace(/&amp;/g, ' & ').replace(/&nbsp;/g, ' ').replace(/•/g, "\r\n•").replace(/[+] Xem thêm/g, "").trim();
                                }
                            }
                        }
                    }
                ],
                bSort: false,
                bLengthChange: false,
//                "responsive": true,
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
                        if (this.id != "filter-status") {
                                reCount();
                        }
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                            reCount();
                    }
                });
            });

            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        var deadline_from = $('#deadline_from').val();
                        var deadline_to = $('#deadline_to').val();
                        var deadline = data[7]; // use data for the age column

                        deadline_from = deadline_from.split('-').join('/');
                        deadline_to = deadline_to.split('-').join('/');

                        var timeFrom = dateToTime(deadline_from);
                        var timeTo = dateToTime(deadline_to);
                        var time = dateToTime(deadline);


                        var steertime_from = $('#steertime_from').val();
                        steertime_from = steertime_from.split('-').join('/');
                        var steertime_to = $('#steertime_to').val();
                        steertime_to = steertime_to.split('-').join('/');
                        var steertime = data[3];

                        var steertimeFrom = dateToTime(steertime_from);
                        var steertimeTo = dateToTime(steertime_to);
                        var steertime = dateToTime(steertime);

                        if (deadline_from == '' && deadline_to == '' && steertime_from == '' && steertime_to == '') {
                            return true;
                        }


                        if (steertime_from == '' && steertime_to == '') {
                            if(deadline_from != '' && deadline_to != '' && (timeFrom <= time && timeTo >= time)){
                                return true;
                            }
                            else if(deadline_from != '' && deadline_to == '' && (time >= timeFrom)) return true;
                            else if(deadline_from == '' && deadline_to != '' && (time <= timeTo)) return true;

                        }
                        if(steertime_from == '' && steertime_to != '' && steertime < steertimeTo){
                            if(deadline_from != '' && deadline_to != '' && (timeFrom <= time && timeTo >= time)){
                                return true;
                            }
                            else if(deadline_from != '' && deadline_to == '' && (time >= timeFrom)) return true;
                            else if(deadline_from == '' && deadline_to != '' && (time <= timeTo)) return true;
                        }
                        if(steertime_from != '' && steertime_to == '' && steertime > steertimeFrom){
                            if(deadline_from != '' && deadline_to != '' && (timeFrom <= time && timeTo >= time)){
                                return true;
                            }
                            else if(deadline_from != '' && deadline_to == '' && (time >= timeFrom)) return true;
                            else if(deadline_from == '' && deadline_to != '' && (time <= timeTo)){
                                return true;
                            }
                        }
                        if(steertime_from != '' && steertime_to != '' && steertime < steertimeTo && steertime > steertimeFrom){
                            if(deadline_from != '' && deadline_to != '' && (timeFrom <= time && timeTo >= time)){
                                return true;
                            }
                            else if(deadline_from != '' && deadline_to == '' && (time >= timeFrom)) return true;
                            else if(deadline_from == '' && deadline_to != '' && (time <= timeTo)){
                                return true;
                            }
                        }
                        if (deadline_from == '' && deadline_to == '') {
                            if ( steertime_from != '' && steertime_to != '' && (steertimeFrom <= steertime && steertimeTo >= steertime)) {
                                return true;
                            }
                            else if(steertime_from != '' && steertime_to == '' && (steertime >= steertimeFrom)) return true;
                            else if(steertime_from == '' && steertime_to != '' && (steertime <= steertimeTo)) return true;

                        }
                        if(deadline_from != '' && deadline_to == '' & time > timeFrom){
                            if ( steertime_from != '' && steertime_to != '' && (steertimeFrom <= steertime && steertimeTo >= steertime)) {
                                return true;
                            }
                            else if(steertime_from != '' && steertime_to == '' && (steertime >= steertimeFrom)) return true;
                            else if(steertime_from == '' && steertime_to != '' && (steertime <= steertimeTo)) return true;
                        }
                        if(deadline_from == '' && deadline_to != '' && time < timeTo){
                            if ( steertime_from != '' && steertime_to != '' && (steertimeFrom <= steertime && steertimeTo >= steertime)) {
                                return true;
                            }
                            else if(steertime_from != '' && steertime_to == '' && (steertime >= steertimeFrom)) return true;
                            else if(steertime_from == '' && steertime_to != '' && (steertime <= steertimeTo)) return true;
                        }
                        if(deadline_from != '' && deadline_to != '' && time > timeFrom && time < timeTo){
                            if ( steertime_from != '' && steertime_to != '' && (steertimeFrom <= steertime && steertimeTo >= steertime)) {
                                return true;
                            }
                            else if(steertime_from != '' && steertime_to == '' && (steertime >= steertimeFrom)) return true;
                            else if(steertime_from == '' && steertime_to != '' && (steertime <= steertimeTo)) return true;
                        }

                        if (deadline_from != '' && deadline_to != '' && steertime_from != '' && steertime_to != '') {
                            if ((timeFrom <= time && timeTo >= time) && (steertimeFrom <= steertime && steertimeTo >= steertime)) {
                                return true;
                            }
                        }

                        return false;
                    }
            );

            $("#form").submit(function (event) {
                table.draw();

                var val = $('input[name="source"]').val();
                $("#id_source").val(val);
                $("#id_source").trigger("change");

                var val = $('input[name="conductor"]').val();
                $("#id_conductor").val(val);
                $("#id_conductor").trigger("change");

                var val = $("#fList").val();
                $("#id_funit").val(val);
                $("#id_funit").trigger("change");

                var val = $("#sList").val();
                $("#id_sunit").val(val);
                $("#id_sunit").trigger("change");

                var val = $("#progress").val();
                $("#filter-status").val(val);
                $("#filter-status").trigger("change");

                return false;

            });

        });

        function clearFilter(){
            $('input[name="source"]').val("");
            $('input[name="conductor"]').val("");
            $("#fList").val(0).trigger('change');
            $("#sList").val(0).trigger('change');
            $("#progress").val(0).trigger('change');
            $('input[name="steertime_from"]').val("");
            $('input[name="steertime_to"]').val("");
            $('input[name="deadline_from"]').val("");
            $('input[name="deadline_to"]').val("");

            $("#form").submit();
        }

        //            $('input[name="source"]').change(function () {
        //                var val = $('input[name="source"]').val();
        //                $("#id_source").val(val);
        //                $("#id_source").trigger("change");
        //            });
        //            $('input[name="conductor"]').change(function () {
        //                var val = $('input[name="conductor"]').val();
        //                $("#id_conductor").val(val);
        //                $("#id_conductor").trigger("change");
        //            })
        //
        //            $('#fList').on("select2:select", function (event) {
        //                var val = $("#fList").val();
        //                $("#id_funit").val(val);
        //                $("#id_funit").trigger("change");
        //            });
        //            $('#sList').on("select2:select", function (event) {
        //                var val = $("#sList").val();
        //                $("#id_sunit").val(val);
        //                $("#id_sunit").trigger("change");
        //            });
        //
        //            $('#progress').change(function() {
        //                var val = $("#progress").val();
        //                $("#filter-status").val(val);
        //                $("#filter-status").trigger("change");
        //            });

        //                $('#deadline_to').change(function() {
        //                    table.draw();
        //                });
        // select2 - multiple select
        $(".select-multiple").select2();
        $(".select-single").select2();
    </script>
    <script>
        //loc theo trang thai
        function reCount(){
            $(".count-st").each(function() {
//                console.log($(this).attr('id'));
                $(this).html($('.' + $(this).attr('id')).length);
            });
            var v1 = $('.row-st-1').length + $('.row-st-5').length;
            var v2 = $('.row-st-4').length;
            var v3 = $('.row-st-2').length;
            var v4 = $('.row-st-3').length;
            var v5 = $('.row-st-6').length;
            $("#btn-export").attr('href', '{{$_ENV['ALIAS']}}/report/export?v1=' + v1 + "&v2=" + v2 + "&v3=" + v3 + "&v4=" + v4 + "&v5=" + v5);
        }
        function filterStatus(status){
            $(".a-status").css('font-weight', 'normal');
            $("#a" + status).css('font-weight', 'bold');
            $("#filter-status").val(status);
            $("#filter-status").trigger("change");
        }
    </script>
    <style>
        #table_filter {
            display: none;
        }

        label {
            width: 120px !important;
        }

        .datepicker {
            max-width: 120px;
        }
    </style>

@stop