
@extends('layout1')

@section('page-title')
    Cập nhật Nhiệm vụ
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm mới nhiệm vụ</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif
    @foreach ($data as $row)
    {!! Form::open(array('id' => 'steeringcontent-update', 'route' => 'steeringcontent-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'id')) }}

    <div class="form-group ">
        <label>Tên nhiệm vụ: <span class="required">(*)</span></label>
        {!! Form::textarea('content', $row->content,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung chỉ đạo',
                  'rows'=>'2')) !!}
    </div>

    {{--<div class="form-group form-inline">--}}
        {{--<label>Nguồn chỉ đạo: <span class="required">(*)</span></label>--}}
        {{--<select id="msource" name="msource[]" class="form-control select-multiple ipw" multiple="multiple" required>--}}
            {{--@foreach($sourcesteering as $sr)--}}
                {{--<option value="{{$sr->code}}" {{in_array($sr->code, explode('|', $row->source))?'selected':''}}>{{$sr->code}}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
        {{--<div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-source"></div>--}}
        {{--<div class="btn btn-default ico ico-add" data-toggle="modal" data-target="#modal-add-source"></div>--}}
    {{--</div>--}}

    <div class="form-group form-inline">
        <label>Nguồn chỉ đạo: <span class="required">(*)</span></label>
        <ul class="list-group">
            @foreach($type as $key => $s)
                <li class="list-group-item noboder">
                    <div class="row">
                        <div class="col-md-2 col-xs-6">
                            <input type="checkbox" name="mtype[]" class="pick-source " value=" {{$key . '|' .$s->id}}" {{ in_array($s->id, $steeringSourceIds) ? "checked" : "" }}>
                            {{$s->name}}
                        </div>
                        <div class="col-md-10 col-xs-6">
                            {!! Form::text('note[]', in_array($s->id, $steeringSourceIds) ? $steeringSourceNotes[$s->id] : "",
                            array('class'=>'form-control', 'placeholder'=>'Ký hiệu')) !!}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="form-group form-inline">
        <label>Người chỉ đạo:<span class="required">(*)</span></label>
        @foreach($viphuman as $v)
            {!! Form::radio('viphuman', $v->id, ($v->name == $row->conductor) ? true : false) !!} {!! $v->name !!}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
    </div>

    <div class="form-group form-inline">
        <label>Phân loại:</label>
        @foreach($priority as $idx => $p)
            <input type="radio" name="priority" value="{{$p->id}}" {{($idx == $row->priority)?'checked':''}}> {{$p->name}} &nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị/Cá nhân chủ trì: <span class="required">(*)</span></label>
        <select id="fList" name="firtunit[]" class="form-control select-multiple ipw" multiple="multiple" required="required">
            @foreach($treeunit as $item)
                @foreach($item->children as $c)
                    <option value="u|{{$c->id}}" {{in_array("u|".$c->id, $dtUnitArr)?"selected":""}}>{{$c->name}}</option>
                @endforeach
            @endforeach
            @foreach($user as $u)
                <option value="h|{{$u->id}}" {{in_array("h|".$u->id, $dtUnitArr)?"selected":""}}>{{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}</option>
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
                <option value="h|{{$u->id}}" {{in_array("u|".$u->id, $dtfollowArr)?"selected":""}}>{{$u->fullname}}{{(isset($dictunit[$u->unit]))? ' - ' . $dictunit[$u->unit]:''}}</option>
            @endforeach
        </select>
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#second-unit"></div>
    </div>
    <div class="form-group  form-inline">
        <label>Ngày chỉ đạo: <span class="required">(*)</span></label>
        {!! Form::text('steer_time', date("d/m/y", strtotime($row->steer_time)),
            array('class'=>'form-control datepicker',
                  'placeholder'=>'Ngày bắt đầu')) !!}
    </div>
    <div class="form-group  form-inline">
        <label>Thời hạn hoàn thành:</label>
        {!! Form::text('deathline', (strtotime($row->deadline) != "")?date("d/m/y", strtotime($row->deadline)):'',
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
        {{--{!! Form::radio('status', 0,($row->status==0)) !!} Đang thực hiện--}}
        {{--{!! Form::radio('status', 1,($row->status==1)) !!} Hoàn thành--}}
        {{--{!! Form::radio('status', -1,($row->status==-1)) !!} Bị hủy--}}

    {{--</div>--}}

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
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
                                <td><input type="checkbox" name="psource" class="pick-source" value="{{$s->code}}" {{in_array($s->code, explode('|', $row->source))?'checked':''}}></td>
                                <td>{{$s->code}}</td>
                                <td>{{$s->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-add-source" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thêm nguồn chỉ đạo:</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route' => 'sourcesteering-addsource', 'class' => 'form', 'files'=>'true', 'id'=>'form-add-source')) !!}
                    <div class="form-group form-inline">
                        <label>Loại nguồn:</label>
                        <select name="type" class="form-control">
                            @foreach($type as $t)
                                <option value="{{$t->id}}">{{$t->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label>Số kí hiệu: <span class="required">(*)</span></label>
                        <input id="new-source-code" type="text" required name="code" class="form-control" value="">
                    </div>
                    <div class="form-group form-inline">
                        <label>Trích yếu: <span class="required">(*)</span></label>
                        <textarea name="name" style="width: 100%;" class="form-control" required></textarea>
                    </div>
                    <div class="form-group form-inline">
                        <label>Ngày ban hành: <span class="required">(*)</span></label>
                        <input id="my-time" name="time" type="text" class="form-control datepicker" required value="">
                    </div>
                    <div class="form-group form-inline">
                        <label>Người ký:</label>
                        <input type="text" name="sign_by" class="form-control" value="">
                    </div>
                    <div class="form-group form-inline">
                        <label style="float: left">File đính kèm:</label>
                        {!! Form::file('docs', array('class'=>'')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Hoàn tất',
                          array('class'=>'btn btn-my')) !!}
                    </div>
                    {!! Form::close() !!}
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

        function valCheckbox()
        {
            var checkboxs = document.getElementsByName("mtype[]");
            var okay = false;
            for(var i=0, l=checkboxs.length; i<l;i++)
            {
                if(checkboxs[i].checked)
                {
                    okay=true;
                    break;
                }
            }
            if(okay){
                return true;
            }
            else{
                alert("Phải chọn ít nhất một nguồn chỉ đạo");
                return false;
            }
        }

        $( document ).ready(function() {
            // Handler for .ready() called.

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

        $('input:checkbox[name=psource]').change(function () {
//            $('input[name="source"]').val($('input[name="psource"]:checked').val())
//            var time = $('input[name="psource"]:checked').attr('data-time');
//            $('input[name="steer_time"]').val(time);
            var arr = [];
            $('input:checkbox[name=psource]:checked').each(function(){
                arr.push($(this).val());
            });
            $("#msource").val(arr).trigger('change');
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

        $(".select-multiple").select2({
            tags: true
        });
        $(".select-single").select2();

        $("#steeringcontent-update").submit(function (e) {
            var check = valCheckbox();
            if(check == false ){
                return false;
            }
        })
        $("#form-add-source").submit(function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var code = $("#new-source-code").val();

            $ (".loader").show();
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
                    if (result.result) {
                        $("#modal-add-source").modal("hide");
                        $('#msource')
                            .append("<option value='" + code + "' selected>" + code + "</option>");
                    }else{
                        alert(result.mess);
                    }
                },
                error: function () {
                    $(".loader").hide();
                    alert("Xảy ra lỗi nội bộ");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@stop