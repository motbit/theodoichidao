
@extends('layout1')

@section('page-title')
    Cập nhật Nhiệm vụ
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm mới nhiệm vụ</div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @foreach ($data as $row)
    {!! Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'id')) }}

    <div class="form-group ">
        <label>Tên nhiệm vụ:</label>
        {!! Form::textarea('content', $row->content,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung chỉ đạo',
                  'rows'=>'2')) !!}
    </div>

    <div class="form-group form-inline">
        <label>Nguồn chỉ đạo:</label>
        {!! Form::text('source', $row->source,
                array('no-required',
                'placeholder'=>'Nguồn chỉ đạo',
                'class'=>'form-control ipw', 'id'=>'source')
        ) !!}
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-source"></div>
    </div>

    <div class="form-group form-inline">
        <label>Người chỉ đạo:</label>
        {!! Form::text('viphuman', $row->conductor,
                array('no-required',
                'placeholder'=>'Người chỉ đạo',
                'class'=>'form-control ipw', 'id'=>'viphuman')
        ) !!}
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-viphuman"></div>
    </div>

    <div class="form-group form-inline">
        <label>Phân loại:</label>
        @foreach($priority as $idx => $p)
            <input type="radio" name="priority" value="{{$p->id}}" {{($idx == $row->priority)?'checked':''}}> {{$p->name}} &nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị/Cá nhân chủ trì:</label>
        <select id="fList" name="firtunit[]" class="form-control select-multiple ipw" multiple="multiple" required="required">
            @foreach($treeunit as $item)
                @foreach($item->children as $c)
                    <option value="u|{{$c->id}}" {{in_array("u|".$c->id, $dtUnitArr)?"selected":""}}>{{$c->name}}</option>
                @endforeach
            @endforeach
            @foreach($user as $u)
                <option value="h|{{$u->id}}" {{in_array("h|".$u->id, $dtUnitArr)?"selected":""}}>{{$u->fullname}}</option>
            @endforeach
        </select>
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#firt-unit"></div>
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị/Cá nhân phối hợp:</label>
        <select id="sList" name="secondunit[]" class="form-control select-multiple ipw" multiple="multiple">
            @foreach($treeunit as $item)
                @foreach($item->children as $c)
                    <option value="u|{{$c->id}}" {{in_array("u|".$c->id, $dtfollowArr)?"selected":""}}>{{$c->name}}</option>
                @endforeach
            @endforeach
            @foreach($user as $u)
                <option value="h|{{$u->id}}" {{in_array("u|".$u->id, $dtfollowArr)?"selected":""}}>{{$u->fullname}}</option>
            @endforeach
        </select>
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#second-unit"></div>
    </div>
    <div class="form-group  form-inline">
        <label>Ngày chỉ đạo:</label>
        {!! Form::text('steer_time', date("d-m-Y", strtotime($row->steer_time)),
            array('class'=>'form-control datepicker',
                  'placeholder'=>'Ngày bắt đầu')) !!}
    </div>
    <div class="form-group  form-inline">
        <label>Thời hạn hoàn thành:</label>
        {!! Form::text('deathline', (strtotime($row->deadline) != "")?date("d-m-Y", strtotime($row->deadline)):'',
            array('class'=>'form-control datepicker',
                  'placeholder'=>'Thời gian hoàn thành')) !!}
    </div>

    {{--<div class="form-group">--}}
        {{--{!! Form::label('Đơn vị xác nhận:') !!}--}}
        {{--<ul>--}}
            {{--<li>{!! Form::radio('confirm', 'C',($row->xn=='C')) !!} Đơn vị chưa xác nhận</li>--}}
            {{--<li>{!! Form::radio('confirm', 'X',($row->xn=='X')) !!} Đơn vị đã xác nhận</li>--}}
            {{--<li>{!! Form::radio('confirm', 'K',($row->xn=='K')) !!} Đơn vị không nhận</li>--}}
        {{--</ul>--}}

    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--{!! Form::label('Theo dõi của văn phòng:') !!}--}}
        {{--{!! Form::textarea('note', $row->note,--}}
            {{--array('no-required',--}}
                  {{--'class'=>'form-control',--}}
                  {{--'placeholder'=>'Theo dõi của văn phòng')) !!}--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--{!! Form::label('Đánh giá') !!}--}}
        {{--{!! Form::radio('status', 0,($row->status==0)) !!} Chưa hoàn thành--}}
        {{--{!! Form::radio('status', 1,($row->status==1)) !!} Hoàn thành--}}
        {{--{!! Form::radio('status', -1,($row->status==-1)) !!} Bị hủy--}}

    {{--</div>--}}

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}
    @endforeach

    <div id="modal-source" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách nguồn chỉ đạo:</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @foreach($sourcesteering as $s)
                            <tr>
                                <td><input type="radio" name="psource" class="pick-source" value="{{$s->code}}" data-time="{{date("d-m-Y", strtotime($s->time))}}"></td>
                                <td>{{$s->code}}</td>
                                <td>{{$s->name}}</td>
                            </tr>
                        @endforeach
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
                    <h4 class="modal-title">Danh sách người chỉ đạo</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @foreach($viphuman as $v)
                            <tr>
                                <td><input type="radio" name="pviphuman" class="pick-source" value="{{$v->id}}"  data-name="{{$v->name}}"></td>
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
                    <h4 class="modal-title">Danh sách đơn vị</h4>
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
                                                           value="u|{{$c->id}}" parent-id="{{$u->id}}" {{in_array("u|".$c->id, $dtUnitArr)?"checked":""}}>
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
                                @foreach($user as $u)
                                    <li class="list-group-item">
                                        {{--<input type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">--}}
                                        <input type="checkbox" name="pfunit" class="pick-firt-unit"
                                               value="h|{{$u->id}}" {{in_array("h|".$u->id, $dtUnitArr)?"checked":""}}>
                                        {{$u->fullname}}
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
                    <h4 class="modal-title">Danh sách đơn vị</h4>
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
                                                           value="u|{{$c->id}}" parent-id="{{$u->id}}" {{in_array("u|".$c->id, $dtfollowArr)?"checked":""}}>
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
                                @foreach($user as $u)
                                    <li class="list-group-item">
                                        {{--<input type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">--}}
                                        <input type="checkbox" name="psunit" class="pick-firt-unit"
                                               value="h|{{$u->id}}" {{in_array("h|".$u->id, $dtfollowArr)?"checked":""}}>
                                        {{$u->fullname}}
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


        $( document ).ready(function() {
            // Handler for .ready() called.
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                dateFormat: 'dd-mm-yy',
            });

            $( "#source" ).autocomplete({
                source: sources
            });

            $( "#viphuman" ).autocomplete({
                source: viphumans
            });

            var dtfollow = [{{$data[0]['follow']}}]
            var dtunit = [{{$data[0]['unit']}}]
            $("#sList").val(dtfollow).trigger('change');
            $("#fList").val(dtunit).trigger('change');
        });

        $('input:radio[name=psource]').change(function () {
            $('input[name="source"]').val($('input[name="psource"]:checked').val())
            var time = $('input[name="psource"]:checked').attr('data-time');
            $('input[name="steer_time"]').val(time);
        });

        $('input[name="source"]').change(function() {
            var val = $('input[name="source"]').val();
            alert(val);
            $('input:radio[name=psource][value="' + val + '"]').attr('checked',true);
        });

        $('input:radio[name=pviphuman]').change(function () {
            var name = $('input[name="pviphuman"]:checked').attr('data-name');
            $('input[name="viphuman"]').val(name);
        });

        $('input[name="viphuman"]').change(function() {
            var val = $('input[name="viphuman"]').val();
            $('input:radio[name=pviphuman][data-name="' + val + '"]').attr('checked',true);
        });

//        $('input:radio[name=pfunit]').change(function () {
//            var id = $('input[name="pfunit"]:checked').val();
//            $("#fList").val(id).trigger('change');
////            $('#fList option[value=' + id +']').attr('selected','selected');
//        });
        $('input:checkbox[name=pfunit]').change(function () {
            var arr = [];
            var vl = '';
            $('input:checkbox[name=pfunit]:checked').each(function(){
                vl = $(this).val();
                arr.push(vl);
            });
            $("#fList").val(arr).trigger('change');
        });
        $('input:checkbox[name=pfunit-parent]').change(function () {
            var id = $(this).val();
            if(!$(this).is(":checked")){
                $("input:checkbox[name=pfunit][parent-id=" + id + "]").prop('checked', false);
            }else {
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
            $('input:checkbox[name=psunit]:checked').each(function(){
                vl = $(this).val();
                arr.push(vl);
            });
            $("#sList").val(arr).trigger('change');
        });

        $('input:checkbox[name=psunit-parent]').change(function () {
            var id = $(this).val();
            if(!$(this).is(":checked")){
                $("input:checkbox[name=psunit][parent-id=" + id + "]").prop('checked', false);
            }else {
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

//        $('#fList').change(function() {
//            var val = $("#fList option:selected").val();
//            $("input:radio[name=pfunit][value=" + val + "]").attr('checked', true);
//        });

        $('#fList').on("select2:select", function(event) {
            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=pfunit][value="' + i + '"]').attr('checked',true);
            });
        });
        $("#fList").on("select2:unselect", function (event) {
            $('input:checkbox[name=pfunit]').prop('checked',false);

            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=pfunit][value="' + i + '"]').prop('checked',true);
            });
        });

        $('#sList').on("select2:select", function(event) {
            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=psunit][value="' + i + '"]').attr('checked',true);
            });
        });

        $("#sList").on("select2:unselect", function (event) {
            $('input:checkbox[name=psunit]').prop('checked',false);

            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=psunit][value="' + i + '"]').prop('checked',true);
            });
        });

        $(".select-multiple").select2();
        $(".select-single").select2();
    </script>
@stop