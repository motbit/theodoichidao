@extends('layout1')
@section('content')
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }


        }
    </script>


    {!! Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')) !!}
    {{ Form::hidden('id', 0, array('id' => 'steering_id')) }}
    {!! Form::close() !!}

    <h1>Nguồn chỉ đạo</h1>
    <a class="btn btn-default" href="sourcesteering/update?id=0">Thêm nguồn chỉ đạo</a>
    <table class="table table-responsive table-bordered">
        <thead>
        <tr>
            @if(\App\Roles::checkPermission())
                <th></th>
            @endif
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

                @if(\App\Roles::checkPermission())
                    <td class="col-action">
                        <a href="/sourcesteering/update?id={{$row->id}}"><img src="/img/edit.png"></a>
                        <a href="javascript:xoanguoidung('{{$row->id}}')"><img src="/img/delete.png"></a>
                    </td>
                @endif

                <td>{{$row->name}}</td>
                <td>{{$row->typename}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->conductorname}}</td>
                <td class="text-center">
                    @if($row->file_attach != '')
                        <a href="/file/{{$row->file_attach}}" download>Tải về</a>
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