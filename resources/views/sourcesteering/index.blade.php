@extends('layout1')
@section('content')
    <h1>Nguồn chỉ đạo</h1>
    <a class="btn btn-default" href="sourcesteering/update?id=0">Thêm nguồn chỉ đạo</a>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th>Nguồn chỉ đạo</th>
            <th>Loại</th>
            <th>Kí hiệu</th>
            <th>Người chủ trì</th>
            <th>File đính kèm</th>
            <th>Hoàn thành</th>
            <th>Ngày ban hành</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{$row->name}}</td>
                <td>{{$row->typename}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->conductorname}}</td>
                <td>
                    @if($row->file_attach != '')
                    <a href="/file/{{$row->file_attach}}" download>Tải về</a>
                    @endif
                </td>
                <td><input type="checkbox" value="{{$row->id}}"></td>
                <td>{{date("d-m-Y", strtotime($row->time))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop