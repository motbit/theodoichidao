@extends('layout1')
@section('content')

    <h1>Nguồn chỉ đạo</h1>
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
                <td class="text-center">
                    @if($row->file_attach != '')
                        <a href="{{$_ENV['ALIAS']}}/file/{{$row->file_attach}}" download>Tải về</a>
                    @endif
                </td>
                <td class="text-center"><input type="checkbox" value="{{$row->id}}"
                                               disabled {{($row->status == 0)?'':'checked'}}></td>
                <td>{{date("d-m-Y", strtotime($row->time))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop