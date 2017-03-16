@extends('layout1')

@section('page-title')
    Công việc mới được giao
@stop

@section('content')
    <h1>Công việc đầu mối</h1>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th> Nội dung công việc </th>
            <th> Nguồn chỉ đạo </th>
            <th> Đơn vị đầu mối</th>
            <th> Đơn vị phối hợp </th>
            <th> Thời hạn HT </th>
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
            </tr>
        @endforeach
        </tbody>
    </table>
@stop