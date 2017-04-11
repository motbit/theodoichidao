@extends('layout1')

@section('page-title')
    Loại nguồn chỉ đạo
@stop

@section('content')
    <div class="text-center title">Loại nguồn chỉ đạo</div>
    @if(\App\Roles::accessAction(Request::path(), 'add'))
        {{ Html::linkAction('TypeSourceController@edit', 'Thêm loại nguồn chỉ đạo', array('id'=>0), array('class' => 'btn btn-my')) }}
    @endif

    {!! Form::open(array('route' => 'type-delete', 'class' => 'form', 'id' => 'frmdelete')) !!}
    {{ Form::hidden('id', 0, array('id' => 'id')) }}
    {!! Form::close() !!}
    <script language="javascript">
        function removebyid(id) {

            if (confirm("Bạn có muốn xóa?")) {
                document.getElementById("id").value = id;
                frmdelete.submit();
            }


        }
    </script>

    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th style="width: 2%"></th>
            <th> Loại nguồn</th>
            <th>Thứ tự</th>
            <th class="action"></th>
            <th class="action"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($type as $idx=>$row)
            <tr class="item" data-id="{{$row->id}}">
                <td><span class="ui-icon  ui-icon-arrow-4-diag"></span></td>
                <td> {{$row->name}} </td>
                <td class="order">{{$idx + 1}}</td>
                <td>
                    <a href="{{$_ENV['ALIAS']}}/type/update?id={{$row->id}}"><img height="16" border="0"
                                                                                      src="{{$_ENV['ALIAS']}}/img/edit.png"></a>
                </td>
                <td>
                    <a href="javascript:removebyid('{{$row->id}}')"><img height="16" border="0"
                                                                         src="{{$_ENV['ALIAS']}}/img/delete.png"></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script src="{{$_ENV['ALIAS']}}/js/jquery-ui-1.12.1.js"></script>
    <link href="{{$_ENV['ALIAS']}}/css/jquery-ui.css" rel="stylesheet">
    <script>
        $( function() {
            $( "tbody" ).sortable({
                update:function () {
                    var a = $('.item');
                    var listid = '';
                    $.each(a, function (i, v) {
                        listid += $(this).attr('data-id')+ "-";
                    })
                    listid = listid.substring(0, listid.length-1);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{$_ENV['ALIAS']}}/api/updatePosition",
                        type: 'POST',
                        dataType: 'json',
                        data: {_token: $('meta[name="csrf-token"]').attr('content'), listId:listid},
                        async: false,
                        success: function (result) {
                            alert(result.mess);
                            $.each($('.order'), function (i, v) {
                                this.innerHTML = i + 1;
                            })
                        },
                        error: function () {
                            alert("Xảy ra lỗi nội bộ");
                        },
                    });

                }
            });
        } );
    </script>
@stop