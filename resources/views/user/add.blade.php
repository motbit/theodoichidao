@extends('layout1')

@section('page-title')
    Update User
@stop
@section('page-toolbar')
@stop

@section('content')

    <h1>Thêm người dùng</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
    <div class="form-group form-inline">
        {!! Form::label('Tên tài khoản') !!}
        {!! Form::text('username', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên đăng nhập')) !!}
    </div>

    <div class="form-group form-inline">
        {!! Form::label('Mật khẩu') !!}
        <input type="password" name="password" class="form-control" required>
    </div>



    <div class="form-group form-inline">
        {!! Form::label('Tên đầy đủ') !!}
        {!! Form::text('fullname', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập họ tên người sử dụng')) !!}
    </div>


    <div class="form-group form-inline">
        {!! Form::label('Quyền hạn') !!}
        {!! Form::select('group', $group, "",
                array('no-required','class'=>'form-control')
        ) !!}
    </div>

    <div class="form-group form-inline">
        {!! Form::label('Đơn vị') !!}
        {!! Form::select('unit', $unit, "",
                array('no-required','class'=>'form-control')
        ) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop