@extends('layout1')

@section('page-title')
    Thêm người chủ trì
@stop
@section('page-toolbar')
@stop

@section('content')

    <h1>Thêm người chủ trì</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {!! Form::open(array('route' => 'viphuman-update', 'class' => 'form')) !!}
    <div class="form-group">
        {!! Form::label('Họ tên') !!}
        {!! Form::text('name', '',
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Họ tên')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Chức vụ') !!}
        <select class="select2 form-control" name="function">
            @foreach ($functions as $item)
                <option value="{{ $item->id }}">{{ $item->description }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop