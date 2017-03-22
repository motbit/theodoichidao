@extends('layout1')

@section('page-title')
    Update User
@stop

@section('content')

    <h1>Cập nhật thông tin người sử dụng</h1>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="bg-danger">{{ $message }}</p>
        @endforeach
    @endif

    @foreach ($nguoidung as $row)
    {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'nguoidung_id')) }}
    <div class="form-group">
        {!! Form::label('Tên đăng nhập') !!}
        {!! Form::text('username', $row->username,
            array('readonly',
                  'class'=>'form-control',
                  'placeholder'=>'Tên đăng nhập')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Mật khẩu') !!}
        {!! Form::password('password',
            array(
                  'class'=>'form-control',
                  'placeholder'=>'Mật khẩu ít nhất 6 ký tự.')) !!}
        <em>* Để trống nếu không thay đổi.</em>
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