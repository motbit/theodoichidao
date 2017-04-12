@extends('layout1')

@section('page-title')
    Người Dùng
@stop

@section('content')


    <div class="text-center title">Người sử dụng</div>
@if(\App\Roles::checkPermission())
{{ Html::linkAction('UserController@edit', 'Thêm người sử dụng', array('id'=>0), array('class' => 'btn btn-my')) }}

{!! Form::open(array('route' => 'user-delete', 'class' => 'form', 'id' => 'frmxoanguoidung')) !!}
{{ Form::hidden('id', 0, array('id' => 'nguoidung_id')) }}
{!! Form::close() !!}

<script language="javascript">
    function xoanguoidung(id) {

        if(confirm("Bạn có muốn xóa?")) {
            document.getElementById("nguoidung_id").value = id;
            frmxoanguoidung.submit();
        }


    }
</script>
@endif

    @if (Session::has('message'))
        <div class="alert alert-info">{!!  Session::get('message') !!}</div>
    @endif

<table id="table" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th> Username <br />
            <input type="text" style="max-width: 150px">
        </th>
        <th> Tên đầy đủ<br />
            <input type="text" style="max-width: 150px">
        </th>
        <th> Quyền Hạn<br />
            <input type="text" style="max-width: 150px"> </th>
        <th> Đơn vị<br />
            <input type="text" style="max-width: 150px"> </th>

        @if(\App\Roles::checkPermission())
            <th>  </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($nguoidung as $row)
    <tr>
        <td> {{$row->username}} </td>
        <td> {{$row->fullname}} </td>
        <td>
            @if (isset($group[$row->group]))
            {{$group[$row->group]}}
            @endif
        </td>
        <td>
            @if (isset($unit[$row->unit]))
            {{$unit[$row->unit]}}
            @endif
        </td>
        @if(\App\Roles::checkPermission())
            <td>
                <a href="{{ $app['url']->to('/') }}/user/update?id={{$row->id}}"><img height="16" border="0" src="{{ $app['url']->to('/img/edit.png') }}"></a>
                <a href="javascript:xoanguoidung('{{$row->id}}')"><img height="16" border="0" src="{{ $app['url']->to('/img/delete.png') }}"></a>
            </td>
        @endif
    </tr>
    @endforeach
    </tbody>
</table>
    <script>
        $(document).ready(function () {
            // DataTable
            var table = $('#table').DataTable({
                dom: 'Bfrtip',
                bSort: false,
                bLengthChange: false,
                "pageLength": 20,
                "language": {
                    "url": "{{$_ENV['ALIAS']}}/js/datatables/Vietnamese.json"
                }
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.header()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
                $('select', this.header()).on('change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value ? '^' + this.value + '$' : '', true, false).draw();
                    }
                });
            });


        });

    </script>
@stop