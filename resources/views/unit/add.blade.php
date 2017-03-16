@extends('layout1')

@section('page-title')
    Thêm mới Ban - Đơn Vị
@stop
@section('page-toolbar')
@stop

@section('content')

    <h1>Thêm mới Ban - Đơn Vị</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
        {!! Form::open(array('route' => 'unit-update', 'class' => 'form')) !!}
        <div class="form-group">
            {!! Form::label('Tên Ban -  Đơn Vị') !!}
            {!! Form::text('name', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nhập tên Ban hoặc Đơn vị')) !!}
        </div>

    <div class="form-group">
        {!! Form::label('Tên viết tắc') !!}
        {!! Form::text('shortname', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tên viết tắt')) !!}
    </div>

        <div class="form-group">
            {!! Form::label('Nội dung') !!}
            {!! Form::textarea('description', "",
                array('no-required',
                      'class'=>'form-control',
                      'placeholder'=>'Nội dung')) !!}
        </div>

    <div class="form-group">
        {!! Form::label('Sắp xếp') !!}
        {!! Form::text('order', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Sắp xếp')) !!}
    </div>

        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}


@stop