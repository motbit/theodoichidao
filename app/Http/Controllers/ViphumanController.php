<?php

namespace App\Http\Controllers;

use App\Chucnang;
use App\Constant;
use App\MLogs;
use App\Viphuman;
use Illuminate\Http\Request;
use App\Helper;
use Validator;

class ViphumanController extends Controller
{
    public function index(Request $request)
    {
        if (!\App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())) {
            return redirect('/errpermission');
        }
        $keyword = $request->input('k');
        $data = Viphuman::findAll($keyword);

        return view("viphuman/index")->with('nguoidung', $data)->with('key', $keyword);
    }

    public function edit(Request $request)
    {
        $id = intval($request->input('id'));
        if ($id > 0) {
            $data = Viphuman::where('id', $id)->get();
            $functions = Chucnang::findAll();
            return view("viphuman/update")->with('nguoidung', $data)->with('functions', $functions);
        } else {
            $functions = Chucnang::findAll();
            return view("viphuman/add")->with('functions', $functions);
        }
    }

    public function update(Request $request)
    {
        $id = intval($request->input('id'));
        $messages = [
            'name.required' => 'Yêu cầu nhập tên',
            'function.required' => 'Yêu cầu chọn chức vụ.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'function' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->action('ViphumanController@update', ["id" => $id])
                ->withErrors($validator)
                ->withInput();
        }

        if ($id > 0) {
            $result = Viphuman::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'function' => $request->input('function'),
            ]);
            MLogs::write(Constant::$ACTION_UPDATE, 'viphuman', $id, '');
            $data = Viphuman::where('id', $request->input('id'))->get();

            return redirect()->action(
                'ViphumanController@index', ['update' => $result]
            );
        } else {
            $result = Viphuman::insertGetId([
                'name' => $request->input('name'),
                'function' => $request->input('function'),
            ]);
            MLogs::write(Constant::$ACTION_CREATE, 'viphuman', $result, '');
            return redirect()->action(
                'ViphumanController@index', ['add' => 1]
            );
        }
    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {
        $vip = \DB::table('viphuman')->where('id', $request->input('id'))->first();
        $result = Viphuman::where('id', $request->input('id'))->delete();
        MLogs::write(Constant::$ACTION_DELETE, 'viphuman', $request->input('id'), 'Delete viphuman: ' . $vip->name);
        if ($result) {
            return redirect()->action(
                'ViphumanController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'ViphumanController@index', ['delete' => "0:" . $request->input('id')]
            );
        }

    }
    #endregion
}


