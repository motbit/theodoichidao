
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
    {!! Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')) !!}
    {{ Form::hidden('id', $row->id, array('id' => 'id')) }}

    <div class="form-group">
        {!! Form::label('Nội dung chỉ đạo') !!}
        {!! Form::textarea('content', $row->content,
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung chỉ đạo')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Thuộc kết luận') !!}
        {!! Form::select('source', $source, $row->source,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Đơn vị chủ trì') !!}
        {!! Form::select('firtunit', $firstunit,$row->unit,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Đơn vị Phối hợp') !!}
        <ul>
            @foreach ($secondunit as $id=>$r1)
                <li>{!! Form::checkbox('secondunit[]', $id, in_array($id,$dtfollow)) !!} {{ $r1 }}</li>
            @endforeach
        </ul>
    </div>
    <div class="form-group">
        {!! Form::label('Thời gian hoàn thành') !!}
        {!! Form::text('deathline', "",
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Thời gian hoàn thành')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Đơn vị Xác nhận') !!}

    </div>

    <div class="form-group">
        {!! Form::label('Theo dõi của văn phòng') !!}
        {!! Form::textarea('note', $row->note,
            array('no-required',
                  'class'=>'form-control',
                  'placeholder'=>'Theo dõi của văn phòng')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Đánh giá') !!}

    </div>

    <div class="form-group">
        {!! Form::submit('Cập nhật',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
    @endforeach

@stop