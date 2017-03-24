@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <div class="text-center title">Ban / Đơn vị</div>
@if(\App\Roles::checkPermission())
{{ Html::linkAction('UnitController@edit', 'Thêm đơn vị', array('id'=>0), array('class' => 'btn btn-my')) }}

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

        <ul class="nav nav-tabs">
            @foreach($treeunit as $idx=>$u)
                <li class="{{($idx == 0)?'active':''}}"><a data-toggle="tab" href="#first-{{$u->id}}">{{$u->name}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($treeunit as $idx=>$u)
                <div id="first-{{$u->id}}" class="tab-pane fade in {{($idx == 0)?'active':''}}">
                    <table class="table table-bordered">
                        <tr>
                            <th>Tên Ban - Đơn vị</th>
                            <th>Tên viết tắt</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($u->children as $c)
                            <tr>
                                <td>{{$c->name}}</td>
                                <td>{{$c->shortname}}</td>
                                <td><a href="/unit/update?id={{$c->id}}">
                                        <img height="20" border="0" src="/img/edit.png"></a>
                                </td>
                                <td>
                                    <a href="javascript:removebyid('{{$c->id}}')">
                                        <img height="20" border="0" src="/img/delete.png"></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endforeach
        </div>
@stop