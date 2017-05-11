@extends('layout1')

@section('page-title')
    Update User
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm người sử dụng</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif


    {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
    <div class="form-group form-inline">
        <label>Tên đăng nhập: <span class="required">(*)</span></label>
        {!! Form::text('username', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tên đăng nhập')) !!}
    </div>

    <div class="form-group form-inline">
        <label>Mật khẩu: <span class="required">(*)</span></label>
        {!! Form::password('password',
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>' Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>



    <div class="form-group form-inline">
        <label>Họ & tên: <span class="required">(*)</span></label>
        {!! Form::text('fullname', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập họ tên người sử dụng')) !!}
    </div>


    <div class="form-group form-inline">
        <label>Quyền hạn:</label>
        <select name="group" class="form-control select-single" style="max-width: 200px">
            @foreach($group as $key=>$v)
                <option value="{{$key}}">{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-inline">
        <label>Đơn vị:</label>
        <select name="unit" class="form-control select-single ipw" style="max-width: 200px">
            @foreach($unit as $key=>$v)
                <option value="{{$key}}">{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-inline">
        <label>Thư kí của:</label>
        <select name="conductor" class="form-control select-single ipw" style="max-width: 200px">
            <option value=""></option>
            @foreach($viphuman as $key=>$v)
                <option value="{{$v->id}}">{{$v->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}
    <script>
        $(".select-single").select2();
    </script>
@stop