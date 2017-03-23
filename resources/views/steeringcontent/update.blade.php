
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
        <select id="fList" name="firtunit" class="form-control select-single ipw">
            @foreach($treeunit as $item)
                @foreach($item->children as $c)
                    <option {{($row->unit == $c->id) ? 'selected' : ''}}  value="{{$c->id}}" >{{$c->name}}</option>
                @endforeach
            @endforeach
        </select>
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#firt-unit"></div>
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị/Cá nhân phối hợp:</label>
        <select id="sList" name="secondunit[]" class="form-control select-multiple ipw" multiple="multiple">
            @foreach($treeunit as $item)
                @foreach($item->children as $c)
                    <option value="{{$c->id}}" >{{$c->name}}</option>
                @endforeach
            @endforeach
        </select>
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#second-unit"></div>
    </div>

    <div class="form-group  form-inline">
        <label>Thời hạn hoàn thành:</label>
        {!! Form::text('deathline', date("d-m-Y", strtotime($row->deadline)),
            array('required',
                  'class'=>'form-control datepicker',
                  'placeholder'=>'Thời gian hoàn thành')) !!}
    </div>

    <div class="form-group  form-inline">
        <label>Ngày chỉ đạo:</label>
        {!! Form::text('steer_time', date("d-m-Y", strtotime($row->steer_time)),
            array('required',
                  'class'=>'form-control datepicker',
                  'placeholder'=>'Ngày bắt đầu')) !!}
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
                    <div class="panel-group">
                        @foreach($treeunit as $idx=>$u)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse{{$u->id}}"> {{$u->name}}</a>
                                    </h4>
                                </div>

                                <div id="collapse{{$u->id}}" class="panel-collapse collapse in">
                                    <ul class="list-group">
                                        @foreach($u->children as $c)
                                            <li class="list-group-item">
                                                <input {{($row->unit == $c->id) ? "checked" : ""}} type="radio" name="pfunit" class="pick-firt-unit" value="{{$c->id}}">
                                                {{$c->name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
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
                    <div class="panel-group">
                        @foreach($treeunit as $idx=>$u)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse2{{$u->id}}"> {{$u->name}}</a>
                                    </h4>
                                </div>

                                <div id="collapse2{{$u->id}}" class="panel-collapse collapse in">
                                    <ul class="list-group">
                                        @foreach($u->children as $c)
                                            <li class="list-group-item">
                                                <input {{ in_array($c->id, $dtfollowArr) ? "checked" : "" }} type="checkbox" name="psunit" class="pick-firt-unit" value="{{$c->id}}">
                                                {{$c->name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/jquery-ui.js"></script>
    <link href="/css/jquery-ui.css" rel="stylesheet">

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

            var arr = [{{$dtfollow}}];
            $("#sList").val(arr).trigger('change');
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

        $('input:radio[name=pfunit]').change(function () {
            var id = $('input[name="pfunit"]:checked').val();
            $("#fList").val(id).trigger('change');
//            $('#fList option[value=' + id +']').attr('selected','selected');
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

        $('#fList').change(function() {
            var val = $("#fList option:selected").val();
            $("input:radio[name=pfunit][value=" + val + "]").attr('checked', true);
        });

        $('#sList').on("select2:select", function(event) {
            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=psunit][value="' + i + '"]').attr('checked',true);
            });
        });

        $("#sList").on("select2:unselect", function (event) {
            $('input:checkbox[name=psunit]').attr('checked',false);

            $(event.currentTarget).find("option:selected").each(function(i, selected){
                i = $(selected).val();
                $('input:checkbox[name=psunit][value="' + i + '"]').attr('checked',true);
            });
        });

        $(".select-multiple").select2();
        $(".select-single").select2();
    </script>
@stop