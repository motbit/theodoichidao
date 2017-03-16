@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <script language="javascript">
        function xoanguoidung(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("nguoidung_id").value = id;
                frmxoanguoidung.submit();
            }


        }
    </script>

<h1>Người sử dụng</h1>

{{ Html::linkAction('UserController@edit', 'Thêm người sử dụng', array('id'=>0), array('class' => 'btn btn-default')) }}

{!! Form::open(array('route' => 'user-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')) !!}
{{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
{!! Form::close() !!}

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Username </th>
        <th> Tên đầy đủ </th>
        <th> Ngày tạo </th>
        <th> </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($nguoidung as $row)
    <tr>
        <td> {{$row->id}} </td>
        <td> {{$row->username}} </td>
        <td> {{$row->fullname}} </td>
        <td> {{$row->created_at}} </td>
        <td><a href="javascript:xoanguoidung('{{$row->id}}')">xóa</a> | {{ Html::linkAction('UserController@edit', 'cập nhật', array('id'=>$row->id)) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop