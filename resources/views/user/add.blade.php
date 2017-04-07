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
                <p  class="alert alert-danger">{{ $message }}</p>
            @endforeach
        @endif


        {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
        <div class="form-group">
            <label>Tên đăng nhập: <span class="required">(*)</span></label>
            {!! Form::text('username', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Tên đăng nhập')) !!}
        </div>

    <div class="form-group">
        <label>Mật khẩu: <span class="required">(*)</span></label>
        {!! Form::password('password',
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>' Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>



        <div class="form-group">
            <label>Họ & tên: <span class="required">(*)</span></label>
            {!! Form::text('fullname', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nhập họ tên người sử dụng')) !!}
        </div>


        <div class="form-group">
            <label>Quyền hạn:</label>
            {!! Form::select('group', $group,
                    array('no-required','class'=>'form-control')
            ) !!}
        </div>

        <div class="form-group">
            <label>Đơn vị:</label>
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