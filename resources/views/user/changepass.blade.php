@extends('layout1')

@section('page-title')
    Update User
@stop

@section('content')
    <div class="text-center title">Cập nhật thông tin Người sử dụng</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    <div id="err">
        @if (Session::has('message'))
            <div class="alert alert-danger">{!!  Session::get('message') !!}</div>
        @endif
    </div>

    {!! Form::open(array('route' => 'user-changepass', 'class' => 'form')) !!}
    {{ Form::hidden('id', $id, array('id' => 'id')) }}


    <div class="form-group">
        <label>Mật khẩu cũ: <span class="required">(*)</span></label>
        {!! Form::password('old-password',
            array(
            'required',
                  'class'=>'form-control',
                  'placeholder'=>'Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>

    <div class="form-group">
        <label>Mật khẩu mới: <span class="required">(*)</span></label>
        {!! Form::password('password',
            array(
            'required',
                  'class'=>'form-control',
                  'placeholder'=>'Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>

    <div class="form-group">
        <label>Nhập lại mật khẩu: <span class="required">(*)</span></label>
        {!! Form::password('confirm-password',
            array(
            'required',
                  'class'=>'form-control',
                  'placeholder'=>'Mật khẩu ít nhất 6 ký tự.')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    <script>
        $("form").submit(function (event) {
            var pass = $('input[name="password"]').val();
            var confirmpass = $('input[name="confirm-password"]').val();
            if (pass != confirmpass) {
                var myDiv = document.getElementById("err");
                myDiv.innerHTML = '<div class="alert alert-danger"> Mật khẩu mới không khớp</div>';
                return false;
            }
        });
    </script>

@stop