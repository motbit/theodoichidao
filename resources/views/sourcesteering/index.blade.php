@extends('layout1')
@section('page-title')
    Nguồn chỉ đạo
@stop
@section('content')
    <script language="javascript">
        function xoanguoidung(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("steering_id").value = id;
                frmxoa.submit();
            }
        }

    </script>


    {!! Form::open(array('route' => 'sourcesteering-delete', 'class' => 'form', 'id' => 'frmxoa')) !!}
    {{ Form::hidden('id', 0, array('id' => 'steering_id')) }}
    {!! Form::close() !!}

    <div class="text-center title">Nguồn chỉ đạo</div>
    <a class="btn btn-my" href="sourcesteering/update?id=0">Thêm mới</a>
    <table id="table" class="table table-responsive table-bordered">
        <thead>
        <tr>
            @if(\App\Roles::checkPermission())
                <th></th>
            @endif
            <th>Trích yếu<input type="text"></th>
            <th>Loại nguồn
                <select>
                    <option value=""></option>
                    @foreach($type as $t)
                        <option value="{{$t->name}}">{{$t->name}}</option>
                    @endforeach
                </select>
            </th>
            <th>Số kí hiệu<input type="text"></th>
            <th>Người ký
                <select>
                    <option value=""></option>
                    @foreach($viphuman as $vip)
                    <option value="{{$vip->name}}">{{$vip->name}}</option>
                    @endforeach
                </select>
            </th>
            <th>File đính kèm</th>
            {{--<th>Hoàn thành</th>--}}
            <th>Ngày ban hành
                <input type="date">
            </th>
        </tr>
        </thead>
        {{--<tfoot>--}}
        {{--<tr>--}}
        {{--@if(\App\Roles::checkPermission())--}}
        {{--<th type="action"></th>--}}
        {{--@endif--}}
        {{--<th>Nguồn chỉ đạo</th>--}}
        {{--<th>Loại</th>--}}
        {{--<th>Kí hiệu</th>--}}
        {{--<th>Người chủ trì</th>--}}
        {{--<th>File đính kèm</th>--}}
        {{--<th>Hoàn thành</th>--}}
        {{--<th>Ngày ban hành</th>--}}
        {{--</tr>--}}
        {{--</tfoot>--}}
        <tbody>
        @foreach ($data as $row)
            <tr>

                @if(\App\Roles::checkPermission())
                    <td style="width: 30px">
                        <a href="/sourcesteering/update?id={{$row->id}}"><img height="16" border="0"
                                                                              src="/img/edit.png"></a>
                        <a href="javascript:xoanguoidung('{{$row->id}}')"><img height="16" border="0"
                                                                               src="/img/delete.png"></a>
                    </td>
                @endif

                <td><a href="steeringcontent?source={{$row->id}}">{{$row->name}}</a></td>
                <td>{{$row->typename}}</td>
                <td>{{$row->code}}</td>
                <td>{{$row->conductorname}}</td>
                <td class="text-center">
                    @if($row->file_attach != '')
                        <a href="/file/{{$row->file_attach}}" download>Tải về</a>
                    @endif
                </td>
                {{--<td class="text-center"><input type="checkbox" value="{{$row->id}}"--}}
                                               {{--disabled {{($row->status == 0)?'':'checked'}}></td>--}}
                <td>{{date("d-m-Y", strtotime($row->time))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop