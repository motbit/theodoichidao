@extends('layout1')
@section('page-title')
    Cập nhật quyền
@stop
@section('content')
    <div class="text-center title">Cập nhật quyền</div>
    <h4 class="text-left">
        Nhóm: {{$group->description}}
    </h4>
    @if (Session::has('message'))
        <div class="alert alert-success">{!!  Session::get('message') !!}</div>
    @endif
    {!! Form::open(array('route' => 'group-permission', 'class' => 'form', 'files'=>'true')) !!}
    <input type="hidden" value="{{$id}}" name="id">
    <div class="divider"></div>
    @foreach($dataview as $v)
        <div class="form-group">
            <input type="checkbox" name="view[]" value="{{$v->id}}" id="view-{{$v->id}}" {{(isset($permission[$v->id]))?'checked':''}}>
            <label for="view-{{$v->id}}">{{$v->name}}</label>
            <div class="ml form-group form-inline" style="display: {{(isset($permission[$v->id]))?'block':'none'}}" id="group-{{$v->id}}">
                <?php $action = (explode(")", $v->action));?>
                @foreach($action as $a)
                    @if($a != "")
                        <?php $a = str_replace('(', '', $a);?>
                        <input type="checkbox" value="{{$a}}" name="action-{{$v->id}}[]" id="{{$a}}-{{$v->id}}" {{(isset($permission[$v->id]) && strpos($permission[$v->id]->action, $a) !== false)?'checked':''}}> {{$dictionary[$a]}} &nbsp;&nbsp;&nbsp;
                    @endif
                @endforeach
                <br>
                @if($v->only_auth == 1)
                    <input type="checkbox" name="only-auth-{{$v->id}}" {{(isset($permission[$v->id]) && $permission[$v->id]->only_auth == 0)?'checked':''}}> Truy cập tất cả dữ liệu
                @endif
            </div>
        </div>
        <div class="divider"></div>
    @endforeach
    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}

    <script>
        @foreach($dataview as $v)
            $('#view-{{$v->id}}').change(function() {
            if(this.checked) {
                $("#group-{{$v->id}}").show();
            }else{
                $("#group-{{$v->id}}").hide();
            }
        });
        @endforeach
    </script>
    <style>
        label {
            width: auto !important;
        }

        .ml{
            margin-left: 20px;
        }

        .divider{
            width: 100%;
            height: 1px;
            background-color: #ccc;
            margin-bottom: 10px;
        }
    </style>
@stop