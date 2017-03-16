@extends('layout1')

@section('page-title')
    Update User
@stop
@section('page-toolbar')
@stop

@section('content')

    <h1>Add User</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
        {!! Form::open(array('route' => 'user-update', 'class' => 'form')) !!}
        <div class="form-group">
            {!! Form::label('Username') !!}
            {!! Form::text('username', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Your name')) !!}
        </div>

    <div class="form-group">
        {!! Form::label('Password') !!}
        {!! Form::password('password', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'password')) !!}
    </div>

        <div class="form-group">
            {!! Form::label('Tên đầy đủ') !!}
            {!! Form::text('fullname', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nhập tên')) !!}
        </div>


        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}


@stop