@extends('layout1')
@section('page-title')
    Nguồn chỉ đạo
@stop
@section('content')
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }
        }

    </script>
    <style>
        select{
            max-width: 150px;
        }
    </style>


    {!! Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')) !!}
    {{ Form::hidden('id', 0, array('id' => 'steering_id')) }}
    {!! Form::close() !!}

    <div class="text-center title">Nguồn chỉ đạo</div>
    <a class="btn btn-my" href="sourcesteering/update?id=0">Thêm nguồn</a>
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Trích yếu<br><input type="text" style="width: 100%" ></th>
            <th>Loại nguồn
                <select>
                    <option value=""></option>
                    @foreach($type as $t)
                        <option value="{{$t->name}}">{{$t->name}}</option>
                    @endforeach
                </select>
            </th>
            <th>Số kí hiệu<input type="text" style="max-width: 100px"></th>
            <th>Người ký
                <input type="text" style="max-width: 100px">
            </th>
            <th>File</th>
            <th>Ngày ban hành
                <input type="text" class="datepicker" style="max-width: 100px">
            </th>
            @if(\App\Roles::checkPermission())
                <th></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td><a href="steeringcontent?source={{$row->id}}">{{$row->name}}</a></td>
                <td>{{$row->typename}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->sign_by}}</td>
                <td class="text-center">
                    @if($row->file_attach != '')
                        <a href="/file/{{$row->file_attach}}" download>Tải về</a>
                    @endif
                </td>
                <td>{{date("d-m-Y", strtotime($row->time))}}</td>
                @if(\App\Roles::checkPermission())
                    <td style="width: 30px">
                        <a href="/sourcesteering/update?id={{$row->id}}"><img height="16" border="0"
                                                                              src="/img/edit.png"></a>
                        <a href="javascript:xoanguoidung('{{$row->id}}')"><img height="16" border="0"
                                                                               src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop