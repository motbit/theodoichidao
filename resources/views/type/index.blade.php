@extends('layout1')

@section('page-title')
    Loại nguồn chỉ đạo
@stop

@section('content')
    <div class="text-center title">Loại nguồn chỉ đạo</div>
    @if(\App\Roles::accessAction(Request::path(), 'add'))
        {{ Html::linkAction('TypeSourceController@edit', 'Thêm loại nguồn chỉ đạo', array('id'=>0), array('class' => 'btn btn-my')) }}
    @endif

    {!! Form::open(array('route' => 'type-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
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
            <th> Loại nguồn</th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($type as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->name}} </td>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/type/update?id={{$row->id}}"><img height="16" border="0"
                                                                                      src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
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