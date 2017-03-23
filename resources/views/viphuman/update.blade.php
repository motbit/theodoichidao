@extends('layout1')

@section('page-title')
    Sửa thông tin người chủ trì
@stop

@section('content')
    <div class="text-center title">Sửa thông tin người chủ trì</div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @foreach ($nguoidung as $row)
        {!! Form::open(array('route' => 'viphuman-update', 'class' => 'form')) !!}
        {{ Form::hidden('id', $row->id, array('id' => 'nguoidung_id')) }}
        <div class="form-group">
            <label>Họ tên:</label>
            {!! Form::text('name', $row->name,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Họ tên')) !!}
        </div>

        <div class="form-group">
            <label>Chức vụ:</label>
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
    @endforeach


@stop