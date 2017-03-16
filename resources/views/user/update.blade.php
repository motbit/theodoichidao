@extends('layout1')

@section('page-title')
    Update User
@stop

@section('content')

    <h1>Update User</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @foreach ($nguoidung as $row)
    {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'nguoidung_id')) }}
    <div class="form-group">
        {!! Form::label('Username') !!}
        {!! Form::text('username', $row->username,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Your name')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Mật khẩu') !!}
        {!! Form::password('password', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'password')) !!}
        <em>* Để trống nếu không thay đổi. * Yêu cầu mật khẩu ít nhất 6 ký tự.</em>
    </div>



    <div class="form-group">
        {!! Form::label('Tên đầy đủ') !!}
        {!! Form::text('fullname', $row->fullname,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Quyền hạn') !!}
        {!! Form::select('group', $group, $row->group,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Đơn vị') !!}
        {!! Form::select('unit', $unit, $row->unit,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    @endforeach


@stop