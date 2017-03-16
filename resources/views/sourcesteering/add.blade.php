@extends('layout1')
@section('content')
    <h1>{{($id == 0)?"Thêm":"Chỉnh sửa"}} nguồn chỉ đạo</h1>
    {!! Form::open(array('route' => 'sourcesteering-update', 'class' => 'form', 'files'=>'true')) !!}
    <div class="form-group form-inline">
        <label>Nguồn chỉ đạo</label>
        <textarea name="name" style="width: 100%;" class="form-control">{{($id == 0)?"":$steering->name}}</textarea>
    </div>
    <div class="form-group form-inline">
        <label>Loại</label>
        <select name="type" class="form-control">
            @foreach($type as $t)
            <option value="{{$t->id}}" {{($id == 0 || $t->id != $steering->type)?'':'selected'}}>{{$t->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Kí hiệu</label>
        <input type="text" required name="code" class="form-control" value="{{($id == 0)?"":$steering->code}}">
    </div>
    <div class="form-group form-inline">
        <label>Người chủ trì</label>
        <select name="conductor" class="form-control">
            @foreach($conductor as $c)
                <option value="{{$c->id}}" {{($id == 0 || $c->id != $steering->conductor)?'':'selected'}}>{{$c->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>File đính kèm</label>
        {{--<input name="file" type="file" id="file" class="form-control">--}}
        {!! Form::file('docs', array('class'=>'form-control')) !!}
    </div>
    <div class="form-group form-inline">
        <label>Hoàn thành</label>
        <input name="complete" type="checkbox"  class="form-control" {{($id > 0 && $steering->status == 1)?"checked":""}}>
    </div>
    <div class="form-group form-inline">
        <label>Ngày ban hành</label>
        <input name="time" type="date" class="form-control" required value="{{($id == 0)?"":date("d-m-Y", strtotime($steering->time))}}">
    </div>
    <input name="id" value="{{$id}}" type="hidden">

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@stop