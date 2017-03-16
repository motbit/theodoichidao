@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <script language="javascript">
        function removebyid(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("nguoidung_id").value = id;
                frmdelete.submit();
            }
        }
    </script>

    <div>
        <div class="pull-left">
            <a href="viphuman/update?id=0"><i class="fa fa-plus"></i> Thêm mới</a>
        </div>
        <div class="pull-right">
            <form class="form" action="" method="get" id="searchform">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-content">
                            <input class="form-control" id="searchinput" type="text" name="k" value="{{$key}}" placeholder="Search username">
                        </div>
                        <div class="input-group-btn">
                            <button type="submit" value="search" class="btn btn-default" tabindex="-1"><i class="fa fa-search"></i>&nbsp;Search</button>
                        </div>
                    </div><!--end .input-group -->
                </div>
            </form>
        </div>
    </div>

    {!! Form::open(array('route' => 'viphuman-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
    {!! Form::close() !!}

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th> STT </th>
            <th> Tên lãnh đạo </th>
            <th> Chức vụ </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($nguoidung as $row)
            <tr>
                <td>
                    <a href="/viphuman/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
                    <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
                </td>
                <td> {{$row->name}} </td>
                <td> {{$row->description}} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop