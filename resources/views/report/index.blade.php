@extends('layout1')

@section('page-title')
    Báo cáo
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="row title" style="min-width: 350px">
        <div class="col-xs-10">
            <div class="text-center ">Báo cáo thống kê chi tiết</div>
        </div>
        <div class="col-xs-2">
            <a class="btn btn-sm btn-my pull-right hidden-xs hidden-sm" style="margin: 0"
               href="javascript:clearFilter()">Xóa tìm kiếm</a>
            <a class="btn btn-xs btn-my pull-right visible-xs visible-sm" style="margin: 0"
               href="javascript:clearFilter()">Xóa</a>
        </div>

    </div>

    <div class="row" style="min-width: 350px">
        <div class="col-xs-12">
            @if ( $errors->count() > 0 )
                @foreach( $errors->all() as $message )
                    <p class="alert alert-danger">{{ $message }}</p>
                @endforeach
            @endif
        </div>
    </div>

    <div id="filter-container" class="row" style="min-width: 350px; display: none">
        <div class="col-xs-12">
            {!! Form::open(array('route' => 'report-index', 'class' => 'form', 'id' => 'form')) !!}

            <div class="row search-box">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group form-inline ">
                        <label>{{env('SRC_UC')}}:</label>
                        <div class="input-contain form-group form-inline">
                            <select name="source" id="source" class="form-control ipw mi fl" style="width: 200px">
                                <option value=""></option>
                                @foreach($typeArr as $type)
                                <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                            <div class="btn btn-default ico ico-search fl hidden" data-toggle="modal"
                                 data-target="#modal-source"></div>
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <label>Kí hiệu nguồn:</label>
                        <input type="text" id="source-note" class="form-control mi ipw" style="width: 200px">
                    </div>
                    <div class="form-group form-inline">
                        <label>ĐV/CN đầu mối:</label>
                        <select id="fList" name="firtunit[]" class="form-control select-multiple ipw"
                                multiple="multiple"
                                style="max-width:80%;">
                            @foreach($treeunit as $item)
                                @foreach($item->children as $c)
                                    <option value="{{$c->name}}">{{$c->name}}</option>
                                @endforeach
                            @endforeach
                            @foreach($users as $u)
                                <option value="{{$u->fullname}}">{{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}</option>
                            @endforeach
                        </select>
                        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#firt-unit"></div>
                    </div>
                    <div class="form-group form-inline">
                        <label>ĐV/CN phối hợp:</label>
                        <select id="sList" name="secondunit[]" class="form-control select-multiple ipw"
                                multiple="multiple"
                                style="max-width:80%;">
                            @foreach($treeunit as $item)
                                @foreach($item->children as $c)
                                    <option value="{{$c->name}}">{{$c->name}}</option>
                                @endforeach
                            @endforeach
                            @foreach($users as $u)
                                <option value="{{$u->fullname}}">{{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}</option>
                            @endforeach
                        </select>
                        <div class="btn btn-default ico ico-search" data-toggle="modal"
                             data-target="#second-unit"></div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group form-inline">
                        <label>{{env('LD_SHORT')}}:</label>
                        <div class="input-contain">
                            <select name="conductor" class="form-control ipw" id="conductor">
                                <option value=""></option>
                                @foreach($viphuman as $row)
                                    <option value="{{$row->name}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <label>Ngày chỉ đạo:</label>
                        <div class="input-contain">
                            {!! Form::text('steertime_from', "",
                                array('class'=>'form-control datepicker fl', 'id'=>'steertime_from',
                                      'placeholder'=>'Từ ngày')) !!}
                            {!! Form::text('steertime_to', "",
                                array('class'=>'form-control datepicker fl ml10','id'=>'steertime_to',
                                      'placeholder'=>'Đến ngày')) !!}
                        </div>
                    </div>
                    <div class="form-group  form-inline">
                        <label>Thời hạn hoàn thành:</label>
                        <div class="input-contain">
                            {!! Form::text('deadline_from', "",
                                    array('class'=>'form-control datepicker fl',
                                          'placeholder'=>'Từ ngày','id'=>'deadline_from'
                                          )) !!}
                            {!! Form::text('deadline_to', "",
                                    array('class'=>'form-control datepicker fl ml10','id'=>'deadline_to',
                                          'placeholder'=>'Đến ngày')) !!}
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <label>Tiến độ:</label>
                        <select id="progress" name="progress" class="form-control mi ipw">
                            <option value="">Toàn bộ</option>
                            <option value="2">Đã hoàn thành(Đúng hạn)</option>
                            <option value="3">Đã hoàn thành(Quá hạn)</option>
                            <option value="1">Đang thực hiện(Trong hạn)</option>
                            <option value="4">Đang thực hiện(Quá hạn)</option>
                            <option value="5">Nhiệm vụ sắp hết hạn</option>
                            <option value="6">Nhiệm vụ đã bị hủy</option>
                        </select>
                    </div>
                    <div class="form-group form-inline hidden">
                        <label>Thống kê theo thời gian:</label>
                        <input type="number" id="filter-range" style="max-width: 120px" class="form-control mi ipw">
                        ngày
                    </div>
                    <div class="form-group form-inline pull-right" style="margin-bottom: 0px">
                        {!! Form::submit('Tìm kiếm',
                          array('class'=>'btn btn-my', 'id'=>'search')) !!}
                        <a id="btn-export" class="btn btn-my" href="#" download>Xuất báo cáo</a>
                    </div>
                </div>

            </div>

            {!! Form::close() !!}

        </div>
    </div>
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
    <table id="table" class="table table-bordered table-hover row-border hover order-column" style="display: none">
        <thead>
        <tr>
            <th class="hidden"></th>
            <th style="width: 10px"></th>
            <th style="min-width: 150px"> Tên nhiệm vụ<br><input type="text"></th>
            <th style="width: 65px">{{env('LD_SHORT')}}<br><input type="text" id="conductor"></th>
            <th style="min-width: 100px"> Ngày chỉ đạo<br><input type="text" id="id_steertime"></th>
            <th style="min-width: 100px"> {{env('SRC_UC')}}<br><input id="id_source" type="text"></th>
            <th style="min-width: 100px"> Đv/cn đầu mối<input id="id_funit" type="text"></th>
            <th style="min-width: 100px"> Đv/Cn phối hợp<br><input id="id_sunit" type="text"></th>
            <th style="min-width: 50px">Hạn HT<br><input id="id_complete_time" type="text" class="datepicker"></th>
            <th class="hidden">Trạng thái</th>
            <th class="hidden"><input type="text" id="filter-status"></th>
            <th class="hidden"></th>
            <th class="hidden"><input type="text" id="filter-source"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $idx=>$row)
            {{--@if(\App\Roles::accessRow(Request::path(), $row->created_by))--}}
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
                    onclick="showDetail({{$row->id}})"> {{$row->content}} </td>
                <td class="text-center">
                    <?php $arrConductor = explode(',', $row->conductor)?>
                    @foreach($arrConductor as $idx => $cd)
                        {!! isset($conductor[$cd])?$conductor[$cd]:'' !!} {!!$idx < count($arrConductor) - 1?'<br><br>':'' !!}
                    @endforeach
                </td>
                <td> {{ ($row->steer_time != '')?Carbon\Carbon::parse($row->steer_time)->format('d/m/y'):'' }} </td>
                <td>
                    @if( !empty($steeringSourceArr[$row->id]))
                        @foreach($steeringSourceArr[$row->id] as $item)
                            <ul class="unit-list">
                                <li> {{$item['source']}}</li>
                            </ul>
                        @endforeach
                    @endif
                </td>

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
                <td> {{ ($row->deadline != '')?Carbon\Carbon::parse($row->deadline)->format('d/m/y'):'' }}</td>
                <td class="hidden">{{$name_stt[$st]}}</td>
                <td class="hidden">{{$st}}</td>
                <td class="hidden"> {{\App\Utils::minusDate($row->deadline, $row->steer_time)}}</td>
                <td class="hidden">
                    @if( !empty($steeringSourceArr[$row->id]))
                        @foreach($steeringSourceArr[$row->id] as $item)
                            <ul>
                                <li>{{$item['note']}}</li>
                            </ul>
                        @endforeach
                    @endif
                </td>
            </tr>
            {{--@endif--}}
        @endforeach
        </tbody>
    </table>
    <div>
        <span><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="table"
                 href="javascript:exportExcel()"><span>Xuất ra Excel</span></a></span>
        <span><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="table"
                 href="javascript:exportExcel(null,null,'pdf')"><span>Xuất ra PDF</span></a></span>
    </div>
    <div id="modal-source" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách {{env('SRC_LC')}}:</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @foreach($typeArr as $type)
                            <tr>
                                <td><input type="radio" name="psource" class="pick-source" value="{{$type}}"></td>
                                <td>{{$type}}</td>
                            </tr>
                        @endforeach
                        {{--@foreach($sourcesteering as $s)--}}
                        {{--<tr>--}}
                        {{--<td><input type="radio" name="psource" class="pick-source" value="{{$s->code}}"--}}
                        {{--data-time="{{date("d-m-Y", strtotime($s->time))}}"></td>--}}
                        {{--<td>{{$s->code}}</td>--}}
                        {{--<td>{{$s->name}}</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-viphuman" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách {{env('LD_SHORT')}}</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @foreach($viphuman as $v)
                            <tr>
                                <td><input type="radio" name="pviphuman" class="pick-source" value="{{$v->id}}"
                                           data-name="{{$v->name}}"></td>
                                <td>{{$v->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="firt-unit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Danh sách đơn vị/Cá nhân</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#fdonvi">Đơn vị</a></li>
                        <li><a data-toggle="tab" href="#fcanhan">Cá nhân</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="panel-group tab-pane fade in active" id="fdonvi">
                            @foreach($treeunit as $idx=>$u)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <input type="checkbox" name="pfunit-parent" class="pick-firt-unit"
                                                   value="{{$u->id}}">
                                            <a data-toggle="collapse" href="#collapse{{$u->id}}"> {{$u->name}}</a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{$u->id}}" class="panel-collapse collapse in">
                                        <ul class="list-group">
                                            @foreach($u->children as $c)
                                                <li class="list-group-item">
                                                    {{--<input type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">--}}
                                                    <input type="checkbox" name="pfunit" class="pick-firt-unit"
                                                           value="{{$c->name}}" parent-id="{{$u->id}}">
                                                    {{$c->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="fcanhan" class="tab-pane fade in">
                            <ul class="list-group">
                                @foreach($users as $u)
                                    <li class="list-group-item">
                                        {{--<input type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">--}}
                                        <input type="checkbox" name="pfunit" class="pick-firt-unit"
                                               value="{{$u->fullname}}">
                                        {{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="second-unit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách đơn vị/Cá nhân</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#sdonvi">Đơn vị</a></li>
                        <li><a data-toggle="tab" href="#scanhan">Cá nhân</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="panel-group tab-pane fade in active" id="sdonvi">
                            @foreach($treeunit as $idx=>$u)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <input type="checkbox" name="psunit-parent" class="pick-firt-unit"
                                                   value="{{$u->id}}">
                                            <a data-toggle="collapse" href="#collapse2{{$u->id}}"> {{$u->name}}</a>
                                        </h4>
                                    </div>

                                    <div id="collapse2{{$u->id}}" class="panel-collapse collapse in">
                                        <ul class="list-group">
                                            @foreach($u->children as $c)
                                                <li class="list-group-item">
                                                    <input type="checkbox" name="psunit" class="pick-firt-unit"
                                                           value="{{$c->name}}" parent-id="{{$u->id}}">
                                                    {{$c->name}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="scanhan" class="tab-pane fade in">
                            <ul class="list-group">
                                @foreach($users as $u)
                                    <li class="list-group-item">
                                        {{--<input type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">--}}
                                        <input type="checkbox" name="psunit" class="pick-firt-unit"
                                               value="{{$u->fullname}}">
                                        {{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{$_ENV['ALIAS']}}/js/jquery-ui.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/jquery-ui.css" rel="stylesheet">
    <script>
        var current_date = "{{date('d/m/y')}}";
        var sources = [
            @foreach($typeArr as $type)
                '{{$type}}',
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
            reCount();
            $("#source").autocomplete({
                source: sources
            });
            $("#viphuman").autocomplete({
                source: viphumans
            });

            $('input:radio[name=psource]').change(function () {
                var name = $('input[name="psource"]:checked').val()
                $('select[name="source"]').val(name);
            });

            $('select[name="source"]').change(function () {
                var val = $('select[name="source"]').val();
                $('input:radio[name=psource][value="' + val + '"]').attr('checked', true);
            });

            $('input:radio[name=pviphuman]').change(function () {
                var name = $('input[name="pviphuman"]:checked').attr('data-name');
                $('input[name="conductor"]').val(name);
            });
            $('input[name="conductor"]').change(function () {
                var val = $('input[name="conductor"]').val();
                $('input:radio[name=pviphuman][data-name="' + val + '"]').attr('checked', true);
            });
            //
            $('input:checkbox[name=pfunit]').change(function () {
                var arr = [];
                var vl = '';
                $('input:checkbox[name=pfunit]:checked').each(function () {
                    vl = $(this).val();
                    arr.push(vl);
                });
                $("#fList").val(arr).trigger('change');
            });
            $('input:checkbox[name=pfunit-parent]').change(function () {
                var id = $(this).val();
                if (!$(this).is(":checked")) {
                    $("input:checkbox[name=pfunit][parent-id=" + id + "]").prop('checked', false);
                } else {
                    $("input:checkbox[name=pfunit][parent-id=" + id + "]").prop('checked', true);
                }
                var arr = [];
                var vl = '';
                $('input:checkbox[name=pfunit]:checked').each(function () {
                    vl = $(this).val();
                    arr.push(vl);
                });
                $("#fList").val(arr).trigger('change');
            });


            $('input:checkbox[name=psunit]').change(function () {
                var arr = [];
                var vl = '';
                $('input:checkbox[name=psunit]:checked').each(function () {
                    vl = $(this).val();
                    arr.push(vl);
                });
                $("#sList").val(arr).trigger('change');
            });

            $('input:checkbox[name=psunit-parent]').change(function () {
                var id = $(this).val();
                if (!$(this).is(":checked")) {
                    alert('t');
                    $("input:checkbox[name=psunit][parent-id=" + id + "]").prop('checked', false);
                } else {
                    $("input:checkbox[name=psunit][parent-id=" + id + "]").prop('checked', true);
                }
                var arr = [];
                var vl = '';
                $('input:checkbox[name=psunit]:checked').each(function () {
                    vl = $(this).val();
                    arr.push(vl);
                });
                $("#sList").val(arr).trigger('change');
            });

            $('#fList').on("select2:select", function (event) {
                $(event.currentTarget).find("option:selected").each(function (i, selected) {
                    i = $(selected).val();
                    $('input:checkbox[name=pfunit][value="' + i + '"]').attr('checked', true);
                });
            });
            $("#fList").on("select2:unselect", function (event) {
                $('input:checkbox[name=pfunit]').prop('checked', false);

                $(event.currentTarget).find("option:selected").each(function (i, selected) {
                    i = $(selected).val();
                    $('input:checkbox[name=pfunit][value="' + i + '"]').prop('checked', true);
                });
            });

            $('#sList').on("select2:select", function (event) {
                $(event.currentTarget).find("option:selected").each(function (i, selected) {
                    i = $(selected).val();
                    $('input:checkbox[name=psunit][value="' + i + '"]').attr('checked', true);
                });
            });

            $("#sList").on("select2:unselect", function (event) {
                $('input:checkbox[name=psunit]').prop('checked', false);
                $(event.currentTarget).find("option:selected").each(function (i, selected) {
                    i = $(selected).val();
                    $('input:checkbox[name=psunit][value="' + i + '"]').prop('checked', true);
                });
            });

            // DataTable
            var table = $('#table').DataTable({
                bSort: false,
                bLengthChange: false,
//                "responsive": true,
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
                        reCount(this.id == "filter-status");
//                        if (this.id != "filter-status") {
//                            reCount();
//                        } else {
//                            reloadDataExport();
//                        }
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
            console.log("datatable");
            $("#table").show();

            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    //Kiểm tra date range
                    var drange = $("#filter-range").val()
                    if (drange != "") {
                        if (drange > data[11]) {
                            return false;
                        }
                    }
                    //kiểm tra hạn
                    var deadline_from = $('#deadline_from').val();
                    var deadline_to = $('#deadline_to').val();
                    var deadline = data[8]; // use data for the age column

                    var timeFrom = dateToTime(deadline_from);
                    var timeTo = dateToTime(deadline_to);
                    var time = dateToTime(deadline);
                    if (deadline_from != "" && time < timeFrom) {
                        return false;
                    }
                    if (deadline_to != "" && time > timeTo) {
                        return false;
                    }
                    //kiểm tra ngày chỉ đạo
                    var steertime_from = $('#steertime_from').val();
                    var steertime_to = $('#steertime_to').val();
                    var steertime = data[4];

                    var steertimeFrom = dateToTime(steertime_from);
                    var steertimeTo = dateToTime(steertime_to);
                    var steertime = dateToTime(steertime);
                    if (steertime_from != "" && steertime < steertimeFrom) {
                        return false;
                    }
                    if (steertime_to != "" && steertime > steertimeTo) {
                        return false;
                    }

                    //Đơn vị chủ trì
                    var select_unit = $("#fList").val();
                    if (select_unit.length > 0) {
                        var r_unit = false;
                        var data_unit = data[6];
                        for (var i = 0; i < select_unit.length; i++) {
                            var unit = select_unit[i];
                            r_unit = data_unit.indexOf(unit) != -1;
                        }
                        if (!r_unit) return false;
                    }

                    //Đơn vị phối hợp
                    var select_follow = $("#sList").val();
                    if (select_follow.length > 0) {
                        var r_follow = false;
                        var data_follow = data[7];
                        for (var i = 0; i < select_follow.length; i++) {
                            var follow = select_follow[i];
                            r_follow = data_follow.indexOf(follow) != -1;
                        }
                        if (!r_follow) return false;
                    }
                    return true;
                }
            );

            $("#form").submit(function (event) {
                table.draw();
                var val = $('#source').val();
                $("#id_source").val(val);
                $("#id_source").trigger("change");

                $("#filter-source").val($("#source-note").val());
                $("#filter-source").trigger("change");

                var val = $('#conductor').val();
                $("#filter-conductor").val(val);
                $("#filter-conductor").trigger("change");

//                var val = $("#fList").val();
//                $("#id_funit").val(val);
//                $("#id_funit").trigger("change");
//
//                var val = $("#sList").val();
//                $("#id_sunit").val(val);
//                $("#id_sunit").trigger("change");

                var val = $("#progress").val();
                $("#filter-status").val(val);
                $("#filter-status").trigger("change");
                oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
                table.draw();
                reCount();
                oSettings[0]._iDisplayLength = 20;
                table.draw();
                return false;

            });

        });

        function clearFilter() {
            $('input[name="source"]').val("");
            $('input[name="conductor"]').val("");
            $("#fList").val(0).trigger('change');
            $("#sList").val(0).trigger('change');
            $("#progress").val(0).trigger('change');
            $('input[name="steertime_from"]').val("");
            $('input[name="steertime_to"]').val("");
            $('input[name="deadline_from"]').val("");
            $('input[name="deadline_to"]').val("");

            $('input:radio[name=psource]').prop('checked', false);
            $('input:radio[name=pviphuman]').prop('checked', false);
            $('input:radio[name=pfunit]').prop('checked', false);
            $('input:radio[name=psunit]').prop('checked', false);

            $("#form").submit();
        }

        $(".select-multiple").select2();
        $(".select2-container").css("width", "auto");
        $("#filter-container").show();
    </script>
    <script>
        //loc theo trang thai
        function reCount(showstatus) {
            console.log(showstatus);
            showstatus = showstatus || false;
            if (!showstatus) {
                $(".count-st").each(function () {
                    $(this).html($('.' + $(this).attr('id')).length);
                });
            }
            var v1 = $('.row-st-1').length + $('.row-st-5').length;
            var v2 = $('.row-st-4').length;
            var v3 = $('.row-st-2').length;
            var v4 = $('.row-st-3').length;
            var v5 = $('.row-st-6').length;
            $("#btn-export").attr('href', '{{$_ENV['ALIAS']}}/report/export?v1=' + v1 + "&v2=" + v2 + "&v3=" + v3 + "&v4=" + v4 + "&v5=" + v5 + "&f=" + getFilterString() + "");
            reloadDataExport();
        }
        function getFilterString() {
            var filter = "";
            if ($("#source").val() != "") {
                filter += "Nguồn chỉ đạo: " + $("#source").val() + "; "
            }
            if ($("#conductor").val() != "") {
                filter += "{{env('LD_SHORT')}}: " + $("#conductor").val() + "; "
            }
            if ($("#fList").val() != "") {
                filter += "Đơn vị đầu mối: " + $("#fList").val() + "; "
            }
            if ($("#sList").val() != "") {
                filter += "Đơn vị phối hợp: " + $("#sList").val() + "; "
            }
            if ($("#steertime_from").val() != "" || $("#steertime_to").val() != "") {
                filter += "Ngày chỉ đạo";
                if ($("#steertime_from").val() != "") {
                    filter += " từ " + $("#steertime_from").val();
                }
                if ($("#steertime_to").val() != "") {
                    filter += " đến " + $("#steertime_to").val();
                }
                filter += "; "
            }
            if ($("#deadline_from").val() != "" || $("#deadline_to").val() != "") {
                filter += "Thời hạn hoàn thành";
                if ($("#deadline_from").val() != "") {
                    filter += " từ " + $("#deadline_from").val();
                }
                if ($("#deadline_to").val() != "") {
                    filter += " đến " + $("#deadline_to").val();
                }
                filter += "; "
            }
            console.log("status: " + $("#progress").val());
            if ($("#progress").val() != "") {
//                filter += "Tiến độ: " + $("#progress").val();
                filter += "Tiến độ: " + $("#progress option:selected").text();
            }
            return filter;
        }
        function filterStatus(status) {
            $("#progress").val(status);
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

        input.datepicker {
            max-width: 120px;
        }

        .select2 .select2-container {
            width: auto !important;
        }

        .input-contain {
            display: inline-block;
        }

        .search-box {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        label {
            width: 180px !important;
        }

        @media screen and (max-width: 600px) {
            .mi {
                width: 85%;
            }

            .input-contain {
                width: 100%;
            }

            .fl {
                float: left;
            }

            .form-group {
                margin-bottom: 5px;
            }

            .select2-container {
                min-width: 85% !important;
            }

            .ml10 {
                margin-left: 10px;
            }
        }
    </style>

@stop