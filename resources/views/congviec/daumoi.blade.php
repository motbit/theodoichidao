@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <h1>Công việc đầu mối</h1>

    {{ Html::linkAction('SteeringcontentController@edit', 'Thêm Nội dung Chỉ đạo', array('id'=>0), array('class' => 'btn btn-default')) }}


    {!! Form::open(array('route' => 'steeringcontent-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {!! Form::close() !!}

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th></th>
            <th> Nội dung công việc </th>
            <th> Nguồn chỉ đạo </th>
            <th> Đơn vị đầu mối</th>
            <th> Đơn vị phối hợp </th>
            <th> Thời hạn HT </th>
            <th> Theo dõi của VP </th>
            <th> Đánh giá </th>
            <th> XN </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $row)
            <tr>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/congviec/daumoi?id={{$row->id}}"><img height="16" border="0" src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
                </td>

                <td> {{$row->content}} </td>
                <td> {{ $source[$row->source] }} </td>
                <td> {{ $unit[$row->unit] }} </td>
                <td>
                    @foreach(explode(',', $row->follow) as $i)
                        @if (isset($unit2[$i]))
                            {{$unit2[$i]}},
                        @endif
                    @endforeach
                </td>
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/y') }}</td>
                <td> {{$row->note}} </td>
                <td>
                    @if($row->status === 1)
                        <span class="label label-sm label-success"> Hoàn thành </span>
                    @elseif($row->status === 0)
                        <span class="label label-sm label-warning"> Không hoàn thành </span>
                    @elseif($row->status === -1)
                        <span class="label label-sm label-danger"> Hủy </span>
                    @else
                        <span class="label label-sm label-info"> Mới </span>
                    @endif
                </td>
                <td> {{$row->xn}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop