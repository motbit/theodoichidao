<?php \App\Roles::accessView(Request::path()); ?>
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
        select {
            height: 23px;
        }

        input {
            height: 23px;
        }
    </style>


    {!! Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')) !!}
    {{ Form::hidden('id', 0, array('id' => 'steering_id')) }}
    {!! Form::close() !!}

    <div class="text-center title">Nguồn chỉ đạo</div>
    @if(\App\Roles::accessAction(Request::path(), 'add'))
    <a class="btn btn-my" href="sourcesteering/update?id=0">Thêm nguồn</a>
    @endif
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Trích yếu<br><input type="text" style="width: 100%"></th>
            <th class="td-type">Loại nguồn
                <select style="max-width: 150px">
                    <option value=""></option>
                    @foreach($type as $t)
                        <option value="{{$t->name}}">{{$t->name}}</option>
                    @endforeach
                </select>
            </th>
            <th class="td-code">Số kí hiệu<input type="text" style="max-width: 100px"></th>
            <th class="td-sign">Người ký
                <input type="text" style="max-width: 100px">
            </th>
            <th class="text-center align-top">File</th>
            <th class="td-date">Ngày ban hành
                <input type="text" class="datepicker" style="max-width: 100px">
            </th>
            @if(\App\Roles::checkPermission())
                <th class="td-action"></th>
                <th class="td-action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $idx=>$row)
            @if(\App\Roles::accessRow(Request::path(), $row->created_by))
            <tr>
                <td>{{$idx + 1}}</td>
                <td><a href="steeringcontent?source={{$row->id}}">{{$row->name}}</a></td>
                <td>{{$row->typename}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->sign_by}}</td>
                <td class="text-center td-file">
                    @if($row->file_attach != '')
                        <a href="/file/{{$row->file_attach}}" download>Tải về</a>
                    @endif
                </td>
                <td>{{date("d/m/Y", strtotime($row->time))}}</td>
                @if(\App\Roles::accessAction(Request::path(), 'edit'))
                    <td>
                        <a href="/sourcesteering/update?id={{$row->id}}"><img height="20" border="0"
                                                                              src="/img/edit.png"></a>
                    </td>
                @endif
                @if(\App\Roles::accessAction(Request::path(), 'delete'))
                    <td>
                        <a href="javascript:xoanguoidung('{{$row->id}}')"><img height="20" border="0"
                                                                               src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@stop