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

    {{--{{ Html::linkAction('ViphumanController@edit', 'Thêm mới', array('id'=>0)) }}--}}

    <div>
        <div class="pull-left">
            <a href="viphuman/update?id=0"><i class="fa fa-plus"></i> Them moi</a>
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

    {!! Form::open(array('route' => 'viphuman-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')) !!}
    {{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
    {!! Form::close() !!}

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th> STT </th>
            <th> Tên lãnh đạo </th>
            <th> Chức vụ </th>
            <th> Action </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($nguoidung as $row)
            <tr>
                <td> {{$row->id}} </td>
                <td> {{$row->name}} </td>
                <td> {{$row->description}} </td>
                <td>
                    <a href="javascript:xoanguoidung('{{$row->id}}')"><i class="fa fa-pencil"></i> Xóa</a> |
                    {{ Html::linkAction('ViphumanController@edit', 'sửa', array('id'=>$row->id)) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop