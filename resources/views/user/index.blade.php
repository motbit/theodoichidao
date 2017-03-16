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

    {{ Html::linkAction('UserController@edit', 'Thêm mới', array('id'=>0)) }}

{!! Form::open(array('route' => 'user-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')) !!}
{{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
{!! Form::close() !!}

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Username </th>
        <th> Fullname </th>
        <th> Date </th>
        <th> Status </th>
        <th>  </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($nguoidung as $row)
    <tr>
        <td> {{$row->id}} </td>
        <td> {{$row->username}} </td>
        <td> {{$row->fullname}} </td>
        <td> {{$row->created_at}} </td>
        <td>
            @if($row->status === 1)
                <span class="label label-sm label-success"> Approved </span>
            @elseif($row->status === 0)
                <span class="label label-sm label-danger"> Disable </span>
            @endif
        </td>
        <td><a href="javascript:xoanguoidung('{{$row->id}}')">xóa</a> | {{ Html::linkAction('UserController@edit', 'cập nhật', array('id'=>$row->id)) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop