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
        {!! Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')) !!}

        <div class="form-group">
            {!! Form::label('Nội dung chỉ đạo') !!}
            {!! Form::textarea('content', "",
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nội dung chỉ đạo')) !!}
        </div>
    <div class="form-group">
        {!! Form::label('Thuộc kết luận') !!}
        {!! Form::select('source', $source,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Đơn vị chủ trì') !!}
        {!! Form::select('firtunit', $firstunit,
                array('no-required','class'=>'form-control')
        ) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Đơn vị Phối hợp') !!}
        <ul>
            @foreach ($secondunit as $id=>$row)
            <li>{!! Form::checkbox('secondunit[]', $id, false) !!} {{ $row }}</li>
        @endforeach
        </ul>
    </div>
    <div class="form-group  form-inline">
        {!! Form::label('Thời gian hoàn thành') !!}
        {!! Form::text('deathline', "",
            array('required',
                  'class'=>'form-control datepicker',
                  'placeholder'=>'Thời gian hoàn thành')) !!}
    </div>

        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}

<script>
    $( document ).ready(function() {
        // Handler for .ready() called.
        $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
    });
</script>
@stop