@extends('layout1')

@section('page-title')
    Nhiệm vụ chuyển/nhận
@stop

@section('content')
    <div class="text-center title">Danh sách nhiệm vụ chuyển nhận</div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-send">Nhiệm vụ đã chuyển</a></li>
        <li><a data-toggle="tab" href="#tab-receive">Nhiệm vụ đã nhận</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-send" class="tab-pane fade in active">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Nhiệm vụ</th>
                    <th>Người nhận</th>
                    <th>Ghi chú</th>
                    <th>Thời gian</th>
                </tr>
                </thead>
                <tbody>
                @foreach($send as $idx=>$row)
                <tr>
                    <td>{{$idx + 1}}</td>
                    <td>{{$steering[$row->steering]}}</td>
                    <td>{{$user[$row->receiver]}}</td>
                    <td>{{$row->note}}</td>
                    <td>{{date("d/m/Y", strtotime($row->time_log))}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="tab-receive" class="tab-pane fade in">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Nhiệm vụ</th>
                    <th>Người nhận</th>
                    <th>Ghi chú</th>
                    <th>Thời gian</th>
                </tr>
                </thead>
                <tbody>
                @foreach($receive as $idx=>$row)
                    <tr>
                        <td>{{$idx + 1}}</td>
                        <td>{{$steering[$row->steering]}}</td>
                        <td>{{$user[$row->receiver]}}</td>
                        <td>{{$row->note}}</td>
                        <td>{{date("d/m/Y", strtotime($row->time_log))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop