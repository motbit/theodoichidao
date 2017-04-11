@extends('layout1')

@section('page-title')
    Nhóm người sử dụng
@stop

@section('content')
    <div class="text-center title">Nhóm Người sử dụng</div>
    @if(\App\Roles::accessAction(Request::path(), 'add'))
        {{ Html::linkAction('GroupController@edit', 'Thêm nhóm Người sử dụng', array('id'=>0), array('class' => 'btn btn-my')) }}
    @endif

    {!! Form::open(array('route' => 'group-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removebyid(id) {

            if (confirm("Bạn có muốn xóa nhóm này?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }


        }
    </script>

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="action"></th>
            <th> Tên nhóm</th>
            <th class="action"></th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($group as $idx=>$row)
            @if (Session::has('gid') && Session::get('gid') == $row->id)
            <tr class="info">
            @else
            <tr>
            @endif
                <td>{{$idx + 1}}</td>
                <td> {{$row->description}} </td>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/group/update?id={{$row->id}}" title="Chỉnh sửa"><img height="16" border="0"
                                                                                  src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
                </td>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/group/permission?id={{$row->id}}" title="Cập nhật quyền"><img height="16" border="0"
                                                                                   src="{{$_ENV['ALIAS']}}/img/ico-role.ico"></a>
                </td>
                <td>
                    <a href="javascript:removebyid('{{$row->id}}')" title="Xóa"><img height="16" border="0"
                                                                         src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop