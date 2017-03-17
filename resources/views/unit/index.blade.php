@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <h1>Ban / Đơn vị</h1>
@if(\App\Roles::checkPermission())
{{ Html::linkAction('UnitController@edit', 'Thêm Đơn vị', array('id'=>0), array('class' => 'btn btn-default')) }}

{!! Form::open(array('route' => 'unit-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
{{ Form::hidden('id', 0, array('id' => 'id')) }}
{!! Form::close() !!}
<script language="javascript">
    function removebyid(id) {

        if(confirm("Bạn có muốn xóa?")) {
            document.getElementById("id").value = id;
            frmdelete.submit();
        }


    }
</script>
    @endif
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        @if(\App\Roles::checkPermission())
        <th> </th>
        @endif
        <th> Tên đơn vị </th>
        <th> Tên viết tắt </th>
        <th> Sắp xếp </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lstunit as $row)
    <tr>
        @if(\App\Roles::checkPermission())
        <td>
            <a href="/unit/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
            <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
        </td>
        @endif
        <td> {{$row->name}} </td>
        <td> {{$row->shortname}} </td>
        <td> {{$row->order}} </td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop