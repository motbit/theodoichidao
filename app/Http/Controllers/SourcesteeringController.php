<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Sourcesteering;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class SourcesteeringController extends Controller
{
    public function index()
    {
        if (!\App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())) {
            return redirect('/errpermission');
        }
        $data = DB::table('sourcesteering')
            ->join('type', 'sourcesteering.type', '=', 'type.id')
            ->select('sourcesteering.*', 'type.name as typename')
            ->orderBy('id', 'desc')
            ->get();
        $type = DB::table('type')
            ->orderBy('_order', 'ASC')
            ->select('name')
            ->get();

        return view("sourcesteering/index", ['data' => $data, 'type' => $type]);

    }

    public function edit(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login");
        }
        $type = DB::table('type')->orderBy('_order', 'ASC')->get();
        $conductor = DB::table('viphuman')->get();
        $id = intval($request->input('id'));
        if ($id > 0) {
            $steering = DB::table('sourcesteering')
                ->where('id', '=', $id)
                ->get()->first();
            return view("sourcesteering/add", ['type' => $type, 'conductor' => $conductor, 'id' => $id, 'steering' => $steering]);
        } else {
            return view("sourcesteering/add", ['type' => $type, 'conductor' => $conductor, 'id' => $id]);
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login");
        }
        $messages = [
            'name.required' => 'Yêu cầu nhập trích yếu',
            'type.required' => 'Yêu cầu chọn loại nguồn.',
            'code.required' => 'Yêu cầu nhập mã kí hiệu.',
            'code.unique' => 'Ký hiệu đã tồn tại.',
        ];

        $id = intval($request->input('id'));
//        dd($request->file('docs'));
        $status = 0;
        $file_attach = "";
        $file = $request->file('docs');
        if (isset($file)) {
            $file_attach = $request->input('code') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file_attach = str_replace("/", "-", $file_attach);

        }
        if ($request->input('complete') != null) {
            $status = 1;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'code' => 'required|unique:sourcesteering,code,' . $id,
        ], $messages);
        if ($id > 0) {
            if ($validator->fails()) {
                return redirect()->action('SourcesteeringController@update', ["id" => $id])
                    ->withErrors($validator)
                    ->withInput();
            }

        } else {
            if ($validator->fails()) {
                return redirect()->action('SourcesteeringController@update')
                    ->withErrors($validator)
                    ->withInput();
            }

        }

        if ($id > 0) {
            $update = [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
                'sign_by' => $request->input('sign_by'),
                'status' => $status,
                'time' => Utils::dateformat($request->input('time'))
            ];
            if (isset($file)) {
                $update['file_attach'] = $file_attach;
            }
            $result = Sourcesteering::where('id', $id)->update($update);
        } else {
            $result = Sourcesteering::insert([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
                'sign_by' => $request->input('sign_by'),
                'file_attach' => $file_attach,
                'status' => $status,
                'time' => Utils::dateformat($request->input('time')),
                'created_by' => Auth::user()->id
            ]);
        }
        if (isset($file)) {
            $destinationPath = 'file';
            $file->move($destinationPath, $file_attach);
        }
        if ($result) {
            return redirect()->action(
                'SourcesteeringController@index', ['add' => 1]
            );
        } else {
            return redirect()->action(
                'SourcesteeringController@index', ['error' => 1]
            );
        }
    }

    public function apiAddSource(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['result' => false, 'mess' => 'Chưa đăng nhập']);
        }
        $messages = [
            'name.required' => 'Yêu cầu nhập trích yếu',
            'type.required' => 'Yêu cầu chọn loại nguồn.',
            'code.required' => 'Yêu cầu nhập mã kí hiệu.',
            'code.unique' => 'Ký hiệu đã tồn tại.',
        ];

        $status = 0;
        $file_attach = "";
        $file = $request->file('docs');
        if (isset($file)) {
            $file_attach = $request->input('code') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file_attach = str_replace("/", "-", $file_attach);

        }
        if ($request->input('complete') != null) {
            $status = 1;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'code' => 'required|unique:sourcesteering'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['result' => false, 'mess' => implode(',', $validator->errors()->all())]);
        }


        $result = Sourcesteering::insert([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'code' => $request->input('code'),
            'sign_by' => $request->input('sign_by'),
            'file_attach' => $file_attach,
            'status' => $status,
            'time' => Utils::dateformat($request->input('time')),
            'created_by' => Auth::user()->id
        ]);
        if (isset($file)) {
            $destinationPath = 'file';
            $file->move($destinationPath, $file_attach);
        }
        if ($result) {
            return response()->json(['result' => true, 'mess' => 'Thêm thành công']);
        } else {
            return response()->json(['result' => false, 'mess' => 'Thêm thất bại']);
        }
    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login");
        }
        $result = Sourcesteering::where('id', $request->input('id'))->delete();
        if ($result) {
            return redirect()->action(
                'SourcesteeringController@index', ['add' => 1]
            );
        } else {
            return redirect()->action(
                'SourcesteeringController@index', ['error' => 1]
            );
        }
    }

    #endregion


}


