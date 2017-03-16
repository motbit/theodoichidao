@extends('layout1')
@section('content')
    <h1>Thêm nguồn chỉ đạo</h1>
    {!! Form::open(array('route' => 'sourcesteering-update', 'class' => 'form', 'files'=>'true')) !!}
    <div class="form-group form-inline">
        <label>Nguồn chỉ đạo</label>
        <textarea name="name" style="width: 100%;" class="form-control"></textarea>
    </div>
    <div class="form-group form-inline">
        <label>Loại</label>
        <select name="type" class="form-control">
            @foreach($type as $t)
            <option value="{{$t->id}}">{{$t->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-inline">
        <label>Kí hiệu</label>
        <input type="text" required name="code" class="form-control">
    </div>
    <div class="form-group form-inline">
        <label>Kí hiệu</label>
        <select name="conductor" class="form-control">
            @foreach($conductor as $c)
                <option value="{{$c->id}}">{{$c->name}}</option>
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
        <input name="complete" type="checkbox"  class="form-control">
    </div>
    <div class="form-group form-inline">
        <label>Ngày ban hành</label>
        <input name="time" type="date" class="form-control" required>
    </div>
    <input name="id" value="0" type="hidden">

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@stop