@extends('layout1')

@section('page-title')
    Thêm mới nhiệm vụ
@stop
@section('page-toolbar')
@stop

@section('content')
    <div class="text-center title">Thêm mới nhiệm vụ</div>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {!! Form::open(array('route' => 'steeringcontent-update', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('Tên nhiệm vụ') !!}
        {!! Form::textarea('content', "",
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Nội dung chỉ đạo')) !!}
    </div>
    <div class="form-group form-inline">
        {!! Form::label('Nguồn chỉ đạo') !!}
        {!! Form::text('source', "",
                array('no-required','class'=>'form-control')
        ) !!}
        <div class="btn btn-default ico ico-search" data-toggle="modal" data-target="#modal-source"></div>
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

    <div id="modal-source" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Danh sách nguồn chỉ đạo</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        @foreach($sourcesteering as $s)
                            <tr>
                                <td><input type="checkbox" class="pick-source" value="{{$s->code}}"></td>
                                <td>{{$s->code}}</td>
                                <td>{{$s->name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Handler for .ready() called.
            $('.datepicker').datepicker({format: 'dd/mm/yyyy'});
        });
    </script>
@stop