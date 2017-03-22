@extends('layout1')

@section('page-title')
    Thêm mới nhiệm vụ
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm nhiệm vụ mới</div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {!! Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')) !!}

    <div class="form-group ">
        <label>Tên nhiệm vụ:</label>
        {!! Form::textarea('content', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung chỉ đạo',
                  'rows'=>'2')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Nguồn chỉ đạo:</label>
        {!! Form::text('source', "",
                array('no-required',
                'placeholder'=>'Nguồn chỉ đạo',
                'class'=>'form-control ipw', 'id'=>'source')
        ) !!}
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-source"></div>
    </div>
    <div class="form-group form-inline">
        <label>Người chỉ đạo:</label>
        {!! Form::text('viphuman', "",
                array('no-required',
                'placeholder'=>'Người chỉ đạo',
                'class'=>'form-control ipw', 'id'=>'viphuman')
        ) !!}
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-viphuman"></div>
    </div>
    <div class="form-group form-inline">
        <label>Phân loại:</label>
        @foreach($priority as $idx=>$p)
            <input type="radio" name="priority" value="{{$p->id}}" {{($idx == 0)?'checked':''}}> {{$p->name}} &nbsp;&nbsp;&nbsp;&nbsp;
        @endforeach
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị/Cá nhân chủ trì:</label>
        <select id="fList" name="firtunit" class="form-control select-single ipw">
            @foreach($treeunit as $item)
                    @foreach($item->children as $c)
                        <option value="{{$c->id}}" >{{$c->name}}</option>
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
        {!! Form::text('deathline', "",
            array('required',
                  'class'=>'form-control datepicker',
                  'placeholder'=>'Thời gian hoàn thành')) !!}
    </div>

    <div class="form-group  form-inline">
        <label>Ngày chỉ đạo:</label>
        {!! Form::text('steer_time', "",
            array('required',
                  'class'=>'form-control datepicker',
                  'placeholder'=>'Ngày bắt đầu')) !!}
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}

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
        <div class="modal-dialog" style="min-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách đơn vị</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        @foreach($treeunit as $idx=>$u)
                            <li class="{{($idx == 0)?'active':''}}"><a data-toggle="tab"
                                                                       href="#first-{{$u->id}}">{{$u->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($treeunit as $idx=>$u)
                            <div id="first-{{$u->id}}" class="tab-pane fade in {{($idx == 0)?'active':''}}">
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>Tên Ban - Đơn vị</th>
                                        <th>Tên viết tắt</th>
                                    </tr>
                                    @foreach($u->children as $c)
                                        <tr>
                                            <td><input type="radio" name="pfunit" class="pick-firt-unit"
                                                       value="{{$c->id}}"></td>
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->shortname}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="second-unit" class="modal fade" role="dialog">
        <div class="modal-dialog" style="min-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách đơn vị</h4>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        @foreach($treeunit as $idx=>$u)
                            <li class="{{($idx == 0)?'active':''}}"><a data-toggle="tab"
                                                                       href="#sc-{{$u->id}}">{{$u->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($treeunit as $idx=>$u)
                            <div id="sc-{{$u->id}}" class="tab-pane fade in {{($idx == 0)?'active':''}}">
                                <table class="table table-bordered">
                                    <tr>
                                        <th></th>
                                        <th>Tên Ban - Đơn vị</th>
                                        <th>Tên viết tắt</th>
                                    </tr>
                                    @foreach($u->children as $c)
                                        <tr>
                                            <td><input type="checkbox" name="psunit" class="pick-firt-unit"
                                                       value="{{$c->id}}"></td>
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->shortname}}</td>
                                        </tr>
                                    @endforeach
                                </table>
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
        var unitname = [
            @foreach($unit as $u)
                    '{{$u->name}}',
            @endforeach
        ];
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        function getCurrentDate(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10){
                dd='0'+dd;
            }
            if(mm<10){
                mm='0'+mm;
            }
            var today = dd+'-'+mm+'-'+yyyy;
            return today;
        }
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                dateFormat: 'dd-mm-yy',
            });
            $('input[name="steer_time"]').val(getCurrentDate());
            $( "#source" ).autocomplete({
                source: sources
            });
            $( "#viphuman" ).autocomplete({
                source: viphumans
            });
//            $( "#funit" ).autocomplete({
//                source: unitname
//            });

//            $( "#sunit" ).on( "keydown", function( event ) {
//                if ( event.keyCode === $.ui.keyCode.TAB &&
//                        $( this ).autocomplete( "instance" ).menu.active ) {
//                    event.preventDefault();
//                }
//            })
//                    .autocomplete({
//                        minLength: 0,
//                        source: function( request, response ) {
//                            // delegate back to autocomplete, but extract the last term
//                            response( $.ui.autocomplete.filter(
//                                    unitname, extractLast( request.term ) ) );
//                        },
//                        focus: function() {
//                            // prevent value inserted on focus
//                            return false;
//                        },
//                        select: function( event, ui ) {
//                            var terms = split( this.value );
//                            // remove the current input
//                            terms.pop();
//                            // add the selected item
//                            terms.push( ui.item.value );
//                            // add placeholder to get the comma-and-space at the end
//                            terms.push( "" );
//                            this.value = terms.join( "," );
//                            return false;
//                        }
//                    });
        });
        $('input:radio[name=psource]').change(function () {
            $('input[name="source"]').val($('input[name="psource"]:checked').val())
            var time = $('input[name="psource"]:checked').attr('data-time');
            $('input[name="steer_time"]').val(time);
        });

        $('input[name="source"]').change(function() {
            var val = $('input[name="source"]').val();
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
            $('#fList option[value=' + id +']').attr('selected','selected');
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
            $('input:radio[name=pfunit][value="' + val + '"]').attr('checked',true);
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
    <style>
        .ipw{
            width: 300px !important;
        }
        .select2{
            width: 300px !important;
        }
    </style>
@stop