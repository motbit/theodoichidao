@extends('layout1')

@section('page-title')
    Công việc mới được giao
@stop

@section('content')

    {!! Form::open(array('route' => 'xuly-nhancongviec', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('unit', 0, array('id' => 'unit') )}}
    {{ Form::hidden('steering', 0, array('id' => 'steering') ) }}
    {{ Form::hidden('status', 0 , array('id' => 'status')) }}
    {{ Form::hidden('user', Auth::user()->id) }}
    {!! Form::close() !!}
    <script language="javascript">
        function cvconfirm(unit,steering,status) {
            quest = "";

            if(status === 0) {
                quest = "từ chối công việc";
            } else {
                quest = "công việc";

            }

            if(confirm("Xác nhận " + quest + " ?")) {
                document.getElementById("unit").value = unit;
                document.getElementById("steering").value = steering;
                document.getElementById("status").value = status;
                frmdelete.submit();
            }


        }
    </script>

    <h1>Công việc mới được giao</h1>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th> Xác nhận </th>
            <th> Nội dung công việc </th>
            <th> Nguồn chỉ đạo </th>
            <th> Đơn vị đầu mối</th>
            <th> Đơn vị phối hợp </th>
            <th> Thời hạn HT </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $row)
            <tr>
                <td>
                    <a href="javascript:cvconfirm({{$data[0]->unit}},{{$data[0]->id}},1)"><img height="16" border="0" src="{{$_ENV['ALIAS']}}/img/check.png"></a>
                    <a href="javascript:cvconfirm({{$data[0]->unit}},{{$data[0]->id}},0)"><img height="16" border="0" src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                </td>
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
                <td> {{ Carbon\Carbon::parse($row->deadline)->format('d/m/y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop