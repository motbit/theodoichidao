@extends('layout1')
@section('page-title')
    {{($id == 0)?"Thêm":"Chỉnh sửa"}} nguồn chỉ đạo
@stop
@section('content')
    <div class="text-center title">{{($id == 0)?"Thêm":"Chỉnh sửa"}} nguồn chỉ đạo</div>
    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    {!! Form::open(array('route' => 'sourcesteering-update', 'class' => 'form', 'files'=>'true')) !!}
    <div class="form-group form-inline">
        <label>Loại nguồn:</label>
        <select name="type" class="form-control">
            @foreach($type as $t)
                <option value="{{$t->id}}" {{($id == 0 || $t->id != $steering->type)?'':'selected'}}>{{$t->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Số kí hiệu: <span class="required">(*)</span></label>
        <input type="text" required name="code" class="form-control" value="{{($id == 0)?"":$steering->code}}">
    </div>
    <div class="form-group form-inline">
        <label>Trích yếu: <span class="required">(*)</span></label>
        <textarea name="name" style="width: 100%;" class="form-control" required>{{($id == 0)?"":$steering->name}}</textarea>
    </div>
    <div class="form-group form-inline">
        <label>Ngày ban hành: <span class="required">(*)</span></label>
        <input id="my-time" name="time" type="text" class="form-control datepicker" required value="{{($id == 0)?"":date("d/m/y", strtotime($steering->time))}}">
    </div>
    <div class="form-group form-inline">
        <label>Người ký:</label>
        <input type="text" name="sign_by" class="form-control" value="{{($id == 0)?"":$steering->sign_by}}">
    </div>
    <div class="form-group form-inline">
        <label style="float: left">File đính kèm:</label>
        {!! Form::file('docs', array('class'=>'')) !!}
    </div>
    <div class="form-group form-inline hidden">
        <label>Hoàn thành:</label>
        <input name="complete" type="checkbox"  class="form-control" {{($id > 0 && $steering->status == 1)?"checked":""}}>
    </div>
    <input name="id" value="{{$id}}" type="hidden">

    <div class="form-group">
        {!! Form::submit('Hoàn tất',
          array('class'=>'btn btn-my')) !!}
    </div>
    {!! Form::close() !!}
    <script>$(document).ready(function () {
        });
    </script>
@stop