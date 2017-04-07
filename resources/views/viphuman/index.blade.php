@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    @if(\App\Roles::checkPermission())
    <script language="javascript">
        function removebyid(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("nguoidung_id").value = id;
                frmdelete.submit();
            }
        }
    </script>
    <div class="text-center title">Người chủ trì</div>
    {{ Html::linkAction('ViphumanController@edit', 'Thêm người chủ trì', array('id'=>0), array('class' => 'btn btn-my')) }}

    {!! Form::open(array('route' => 'viphuman-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
        {{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
        {!! Form::close() !!}
    @endif

    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th> Tên lãnh đạo <br />
                <input type="text" style="max-width: 150px"></th>
            <th> Chức vụ <br />
                <input type="text" style="max-width: 150px"></th>
            @if(\App\Roles::checkPermission())
                <th>  </th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($nguoidung as $row)
            <tr>
                <td> {{$row->name}} </td>
                <td> {{$row->description}} </td>
                @if(\App\Roles::checkPermission())
                    <td>
                        <a href="{{$_ENV['ALIAS']}}/viphuman/update?id={{$row->id}}"><img height="16" border="0" src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
                        <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop