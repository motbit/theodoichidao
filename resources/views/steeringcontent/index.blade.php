@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')
    <script language="javascript">
        function removebyid(id) {

            if(confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }


        }
    </script>

{{ Html::linkAction('SteeringcontentController@edit', 'Thêm mới', array('id'=>0)) }}

{!! Form::open(array('route' => 'steeringcontent-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
{{ Form::hidden('id', 0, array('id' => 'id')) }}
{!! Form::close() !!}

<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> # </th>
        <th> Nội dung công việc </th>
        <th> Nguồn chỉ đạo </th>
        <th> Đơn vị đầu mối</th>
        <th> Đơn vị phối hợp </th>
        <th> Thời hạn HT </th>
        <th> Theo dõi của VP </th>
        <th> Tình hình Thực Hiện </th>
        <th> Đánh giá </th>
        <th> XN </th>
        <th> </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($lst as $row)
    <tr>
        <td> {{$row->id}} </td>
        <td> {{$row->content}} </td>
        <td> {{ $source[$row->source] }} </td>
        <td> {{ $unit[$row->unit] }} </td>
        <td> {{$row->follow}} </td>
        <td> {{$row->deathline}} </td>
        <td> {{$row->note}} </td>
        <td>  </td>
        <td> {{$row->status}} </td>
        <td> {{$row->xn}} </td>
        <td><a href="javascript:removebyid('{{$row->id}}')">xóa</a> | {{ Html::linkAction('UnitController@edit', 'cập nhật', array('id'=>$row->id)) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@stop