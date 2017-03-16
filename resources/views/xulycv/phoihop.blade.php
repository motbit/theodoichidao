@extends('layout1')

@section('page-title')
    Công việc phối hợp
@stop

@section('content')
    <h1>Công việc phối hợp</h1>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th> Nội dung công việc </th>
            <th> Nguồn chỉ đạo </th>
            <th> Đơn vị đầu mối</th>
            <th> Đơn vị phối hợp </th>
            <th> Thời hạn HT </th>
            <th> Theo dõi của VP </th>
            <th> Đánh giá </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $row)
            <tr>
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
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/Y') }}</td>
                <td> {{$row->note}} </td>
                <td>
                    @if($row->status === 1)
                        <span class="label label-sm label-success"> Hoành thành </span>
                    @elseif($row->status === 0)
                        <span class="label label-sm label-warning"> Không hoàn thành </span>
                    @elseif($row->status === -1)
                        <span class="label label-sm label-danger"> Hủy </span>
                    @else
                        <span class="label label-sm label-info"> Mới </span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop