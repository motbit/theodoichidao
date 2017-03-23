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

{{--    <div>
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
        @if(\App\Roles::checkPermission())
            <div class="pull-left" style="margin-bottom: 10px">
                <a href="viphuman/update?id=0" class="btn btn-my"><i class="fa fa-plus"></i> Thêm mới</a>
            </div>
        @endif
    </div>--}}

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
                        <a href="/viphuman/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
                        <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop