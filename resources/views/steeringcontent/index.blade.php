@extends('layout1')

@section('page-title')
    Danh mục nhiệm vụ
@stop

@section('content')

    <div class="text-center title">Danh mục nhiệm vụ</div>

    @if ($steering != false)
        <p><u>Nguồn chỉ đạo:</u> [{{$steering->code}}] - {{$steering->name}}</p>
    @endif
    @if(\App\Roles::checkPermission())
        {{ Html::linkAction('SteeringcontentController@edit', 'Thêm nhiệm vụ', array('id'=>0), array('class' => 'btn btn-my')) }}

        <script language="javascript">
            function removebyid(id) {

                if (confirm("Bạn có muốn xóa?")) {
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
            <th></th>
            <th> Tên nhiệm vụ</th>
            <th> Nguồn chỉ đạo</th>
            <th> Đơn vị đầu mối</th>
            <th> Đơn vị phối hợp</th>
            <th> Thời hạn HT</th>
            <th> Theo dõi của VP</th>
            @if(\App\Roles::checkPermission())
                <th class="td-action"></th>
                <th class="td-action"></th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($lst as $idx=>$row)
            <tr>
                <td>{{$idx + 1}}</td>
                <td> {{$row->content}} </td>
                <td> {{ $row->source }} </td>
                <td> {{ $row->unit }} </td>
                <td> {{ $row->follow }} </td>
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/Y') }}</td>
                <td> {{$row->note}} </td>
                {{--<td>--}}
                {{--@if($row->status === 1)--}}
                {{--<span class="label label-sm label-success"> Hoàn thành </span>--}}
                {{--@elseif($row->status === 0)--}}
                {{--<span class="label label-sm label-warning"> Chưa hoàn thành </span>--}}
                {{--@elseif($row->status === -1)--}}
                {{--<span class="label label-sm label-danger"> Hủy </span>--}}
                {{--@else--}}
                {{--<span class="label label-sm label-info"> Mới </span>--}}
                {{--@endif--}}
                {{--</td>--}}
                @if(\App\Roles::checkPermission())
                    <td>
                        <a href="/steeringcontent/update?id={{$row->id}}"><img height="20" border="0"
                                                                               src="/img/edit.png"></a>
                    </td>
                    <td>
                        <a href="javascript:removebyid('{{$row->id}}')"><img height="20" border="0"
                                                                             src="/img/delete.png"></a>
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@stop