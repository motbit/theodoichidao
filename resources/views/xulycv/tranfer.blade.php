@extends('layout1')

@section('page-title')
    Nhiệm vụ chuyển/nhận
@stop

@section('content')
    <div class="text-center title">Danh sách nhiệm vụ chuyển nhận</div>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-send">Nhiệm vụ đã chuyển ({{count($send)}})</a></li>
        <li><a data-toggle="tab" href="#tab-receive">Nhiệm vụ đã nhận ({{count($receive)}})</a></li>
    </ul>
    <div class="tab-content">
        <div id="tab-send" class="tab-pane fade in active">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Nhiệm vụ</th>
                    <th style="min-width: 120px">Người nhận</th>
                    <th style="min-width: 150px">Ghi chú</th>
                    <th style="min-width: 00px">Thời gian</th>
                </tr>
                </thead>
                <tbody>
                @foreach($send as $idx=>$row)
                <tr>
                    <td>{{$idx + 1}}</td>
                    <td>{{$row->steering_name}}</td>
                    <td>{{(array_key_exists($row->receiver, $user))?$user[$row->receiver]:""}}</td>
                    <td>{{$row->note}}</td>
                    <td>{{date("d/m/y", strtotime($row->time_log))}}</td>
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
                    <th style="min-width: 120px">Người chuyển</th>
                    <th style="min-width: 150px">Ghi chú</th>
                    <th style="min-width: 00px">Thời gian</th>
                </tr>
                </thead>
                <tbody>
                @foreach($receive as $idx=>$row)
                    <tr>
                        <td>{{$idx + 1}}</td>
                        <td>{{$row->steering_name}}</td>
                        <td>{{(array_key_exists($row->sender, $user))?$user[$row->sender]:""}}</td>
                        <td>{{$row->note}}</td>
                        <td>{{date("d/m/y", strtotime($row->time_log))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop