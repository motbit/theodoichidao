@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')


<h1>Người sử dụng</h1>
@if(\App\Roles::checkPermission())
{{ Html::linkAction('UserController@edit', 'Thêm người sử dụng', array('id'=>0), array('class' => 'btn btn-default')) }}

{!! Form::open(array('route' => 'user-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')) !!}
{{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
{!! Form::close() !!}

<script language="javascript">
    function xoanguoidung(id) {

        if(confirm("Bạn có muốn xóa?")) {
            document.getElementById("nguoidung_id").value = id;
            frmxoanguoidung.submit();
        }


    }
</script>
@endif
<table class="table table-striped table-hover">
    <thead>
    <tr>
        @if(\App\Roles::checkPermission())
        <th>  </th>
        @endif
        <th> Username </th>
        <th> Tên đầy đủ </th>
        <th> Quyền Hạn </th>
        <th> Đơn vị </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($nguoidung as $row)
    <tr>
        @if(\App\Roles::checkPermission())
        <td>
            <a href="/user/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
            <a href="javascript:xoanguoidung('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
        </td>
        @endif
        <td> {{$row->username}} </td>
        <td> {{$row->fullname}} </td>
        <td>
            @if (isset($group[$row->group]))
            {{$group[$row->group]}}
            @endif
        </td>
        <td>
            @if (isset($unit[$row->unit]))
            {{$unit[$row->unit]}}
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop