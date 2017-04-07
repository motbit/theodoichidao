@extends('layout1')
@section('page-title')
    {{($id == 0)?"Thêm":"Chỉnh sửa"}} Loại nguồn chỉ đạo
@stop
@section('content')
    <div class="text-center title">Thêm loại nguồn chỉ đạo</div>
    {!! Form::open(array('route' => 'type-update', 'class' => 'form', 'files'=>'true')) !!}
    <input type="hidden" value="{{$id}}" name="id">
    <div class="form-group form-inline">
        <label>Loại nguồn:</label>
        <input required name="name" type="text" class="form-control" style="width: 300px" placeholder="Loại nguồn chỉ đạo" value="{{($id > 0)?$type[0]->name:''}}">
    </div>
    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}
@stop