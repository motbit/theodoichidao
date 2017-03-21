@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <div class="text-center title">Ban / Đơn vị</div>
@if(\App\Roles::checkPermission())
{{ Html::linkAction('UnitController@edit', 'Thêm Đơn vị', array('id'=>0), array('class' => 'btn btn-my')) }}

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
<table id="table" class="table table-bordered table-hover">
    <thead>
    <tr>

        <th> Tên đơn vị <br />
            <input type="text" style="max-width: 150px"></th>
        <th> Tên viết tắt <br />
            <input type="text" style="max-width: 150px"></th>
        <th> Sắp xếp </th>
        @if(\App\Roles::checkPermission())
            <th> </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($lstunit as $row)
    <tr>
        <td> {{$row->name}} </td>
        <td> {{$row->shortname}} </td>
        <td> {{$row->order}} </td>
        @if(\App\Roles::checkPermission())
            <td>
                <a href="/unit/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
                <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
            </td>
        @endif
    </tr>
    @endforeach
    </tbody>
</table>
@stop