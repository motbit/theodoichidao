@extends('layout1')

@section('page-title')
    Thêm mới Ban - Đơn Vị
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm mới Ban / Đơn vị</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p  class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif
    {!! Form::open(array('route' => 'unit-update', 'class' => 'form')) !!}
    <div class="form-group form-inline">
        <label>Tên ban - Đơn vị: <span class="required">(*)</span></label>
        {!! Form::text('name', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nhập tên Ban hoặc Đơn vị')) !!}
    </div>

    <div class="form-group form-inline">
        <label>Tên viết tắt: <span class="required">(*)</span></label>
        {!! Form::text('shortname', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tên viết tắt')) !!}
    </div>

    <div class="form-group form-inline">
        <label>Thuộc Ban - Đơn vị:</label>
        <select name="parent_id" class="form-control">
            @foreach( $unit as $item)
                @if($item->parent_id == 0)
                    <option value="{{$item->id}}" >{{$item->name}}</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {!! Form::label('Nội dung') !!}
        {!! Form::textarea('description', "",
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung')) !!}
    </div>


    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}


@stop