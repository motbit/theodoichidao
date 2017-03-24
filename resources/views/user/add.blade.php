@extends('layout1')

@section('page-title')
    Update User
@stop
@section('page-toolbar')
@stop

@section('content')


    <h1>Thêm Người sử dụng</h1>

        @if ( $errors->count() > 0 )
            @foreach( $errors->all() as $message )
                <p  class="alert alert-danger">{{ $message }}</p>
            @endforeach
        @endif


        {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
        <div class="form-group">
            {!! Form::label('username', 'Tên đăng nhập') !!}
            {!! Form::text('username', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Tên đăng nhập')) !!}
        </div>

    <div class="form-group">
        {!! Form::label('password', 'Mật khẩu') !!}
        {!! Form::password('password',
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>' Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>



        <div class="form-group">
            {!! Form::label('fullname', 'Họ & Tên') !!}
            {!! Form::text('fullname', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nhập họ tên người sử dụng')) !!}
        </div>


        <div class="form-group">
            {!! Form::label('group', 'Quyền hạn') !!}
            {!! Form::select('group', $group,
                    array('no-required','class'=>'form-control')
            ) !!}
        </div>

        <div class="form-group">
            {!! Form::label('unit', 'Đơn vị') !!}
            {!! Form::select('unit', $unit,
                    array('no-required','class'=>'form-control')
            ) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}


@stop