@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')

<h1>Nội dung chỉ đạo</h1>

@if ($steering != false)
    <p><u>Nguồn chỉ đạo:</u> [{{$steering->code}}] - {{$steering->name}}</p>
    @endif
@if(\App\Roles::checkPermission())
{{ Html::linkAction('SteeringcontentController@edit', 'Thêm Nội dung Chỉ đạo', array('id'=>0), array('class' => 'btn btn-default')) }}

<script language="javascript">
    function removebyid(id) {

        if(confirm("Bạn có muốn xóa?")) {
            document.getElementById("id").value = id;
            frmdelete.submit();
        }


    }
</script>

{!! Form::open(array('route' => 'steeringcontent-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
{{ Form::hidden('id', 0, array('id' => 'id')) }}
{!! Form::close() !!}
@endif

{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--var table = $('#myTable').DataTable();--}}

        {{--$('#myTable tbody')--}}
                {{--.on( 'mouseenter', 'td', function () {--}}
                    {{--var colIdx = table.cell(this).index().column;--}}

                    {{--$( table.cells().nodes() ).removeClass( 'highlight' );--}}
                    {{--$( table.column( colIdx ).nodes() ).addClass( 'highlight' );--}}
                {{--} );--}}
    {{--} );--}}
{{--</script>--}}
{{--<style type="text/css">--}}
    {{--td.highlight {--}}
        {{--background-color: whitesmoke !important;--}}
    {{--}--}}
{{--</style>--}}
<table id="myTable" class="table table-bordered table-hover row-border hover order-column">
    <thead>
    <tr>
        @if(\App\Roles::checkPermission())
        <th></th>
        @endif
        <th> Nội dung công việc </th>
        <th> Nguồn chỉ đạo </th>
        <th> Đơn vị đầu mối</th>
        <th> Đơn vị phối hợp </th>
        <th> Thời hạn HT </th>
        <th> Theo dõi của VP </th>
        <th> Đánh giá </th>
        {{--<th> XN </th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach ($lst as $row)
    <tr>
        @if(\App\Roles::checkPermission())
        <td>
            <a href="/steeringcontent/update?id={{$row->id}}"><img height="16" border="0" src="/img/edit.png"></a>
            <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0" src="/img/delete.png"></a>
        </td>
        @endif
        <td> {{$row->content}} </td>
        <td> {{ $source[$row->source] }} </td>
        <td> {{ $unit[$row->unit] }} </td>
        <td>
            @foreach(explode(',', $row->follow) as $i)
                @if (isset($unit2[$i]))
                    {{$unit2[$i]}},
                @endif
            @endforeach
        </td>
        <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/Y') }}</td>
        <td> {{$row->note}} </td>
        <td>
            @if($row->status === 1)
                <span class="label label-sm label-success"> Hoàn thành </span>
            @elseif($row->status === 0)
                <span class="label label-sm label-warning"> Chưa hoàn thành </span>
            @elseif($row->status === -1)
                <span class="label label-sm label-danger"> Hủy </span>
            @else
                <span class="label label-sm label-info"> Mới </span>
            @endif
        </td>
        {{--<td> {{$row->xn}} </td>--}}
    </tr>
    @endforeach
    </tbody>
</table>
@stop