
@extends('layout1')

@section('page-title')
    Thêm mới Ban - Đơn Vị
@stop
@section('page-toolbar')
@stop

@section('content')

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @foreach ($data as $row)
        {!! Form::open(array('route' => 'xuly-updatecv', 'class' => 'form')) !!}
        {{ Form::hidden('id', $row->id, array('id' => 'id')) }}

        <div class="form-group">
            {!! Form::label('Theo dõi của văn phòng') !!}
            {!! Form::textarea('note', $row->note,
                array('no-required',
                      'class'=>'form-control',
                      'placeholder'=>'Theo dõi của văn phòng')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Đánh giá') !!}
            {!! Form::radio('status', 0,($row->status==0)) !!} Đang thực hiện
            {!! Form::radio('status', 1,($row->status==1)) !!} Hoàn thành

        </div>


        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}
    @endforeach

@stop