@extends('layout1')

@section('page-title')
    Nhóm quyền người dùng
@stop

@section('content')
    <div class="text-center title">Nhóm quyền người dùng</div>
    {{ Html::linkAction('GroupController@edit', 'Thêm nhóm', array('id'=>0), array('class' => 'btn btn-my')) }}

    {!! Form::open(array('route' => 'group-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removebyid(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }


        }
    </script>

    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th></th>
            <th>Nhóm</th>
            <th class="action"></th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($group as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->description}} </td>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/group/update?id={{$row->id}}"><img height="16" border="0"
                                                                                  src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
                </td>
                <td>
                    <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0"
                                                                         src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                </td>
                <td>
                    <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0"
                                                                         src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop