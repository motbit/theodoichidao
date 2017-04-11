@extends('layout1')
@section('page-title')
    {{($id == 0)?"Thêm":"Chỉnh sửa"}} nhóm người sử dụng
@stop
@section('content')
    <div class="text-center title">{{($id == 0)?"Thêm":"Chỉnh sửa"}} nhóm người sử dụng</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'group-update', 'class' => 'form', 'files'=>'true')) !!}
    <input type="hidden" value="{{$id}}" name="id">
    <div class="form-group form-inline">
        <label>Tên nhóm:</label>
        <input required name="description" type="text" class="form-control" style="width: 300px" placeholder="Tên nhóm người sử dụng" value="{{($id > 0)?$data[0]->description:''}}">
    </div>
    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}
@stop