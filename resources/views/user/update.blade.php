@extends('layout1')

@section('page-title')
    Update User
@stop

@section('content')
    <div class="text-center title">Cập nhật thông tin Người sử dụng</div>

    @if ( $errors->count() > 0 )
        @foreach( $errors->all() as $message )
            <p class="alert alert-danger">{{ $message }}</p>
        @endforeach
    @endif

    @foreach ($nguoidung as $row)
        {!! Form::open(array('route' => 'user-update', 'class' => 'form', 'autocomplete'=>'off')) !!}
        {{ Form::hidden('id', $row->id, array('id' => 'nguoidung_id')) }}
        <div class="form-group form-inline">
            <label>Tên đăng nhập: <span class="required">(*)</span></label>
            {!! Form::text('username', $row->username,
                array('readonly',
                      'class'=>'form-control',
                      'placeholder'=>'Tên đăng nhập')) !!}
        </div>



        <div class="form-group form-inline">
            <label>Mật khẩu: <span class="required">(*)</span></label>
            <input type="text" class="form-control" name="password" autocomplete="off">
            <em>* Để trống nếu không thay đổi.</em>
        </div>



        <div class="form-group form-inline">
            <label>Họ & tên: <span class="required">(*)</span></label>
            {!! Form::text('fullname', $row->fullname,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>'Nhập tên')) !!}
        </div>

        <div class="form-group">
            <label>Quyền hạn:</label>
            {!! Form::select('group', $group, $row->group,
                    array('no-required','class'=>'form-control select-single ipw',
                    'style'=>'max-width: 200px')
            ) !!}
        </div>

        <div class="form-group form-inline">
            <label>Đơn vị:</label>
            {!! Form::select('unit', $unit, $row->unit,
                    array('no-required','class'=>'form-control select-single ipw',
                    'style'=>'max-width: 200px')
            ) !!}
        </div>

        <div class="form-group form-inline">
            <label>Thư kí của:</label>
            <select name="conductor" class="form-control select-single ipw" style="max-width: 200px">
                <option value=""></option>
                @foreach($viphuman as $key=>$v)
                    <option value="{{$v->id}}" {{($row->conductor == $v->id)?'selected':''}}>{{$v->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {!! Form::submit('Cập nhật',
              array('class'=>'btn btn-my')) !!}
        </div>
        {!! Form::close() !!}
    @endforeach

    <script>
        $(".select-single").select2();
        $("input[name='password']").focus(function() {
           $(this).attr('type', 'password');
        });
//        $("input[name='password']").attr('type', 'password');
    </script>
@stop