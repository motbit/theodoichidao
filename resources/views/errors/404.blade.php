@extends('layouts.app')
@section('page-title')
    Trang yêu cầu không tồn tại!
@stop
@section('content')
<h2>Trang yêu cầu không tồn tại!</h2>
<h4>{{ $exception->getMessage() }}</h4>
@stop

