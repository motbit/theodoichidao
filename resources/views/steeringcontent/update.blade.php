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
    @foreach ($unit as $row)
    {!! Form::open(array('route' => 'unit-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'nguoidung_id')) }}
    <div class="form-group">
        {!! Form::label('Tên Ban -  Đơn Vị') !!}
        {!! Form::text('name', $row->name,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên Ban hoặc Đơn vị')) !!}
    </div>


    <div class="form-group">
        {!! Form::label('Tên viết tắc') !!}
        {!! Form::text('shortname', $row->shortname,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tên viết tắt')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Nội dung') !!}
        {!! Form::textarea('description', $row->description,
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Sắp xếp') !!}
        {!! Form::text('order', $row->order,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Sắp xếp')) !!}
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    @endforeach


@stop